<?php
/*----------------------------------------------------------------------------------------------
WT2 BIF SS2018 Latosińska - Leithner
    ____             _          ___        _____             __       _  __
   / __ )____ ______(_)___ _   ( o )      / ___/__  ______  / /_____ | |/ /
  / __  / __ `/ ___/ / __ `/  / __ \/|    \__ \/ / / / __ \/ __/ __ `|   / 
 / /_/ / /_/ (__  / / /_/ /  / /_/  <    ___/ / /_/ / / / / /_/ /_/ /   |  
/_____/\__,_/____/_/\__,_/   \____/\/   /____/\__, /_/ /_/\__/\__,_/_/|_|  
                                             /____/                        

date: 09.06.2018

----------------------------------------------------------------------------------------------*/
include("db_connection.php");
$config = include("..\config.php");

$code = $_POST['code'];
$value = $_POST['value'];
$date = $_POST['date'];

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$length = 5;
$randomString = '';
for ($idx_char = 0; $idx_char < $length; $idx_char++)
{
	$randomString .= $characters[rand(0, $charactersLength - 1)];
}

// TODO: create again if voucher already exists!
db_connection::addVoucher($randomString, $value, $date);
echo $randomString;