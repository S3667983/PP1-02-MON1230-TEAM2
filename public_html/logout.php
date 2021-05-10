<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

if(isset($_SESSION['user'])){

    session_destroy();

}

header("Location: index.php");

?>