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
// set debug info:
error_reporting(E_ALL);
ini_set('display_errors', 1);

class db_connection
{
	private static $db_con = null;
	private static $initialized = false;

	private static function initialize ()
	{
		if (self::$initialized)
		{
			return;
		}
		
		self::$initialized = true;
	}
	
	private static function showError ($i_errorText)
	{
		echo '<div class="alert alert-danger">'.$i_errorText.'<br/>'
			.mysqli_error(self::$db_con).'<br/>'
			.mysqli_errno(self::$db_con).'<br/>'
			.'</div>';
	}
	
	private static function connect () // baut Verbindung zur DB auf
	{
		global $config;
		
		self::initialize();
		self::$db_con = new mysqli($config->db_host, $config->db_user, '', $config->db_name);
		if (self::$db_con->connect_error) //Check if connection is valid
		{
			//Add it up to the session, and redirect
			//$_SESSION['errormsg'] = "<div style='padding-left: 50px;color:#FF0000'>Cannot connect to specfied database!</div>";
			//session_write_close();
			//header("Location: install.php");
			//exit();
			echo '<div class="alert alert-danger">DB Connection could not be established!<br/>'
				//.mysql_error().'<br/>'
				//.mysql_errno().'<br/>'
				.mysqli_connect_error().'<br/>' . '</div>';
			die("Connection failed: " . $this->db_con->connect_error);
		}
		else
		{
			//if ($config->debug) echo '<div class="alert alert-success">DB Connection successfull!</div>';
		}
	}
	
	private static function disconnect () // schließt DB-Verbindung
	{
		self::initialize();
		if (self::$db_con != null)
		{
			mysqli_close(self::$db_con);
		}
	}
	
	private static function escapeString ($i_value)
	{
		self::initialize();
		// http://php.net/manual/de/function.htmlspecialchars.php
		return htmlspecialchars($i_value, ENT_QUOTES);
		// http://php.net/manual/de/function.htmlentities.php
		//return htmlEntities($i_value, ENT_QUOTES);
	}

