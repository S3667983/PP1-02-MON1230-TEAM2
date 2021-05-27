<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    header("Location: ../adminportal.php");
}

if(!isset($_GET['id'])){

    header("Location: locations.php");

}else{


    $id = $_GET['id'];
    
    //delete location data where id/ postcode matches

    $delete = "DELETE FROM LOCATION WHERE POSTCODE = '".$id."'";

    $stid = oci_parse ($conn, $delete);
    oci_execute($stid);

    header("Location: locations.php");  
}

?>