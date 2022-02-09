<?php
	// check if the HTTPS is not found to be "on" and redirect
	if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); //Tell the browser to redirect to the HTTPS URL.
		exit; //Prevent the rest of the script from executing.
	}

	session_start();

	// this gets called from ajax return (add_product.js)
	if (isset($_POST) && isset($_POST['action']) && $_POST['action'] == 'add_to_cart') // save product in SESSION
	{
		//echo "<br/>POST:<br/>";
		//echo var_dump($_POST);

		//check if session array has been set
		if (isset($_SESSION['cart']))
		{
			//echo "<br/>SESSION:<br/>";
			//echo var_dump($_SESSION);

			$product_ids = array(); //array for the product ids the be loaded
			
			//keep track of how mnay products are in the shopping cart
			$count = count($_SESSION['cart']);
			//echo "Cart count: ".$count."<br/><br/>";
			
			// create array for matching array keys to products id's
			$product_ids = array_column($_SESSION['cart'], 'name');

			// If product do not exist in array
			if (!in_array(filter_input(INPUT_POST, 'product'), $product_ids))
			{
				$_SESSION['cart'][$count] = array
				(
					'name' => $_POST['product'],
					'price' => $_POST['price'],
					'quantity' => 1
				);
			}
			else 
			{
				// product already exists, increase quantity
				// match array key to id of the product being added to the cart
				for ($idx = 0; $idx < count($product_ids); $idx++)
				{
					if ($product_ids[$idx] == filter_input(INPUT_POST, 'product'))
					{
						// add item quantity to the existing product in the array
						$_SESSION['cart'][$idx]['quantity'] += 1;
					}
				}
			}

		}
		else
		{
			// if shopping cart doesn't exist, create first product with array key 0
			// create array using submitted form data, start from key 0 and fill it with values
			$_SESSION['cart'][0] = array
			(
				'name' => $_POST['product'],
				'price' => $_POST['price'],
				'quantity' => 1
			);
		}
		exit; // do not load rest of the page
	}
	
	$config = include("config.php");
	include("php/db_connection.php");

//----------------------------------------------------------------------------------------------
//  WT2 BIF SS2018 Latosińska - Leithner
//	     ____             _          ___        _____             __       _  __
//	    / __ )____ ______(_)___ _   ( o )      / ___/__  ______  / /_____ | |/ /
//	   / __  / __ `/ ___/ / __ `/  / __ \/|    \__ \/ / / / __ \/ __/ __ `|   / 
//	  / /_/ / /_/ (__  / / /_/ /  / /_/  <    ___/ / /_/ / / / / /_/ /_/ /   |  
//	 /_____/\__,_/____/_/\__,_/   \____/\/   /____/\__, /_/ /_/\__/\__,_/_/|_|  
//												  /____/                        
//
//  date: 07.06.2018
//
//----------------------------------------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="de">
	<head>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="description" content="Webtechnologien 2 - Endprojekt">
		<meta name="author" content="Barbara Latosinska & Michael Leithner">
		
		<title>WT2 - Endprojekt</title>
		
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
	</head>

<?php	
	$debugMode = $config->debug;
	if ($debugMode)
	{
		echo date('Y.m.d H:i:s').'<br>';
		echo 'session id: '.session_id();
		//$sessionId = session_id();
	}
	
	$admin = 0;
	$currentUser = null;
	if (isset($_SESSION['user'])) // if a user logged in current session
	{
		$currentUser = $_SESSION['user'];
	}
	
	if ($debugMode)
	{
		echo '<br>current user: '.$currentUser;
	}
	
	$currentSection = 'Home';
	if (isset($_GET['section'])) // if section selected
	{
		$currentSection = $_GET['section'];
		$_SESSION['section'] = $currentSection;
	}
	else if (isset($_SESSION['section'])) 
	{
		$currentSection = $_SESSION['section']; 
	}
	
	if ($debugMode)
	{
		echo '<br>current section: '.$currentSection;
	}
?>
	<body class="container" onload="init();">
		<header>
			<?php include "php/header.php";?>
			<div id="login">
				<?php include "php/login.php";?>
			</div>
		</header>

		<div id="root"> <!-- TODO: replace "root" with "main" -->
			
			<div id="navi">
				<?php include "php/navi.php";?>
			</div>
			<div id="content">
				<?php include "php/content.php";?>
			</div>
			<!--<div id="footer">
				<?php /*include "php/footer.php";*/ ?>
			</div>-->
			<br style="clear:both;" />
		</div>
		
		<?php include "php/footer.php"; ?>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="js/upload_ajax.js"></script>
		<script src="js/form_check.js"></script>
		<script src="js/search.js"></script>
		<script src="js/vouchers.js"></script>
		<script src="js/activation.js"></script>
		<script src="js/add_product.js"></script>
		<script src="js/edit_product.js"></script>
		<script src="js/show_details.js"></script>
		<script src="js/delete_orderitem.js"></script>
		<script src="js/dragndrop.js"></script>
		<!--<script src="upload_ajax_jquery.js"></script>-->
	</body>
</html>