	public static function checkLogin ($i_user, $i_password) // liefert ein Array an User-Objekten zurück
	{
		try
		{
			self::connect();
			//$result = mysqli_query(self::$db_con,
			//	"SELECT COUNT(*) as isOK FROM user WHERE username = '$i_user' AND pwd = '$i_password'");
			//$countUsers = mysqli_fetch_assoc($result);
			
			$stmt = self::$db_con->prepare(
				"SELECT COUNT(*) as isOK FROM user WHERE username=? AND pwd=? AND is_active=?");
			$escapedUser = self::escapeString($i_user);
			$val = true;
			$stmt->bind_param("ssi", $escapedUser, $i_password, $val);
			$stmt->execute();
			$result = $stmt->get_result();
			$countUsers = $result->fetch_assoc();
			return $countUsers;
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}

	public static function registerUser ($i_user, $i_password, $i_anrede, $i_vorname, $i_nachname, $i_adresse, $i_plz, $i_ort, $i_email, $i_isLdap) // nimmt Userdaten entgegen und legt neuen User an
	{
		try
		{
			self::connect();
			//$result = mysqli_query(self::$db_con,
			//	"INSERT INTO user VALUES ('$user', '$md5_password', '$vorname', '$nachname', '$email', false, '$isLdap')");
			
			$stmt = self::$db_con->prepare(
				"INSERT INTO user (username, pwd, anrede, vorname, nachname, adresse, plz, ort, email, zahlung, is_admin, is_ldap) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$i_user = self::escapeString($i_user);
			$i_anrede = self::escapeString($i_anrede);
			$i_vorname = self::escapeString($i_vorname);
			$i_nachname = self::escapeString($i_nachname);
			$i_adresse = self::escapeString($i_adresse);
			$i_plz = self::escapeString($i_plz);
			$i_ort = self::escapeString($i_ort);
			$i_email = self::escapeString($i_email);
			$zahlung = 3;
			$isAdmin = false;
			$stmt->bind_param("sssssssssiii", $i_user, $i_password, $i_anrede, $i_vorname, $i_nachname, $i_adresse, $i_plz, $i_ort, $i_email, $zahlung, $isAdmin, $i_isLdap);
			$result = $stmt->execute();
			return $result;
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}

	public static function updateUser ($i_password, $i_anrede, $i_vorname, $i_nachname, $i_adresse, $i_plz, $i_ort, $i_email, $i_zahlung, $i_currentUser)
	{
		try
		{
			self::connect();
			//$result = mysqli_query(self::$db_con,
			//	"UPDATE user SET pwd='$md5_password', vorname='$vorname', nachname='$nachname', email='$email' WHERE username='$currentUser'");
			
			$stmt = self::$db_con->prepare(
				"UPDATE user SET pwd=?, anrede=?, vorname=?, nachname=?, adresse=?, plz=?, ort=?, email=?, zahlung=? WHERE username=?");
			$i_currentUser = self::escapeString($i_currentUser);
			$i_anrede = self::escapeString($i_anrede);
			$i_vorname = self::escapeString($i_vorname);
			$i_nachname = self::escapeString($i_nachname);
			$i_adresse = self::escapeString($i_adresse);
			$i_plz = self::escapeString($i_plz);
			$i_ort = self::escapeString($i_ort);
			$i_email = self::escapeString($i_email);
			$i_currentUser = self::escapeString($i_currentUser);
			$stmt->bind_param("ssssssssis", $i_password, $i_anrede, $i_vorname, $i_nachname, $i_adresse, $i_plz, $i_ort, $i_email, $i_zahlung, $i_currentUser);
			$stmt->execute();
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}
	
	public static function setUserActive ($i_username, $i_val)
	{
		try
		{
			self::connect();
			
			$stmt = self::$db_con->prepare(
				"UPDATE user SET is_active=? WHERE username=?");
			$i_username = self::escapeString($i_username);
			$stmt->bind_param("is", $i_val, $i_username);
			$stmt->execute();
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}
	
	public static function getUserData ($i_currentUser)
	{
		//global $config;
		try
		{
			self::connect();
			//$result = mysqli_query(self::$db_con,
			//	"SELECT vorname, nachname, email FROM user WHERE username='$currentUser'");
			//--> not valid? if ($config->debug) echo "<script>console.log( 'result: " . $result . "' );</script>";
			//$userData = mysqli_fetch_assoc($result);
			
			$stmt = self::$db_con->prepare(
				"SELECT anrede, vorname, nachname, adresse, plz, ort, email, zahlung, is_admin FROM user WHERE username=?");
			$i_currentUser = self::escapeString($i_currentUser);
			$stmt->bind_param("s", $i_currentUser);
			$stmt->execute();
			$result = $stmt->get_result();
			$userData = $result->fetch_assoc();
			return $userData;
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}
	
	public static function getAllUser ()
	{
		try
		{
			self::connect();

			$stmt = self::$db_con->prepare("SELECT * FROM user");
			$stmt->execute();
			$result = $stmt->get_result();
			return $result;
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}

	public static function addProduct ($i_name, $i_category, $i_price, $i_description, $i_rating)
	{
		try
		{
			self::connect();
				
			$stmt = self::$db_con->prepare(
				"INSERT INTO products (name, category, price, description, rating) VALUES (?, ?, ?, ?, ?)");				
			$i_name = self::escapeString($i_name);
			$i_category = self::escapeString($i_category);
			$i_description = self::escapeString($i_description);	
			$stmt->bind_param("ssdsd", $i_name, $i_category, $i_price, $i_description, $i_rating);
			$productResult = $stmt->execute();
			return $productResult;
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}

	public static function editProduct ($i_category, $i_price, $i_description, $i_rating, $i_productName)
	{
		try
		{
			self::connect();
			
			$stmt = self::$db_con->prepare(
				"UPDATE products SET category=?, price=?, description=?, rating=? WHERE name=?");
			$i_category = self::escapeString($i_category);
			$i_description = self::escapeString($i_description);
			$i_productName = self::escapeString($i_productName);
			$stmt->bind_param("sdsds", $i_category, $i_price, $i_description, $i_rating, $i_productName);
			$stmt->execute();
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}


	public static function getProduct ($i_productName)
	{
		try
		{
			self::connect();

			$stmt = self::$db_con->prepare(
				"SELECT category, price, description, rating FROM products WHERE name=?");
			$i_productName = self::escapeString($i_productName);
			$stmt->bind_param("s", $i_productName);
			$stmt->execute();
			$result = $stmt->get_result();
			$userData = $result->fetch_assoc();
			return $userData;
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}

	public static function searchProduct ($keyword)
	{
		try
		{
			self::connect();

			$keyword = $_GET['keyword'];
			$keyword="%$keyword%";

			$stmt = self::$db_con->prepare(
				"SELECT name, category, price, description, rating FROM products WHERE name like ?");
			$keyword = self::escapeString($keyword);
			$stmt->bind_param("s", $keyword);
			$stmt->execute();
			$result = $stmt->get_result();
			//$userData = $result->fetch_assoc();
			return $result;
			
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}

	public static function getAllProducts ()
	{
		try
		{
			self::connect();

			$stmt = self::$db_con->prepare(
				"SELECT name, category, price, description, rating FROM products ORDER by name ASC");			
			$stmt->execute();
			$result = $stmt->get_result();
			//$userData = $result->fetch_assoc();
			return $result;
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}

	public static function deleteProduct ($i_productName)
	{
		try
		{
			self::connect();

			$stmt = self::$db_con->prepare(
				"DELETE FROM products WHERE name=?");
			$i_productName = self::escapeString($i_productName);
			$stmt->bind_param("s", $i_productName);
			$stmt->execute();
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}
	
	
	public static function addVoucher ($i_code, $i_value, $i_date)
	{
		try
		{
			self::connect();
				
			$stmt = self::$db_con->prepare(
				"INSERT INTO vouchers (code, status, value, date) VALUES (?, ?, ?, ?)");
			$status = 0;
			$i_date = date("Y-m-d", strtotime($i_date));
			$stmt->bind_param("sdds", $i_code, $status, $i_value, $i_date);
			$productResult = $stmt->execute();
			return true;
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
			return false;
		}
		finally
		{
			self::disconnect();
		}
	}

	public static function getVouchers ()
	{
		try
		{
			self::connect();

			$stmt = self::$db_con->prepare("SELECT * FROM vouchers ORDER BY date DESC");
			$stmt->execute();
			$result = $stmt->get_result();
			return $result;
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}
	
	public static function getValuefromVouchers ($i_voucher)
	{
		try
		{
			self::connect();

			if ($stmt = self::$db_con->prepare("SELECT value FROM vouchers WHERE code=? and status=0"))
			{
				$stmt->bind_param("s", $i_voucher);
				$stmt->execute();
				$result = $stmt->get_result();
				return $result;
			}
			else
			{
				return null;
			}
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}
	
	public static function redeemVoucher ($i_voucher)
	{
		try
		{
			self::connect();

			$stmt = self::$db_con->prepare(
				"UPDATE vouchers SET status=? WHERE code=?");
			$stmt->bind_param("is", 1, $i_voucher);
			$stmt->execute();
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}
	
	public static function getAllOrdersForUser ($i_user)
	{
		try
		{
			self::connect();

			$text = "SELECT * FROM orders";
			if ($i_user != "" && $i_user != "*")
			{
				$text .= " WHERE user = ?";
			}
			$text .= " ORDER BY date DESC, order_id DESC";
			$stmt = self::$db_con->prepare($text);
			if ($i_user != "" && $i_user != "*")
			{
				$stmt->bind_param("s", $i_user);
			}
			$stmt->execute();
			$result = $stmt->get_result();
			return $result;
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}

	public static function getAllDetails ()
	{
		try
		{
			self::connect();

			$stmt = self::$db_con->prepare(
				"SELECT fk_order, fk_product, count FROM order_product ORDER by id ASC");			
			$stmt->execute();
			$result = $stmt->get_result();
			
			return $result;			
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}

	public static function getAllDetailsForId ($i_id)
	{
		try
		{
			self::connect();

			$stmt = self::$db_con->prepare(
				"SELECT id, fk_product, count FROM order_product WHERE fk_order=?");			
			$stmt->bind_param("i", $i_id);
			$stmt->execute();
			$result = $stmt->get_result();
			
			return $result;			
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}
	
	public static function removeOrderItem ($i_id)
	{
		try
		{
			self::connect();
			
			$stmt = self::$db_con->prepare(
				"DELETE FROM order_product WHERE id=?");			
			$stmt->bind_param("i", $i_id);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result;
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
		}
		finally
		{
			self::disconnect();
		}
	}
	
	public static function placeOrder ($i_voucher)
	{
		$revtal = true;
		try
		{
			self::connect();
			
			$value = 0;
			if ($i_voucher != null)
			{
				if ($stmt = self::$db_con->prepare("SELECT value FROM vouchers WHERE code=? and status=0"))
				{
					$stmt->bind_param("s", $i_voucher);
					$stmt->execute();
					$result = $stmt->get_result();
					$value = $result->fetch_assoc();
					$stmt->close(); // or $mysqli->free();
				}
				else
				{
					echo "Invalid Voucher code!";
					return null;
				}
				
				if ($value == 0 || $value == null)
				{
					echo "Invalid Voucher code!";
					return null;
				}
			}
		
			$currentUser = $_SESSION['user'];
			
			// get order_id and username of the last entry
			$stmt = self::$db_con->prepare(
				"SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1");
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close(); // or $mysqli->free();

			// calc last order id
			$order_id = 1;
			if ($result->num_rows > 0) 
			{
				$row = $result->fetch_assoc();
				$order_id = $row['order_id'] + 1;
			}

			//save the order
			$stmt = self::$db_con->prepare(
				"INSERT INTO orders (order_id, user, date, fk_voucher) VALUES (?, ?, ?, ?)");
			$date = date('Y-m-d H:i:s');
			$stmt->bind_param('isss', $order_id, $currentUser, $date, $i_voucher);
			$stmt->execute();
			$stmt->close(); // or $mysqli->free();
			
			//Go through each product in the array
			foreach ($_SESSION['cart'] as $key => $product)
			{
				$query = self::$db_con->prepare(
					"INSERT INTO order_product (fk_order, fk_product, count) VALUES (?, ?, ?)");
				$productname = $product['name'].".jpg";
				$query->bind_param('isi', $order_id, $productname, $product['quantity']);
				$query->execute();
				$query->close();
				unset($_SESSION['cart'][$key]);
			}
			unset($_SESSION['cart']);
			 
			if ($i_voucher != null)
			{
				//self::redeemVoucher($i_voucher);
				$stmt = self::$db_con->prepare(
					"UPDATE vouchers SET status=? WHERE code=?");
				$status = 1;
				$stmt->bind_param("is", $status, $i_voucher);
				$stmt->execute();
				$stmt->close(); // or $mysqli->free();
			}
		}
		catch (Exception $e)
		{
			self::showError("DB Error:");
			$revtal = false;
		}
		finally
		{
			self::disconnect();
		}
		return $revtal;
	}
}
?>