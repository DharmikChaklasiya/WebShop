<?php

/*----------------------------------------------------------------------------------------------
WT2 BIF SS2018 Latosińska - Leithner
    ____             _          ___        _____             __       _  __
   / __ )____ ______(_)___ _   ( o )      / ___/__  ______  / /_____ | |/ /
  / __  / __ `/ ___/ / __ `/  / __ \/|    \__ \/ / / / __ \/ __/ __ `|   / 
 / /_/ / /_/ (__  / / /_/ /  / /_/  <    ___/ / /_/ / / / / /_/ /_/ /   |  
/_____/\__,_/____/_/\__,_/   \____/\/   /____/\__, /_/ /_/\__/\__,_/_/|_|  
                                             /____/                        

date: 08.06.2018

----------------------------------------------------------------------------------------------*/
$loadNav = function () use (&$config, &$admin, &$currentUser, &$loadNav)
{
	$xml = simplexml_load_file('navigation.xml'); //load the xml file using simplexml
	$xml_category = "anonym";
	if (isset($_SESSION["user"]))
	{
		if ($admin)
		{
			$xml_category = "admin";
		}
		else
		{
			$xml_category = "user";
		}
	}
	
	$config->sections = array(); // clear array... or unset($foo);
	foreach ($xml->{$xml_category}->section as $link) //For each link node read it as $link
	{
		array_push($config->sections, $link); // liest Navelemente / Sections aus xmldatei
	}
};

$login = function ($i_mode, $i_user, $i_password) use (&$config, &$login)
{
	// from UE1: manually checking password:
	if ($i_mode == 'hardcoded')
	{
		if ($i_user == $config->user && $i_password == $config->password) // login correct
		{
			//$currentUser = $user;
			return $user;
		}
	}
	// from UE2: login with secure ldap
	else if ($i_mode == 'ldap')
	{
		if ($config->debug)
		{
			ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
		}
		
		//unter Windows muss die Datei ldap.conf unter dem Pfad c:\openldap\sysconf liegen und die Zeile "TLS_REQCERT never" enthalten
		//putenv('LDAPTLS_REQCERT=never'); // no effect
		
		// LDAP-Login probieren
		//$user = strtolower($user);

		// LDAP connect
		$con = ldap_connect($config->ldap_path);
		if (!$con)
		{
		   echo "LDAP Connect-Error";
		   exit;
		}
	   
		// LDAP settings
		ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($con, LDAP_OPT_REFERRALS, 0);

		// LDAP bind
		$result = null;
		if (ldap_start_tls($con)) // verschlüsselte Verbindung verwenden
		{
			if ($config->debug)
			{
				echo "(Connection OK)<br>";
			}
			
			$dn = "ou=People,".$config->ldap_base;  // wo wird gesucht?
			if (@ldap_bind($con, "uid=".$i_user.",".$dn, $i_password))
			{
				// LDAP search (Suche am gebundenen Knoten)
				$filter = "(uid=$i_user)";
				//$currentUser = "";
				//$justthese = array("uid", "ou", "sn", "givenname", "mail"); // nur nach diesen Einträgen suchen
				$attributes = array("givenname", "sn", "mail");
				$searchResult = ldap_search($con, $dn, $filter, $attributes); // Suche wird durchgeführt
				//$info = ldap_get_entries($con, $searchResult);             // gefundene Einträge werden ausgelesen
				$result = ldap_get_entries($con, $searchResult);             // gefundene Einträge werden ausgelesen
			}
			ldap_close($con);
		}
		else if ($config->debug)
		{
			echo "(Connection ERROR)\n";
			return null;
		}
		
		if ($result != null && $result["count"] > 0)
		{
			if ($config->debug) echo "<br>".$result["count"]." entries returned<br>";
			//$idx_attr = 0;
			//for ($idx_data = 0; $idx_attr < $result[$idx_data]["count"]; $idx_attr++)
			$attributes = $result[0];
			for ($idx_attr = 0; $idx_attr < $attributes["count"]; $idx_attr++)
			{
				$data = $attributes[$idx_attr];
				if ($config->debug) echo $data . ": " . $attributes[$data][0]."<br>";
				//$currentUser = $currentUser . " " . $attributes[$data][0];
			}

			//return true;
			//return $currentUser;
			return $attributes;
		}
	}
	// from UE3: login with db
	else if ($i_mode == 'database')
	{
		$md5_password = md5($i_password);
		$countUsers = db_connection::checkLogin($i_user, $md5_password);
		if (/*$result && $result == true &&*/ $countUsers && $countUsers['isOK'] > 0) //$result->isOK > 0)
		{
			echo "<script>console.log( 'result: " . "valid" . "' );</script>";			
			//return $i_user; // TODO: or return vorname + nachname?
			return htmlspecialchars($i_user);
		}
		else
		{
			/*echo '<div class="alert alert-danger">DB Error in Login:<br/>'
			.mysqli_error($db_con).'<br/>'
			.mysqli_errno($db_con).'<br/>'
			.'</div>';*/
			
			// try ldap - if success insert into db
			//if ($login('ldap', $i_user, $i_password))
			$attributes = $login('ldap', $i_user, $i_password);
			if ($attributes != null)
			{
				$vorname = '';
				$nachname = '';
				$email = '';
				for ($idx_attr = 0; $idx_attr< $attributes["count"]; $idx_attr++)
				{
					$data = $attributes[$idx_attr];
					//echo "<script>console.log( 'attribute: " . $attributes[$data][0] . "' );</script>";
					
					if ($data == 'givenname')
					{	
						$vorname = $attributes[$data][0];
					}
					else if ($data == 'sn')
					{
						$nachname = $attributes[$data][0];
					}
					else if ($data == 'mail')
					{
						$email = $attributes[$data][0];
					}
				}	
				
				$result = db_connection::registerUser($i_user, $md5_password, $vorname, $nachname, $email, true);
				if ($result) // TODO: error handling
				{
					echo '<div class="alert alert-success">created User!</div>';
				}		
				//return $vorname . " " . $nachname;
				//return $i_user;
				return htmlspecialchars($i_user);
			}
		}
	}
	return null;
};

