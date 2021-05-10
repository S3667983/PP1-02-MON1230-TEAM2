<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

if(isset($_SESSION['admin'])){

    session_destroy();

}

header("Location: ../index.php");

?>