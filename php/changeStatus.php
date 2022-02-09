<?php
if(isset($_GET['changeStatus']) && !empty($_GET['changeStatus']))
{
    $user = '';
    $state = '';

    $user = ($_GET['changeStatus']);
    $state = ($_GET['userStatus']);
    //echo "<script>console.log( 'inactivate!: '.$user.' '.$state.' );</script>";

    //Include database
    $config = include("../config.php");
    include("db_connection.php");
   
    $updatedUser = db_connection::setUserActive ($user, $state);
}
?>
    