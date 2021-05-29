<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['user'])){
    //if user isnt logged in, redirect to login page
    header("Location: login.php");

}else if(isset($_SESSION['admin'])){
    //if admin is logged in, prevent from viewing page
    header("Location: index.php");
}

$user = $_SESSION['user'];
    
    //delete user data where username matches

    $delete = "DELETE FROM ACCOUNT WHERE USERNAME = '".$user."'";

    $stid = oci_parse ($conn, $delete);
    oci_execute($stid);

    header("Location: index.php"); 
    
    session_destroy();

?>