if (isset($_POST['submitbutton']))
{
	$button = $_POST['submitbutton'];
	if ($button == 'Logout')
	{
		$currentUser = null;
		$_SESSION['user'] = $currentUser;
		if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) // delete Cookies
		{
			setcookie('username', null, false, '/', 'localhost');
			setcookie('password', null, false, '/', 'localhost');
		}
	}
}
else if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) // saved user
{
	// TODO: login with cookie user and password -> update cookie at edit
	$currentUser = $_COOKIE['username'];
	$_SESSION['user'] = $currentUser;
}
else if (isset($_POST['user'])) // login input
{
	$user = $_POST['user'];
	if ($config->debug)
	{
		echo "<script>console.log( 'user in Post was set: " . $user . "');</script>";
	}

	if (isset($_POST['password'])) // password input
	{
		$password = $_POST['password'];

		$createUserError = false;
		if (isset($_POST['user_registration'])) // user registration input
		{
			if ($config->debug)
			{
				echo "<script>console.log( 'user_reg in Post was set. ' );</script>";
			}

			if ($_POST['password'] != $_POST['passwordConfirmation'])
			{
				echo '<div class="alert alert-danger">Confirm password!</div>';
			}
			else
			{
				$anrede = $_POST['anrede'];
				$vorname = $_POST['name'];
				$nachname = $_POST['surname'];
				$adresse = $_POST['adresse'];
				$plz = $_POST['plz'];
				$ort = $_POST['ort'];
				$email = $_POST['email'];
				$md5_password = md5($password);

				if ($config->debug)
				{
					echo "<script>console.log( 'anrede: " . $anrede . "' );</script>";
					echo "<script>console.log( 'vorname: " . $vorname . "' );</script>";
					echo "<script>console.log( 'nachname: " . $nachname . "' );</script>";
					echo "<script>console.log( 'adresse: " . $adresse . "' );</script>";
					echo "<script>console.log( 'plz: " . $plz . "' );</script>";
					echo "<script>console.log( 'ort: " . $ort . "' );</script>";
					echo "<script>console.log( 'md5_password: " . $md5_password . "' );</script>";
					echo "<script>console.log( 'currentUser: " . $currentUser . "' );</script>";
				}

				if ($currentUser != "") // registered user edit data
				{
					$zahlung = '';
					$userData = db_connection::getUserData(htmlspecialchars_decode($currentUser));
					if ($userData)
					{
						$zahlung = $userData['zahlung'];
						$admin = $userData['is_admin'];
						//echo "<script>console.log( 'zahlung: " . $zahlung . "' );</script>";
						if (isset($_POST['payment'])) 
						{
							$zahlung = $_POST['payment'];
						}
					}
					$countUsers = db_connection::checkLogin($user, $md5_password);
					if ($countUsers && $countUsers['isOK'] > 0)
					{
						echo "<script>console.log( 'result: " . "valid" . "' );</script>";
						$result = db_connection::updateUser($md5_password, $anrede, $vorname, $nachname, $adresse, $plz, $ort, $email, $zahlung, $currentUser);		
					}
					else
					{
						echo '<div class="alert alert-danger">Wrong password!</div>';
					}	
				}
				else
				{
					$result = db_connection::registerUser($user, $md5_password, $anrede, $vorname, $nachname, $adresse, $plz, $ort, $email, false);
				}

				// TODO: error handling
				if (isset($result) && $result)
				{
					echo '<div class="alert alert-success">created User!</div>';
				}
				else
				{
					$createUserError = true;
				}
			}
		}				
		
		if ($createUserError == false) // either not created or successfully created
		{
			$currentUser = $login($config->loginMode, $user, $password);
			if ($currentUser != null)
			{
				$_SESSION['user'] = $currentUser;
				if (isset($_POST['remember'])) // Set cookie to last 1 year
				{
					setcookie('username', $_POST['user'], time()+60*60*24*365, '/', 'localhost');
					setcookie('password', md5($_POST['password']), time()+60*60*24*365, '/', 'localhost');
				}
				
				//  Rückmeldung „eingeloggt“ 
				/*echo '<script language="javascript">';
				echo 'alert("eingeloggt");';
				echo '</script>';*/
			}
			else	// incorrect login data
			{
				echo '<div class="alert alert-danger">Invalid login!</div>';
			}
		}
	}
}

