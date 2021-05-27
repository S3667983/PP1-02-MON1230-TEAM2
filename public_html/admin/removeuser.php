<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    header("Location: ../adminportal.php");
}

if(!isset($_GET['user'])){

    header("Location: users.php");

}else{

    $user = $_GET['user'];
    
    //delete user data where username matches

    $delete = "DELETE FROM ACCOUNT WHERE USERNAME = '".$user."'";

    $stid = oci_parse ($conn, $delete);
    oci_execute($stid);

    header("Location: users.php");  

}

?>