<!DOCTYPE html>
<?php
session_start();
require_once('includes/dbconn.php');

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];

    $statuspage = 'logout.php';
    $status = 'Logout';
}else{
    $statuspage = 'login.php';
    $status = 'Login';
}

?>

<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <title>Car Share Co.</title>
    </head>

    <body>
        <?php
            include('footer.php');
        ?>
        
        <?php
            include('footer.php');
        ?>
    </body>

</html>