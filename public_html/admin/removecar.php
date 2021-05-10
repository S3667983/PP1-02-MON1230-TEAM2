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

    $delete = "DELETE FROM CAR WHERE ID = '".$id."'";

    $stid2 = oci_parse ($conn, $delete);
    oci_execute($stid2);

    header("Location: cars.php");  
}

?>