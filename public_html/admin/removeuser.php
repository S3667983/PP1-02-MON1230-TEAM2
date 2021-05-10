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

    $delete = "DELETE FROM ACCOUNTS WHERE USERNAME = '".$user."'";

    $stid2 = oci_parse ($conn, $delete);
    oci_execute($stid2);

    header("Location: users.php");  

}

?>