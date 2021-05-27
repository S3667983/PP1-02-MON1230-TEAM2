<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    header("Location: ../adminportal.php");
}

if(!isset($_GET['id'])){

    header("Location: cars.php");

}else{


    $id = $_GET['id'];
    
    //delete car data where car id matches

    $delete = "DELETE FROM CAR WHERE ID = '".$id."'";

    $stid = oci_parse ($conn, $delete);
    oci_execute($stid);

    header("Location: cars.php");  
}

?>