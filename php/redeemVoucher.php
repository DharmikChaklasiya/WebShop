<?php
if (isset($_POST['action']) && $_POST['action'] == "redeemVoucher")
{
	//Include database
    $config = include("../config.php");
    include("db_connection.php");
	
	$result = db_connection::getValuefromVouchers($_POST['code']);
	if ($result)
	{
		$value = $result->fetch_assoc();		
		if ($value)
		{
			//print_r($value);
			echo implode($value);
		}
		else
		{
			echo "Invalid Voucher code!";
		}
	}
	else
	{
		echo "Invalid Voucher code!";
	}
}
?>
    