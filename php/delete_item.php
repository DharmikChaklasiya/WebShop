<?php
if (isset($_POST['id']) && !empty($_POST['id']))
{
    $item = $_POST['id'];

    //Include database
    $config = include("../config.php");
    include("db_connection.php");
   
	$result = db_connection::removeOrderItem($item);
}
?>
    