if (isset($currentUser))
{
	$userData = db_connection::getUserData(htmlspecialchars_decode($currentUser));
	if ($userData)
	{
		$admin = $userData['is_admin'];
	}
}
$loadNav();

if (in_array($currentSection, $config->sections) == false)
{
	//$currentSection = 'Home';
	//echo count($config->sections);
	$currentSection = $config->sections[0];
}

if (isset($currentUser) == false) // if logged out
{
?>
	<form name="form" enctype="multipart/form-data" method="post" action=<?php echo $_SERVER["PHP_SELF"]; ?> > <!--the website is loaded again-->
		<table>
		<tr>
			<td><p>username:&nbsp;</p></td>
			<td><input name="user" type="text" autocomplete="username"></td>
		</tr>
		<tr>
			<td><p>password:&nbsp;</p></td>
			<td><input name="password" type="password"></td>
		</tr>
		<tr>
			<td><input name="remember" type="checkbox"> </td>
			<td><p>remember me</p></td>
		</tr>
		</table>
		<input type="submit" value="Login">
	</form>

<?php
}
else // if logged in
{
	echo '<p>welcome&nbsp;'.$currentUser;
	if ($admin)
	{
		echo " ADMIN";
	}
	echo '</p>';
?>
	<form name="form" method="post" action=<?php echo $_SERVER["PHP_SELF"]; ?> >
		<input type="submit" name="submitbutton" value="Logout">
	</form>
<?php
}
?>

<!-- Registration form -->
<?php 
if (!isset($currentUser))
{
?>

	<p class="pointer" data-toggle="modal" data-target="#myModal">New user registration</p>
		
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">New user registration</h4>
				</div>
				
				<div id="modal" class="modal-body">
					<?php include "php/registration.php";?>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
<?php
}
?>