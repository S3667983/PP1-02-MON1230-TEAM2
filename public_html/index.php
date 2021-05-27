<!DOCTYPE html>
<?php
session_start();
require_once('includes/dbconn.php');

if(isset($_SESSION['user'])){
    //if user is logged in
    $user = $_SESSION['user'];

    $statuspage = 'logout.php';
    $status = 'Logout, ' . $user;
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

    <?php include 'includes/header.php';?>

    <body>

        <div class = "child">
            <div>
                <h1>Why You Should Choose Car Share Co. </h1>
            </div>

            <div class="slider">

                <div class="slides">
                    <div id="slide-1">
                        <img src="img3.png" alt="logo">
                    </div>
                    <div id="slide-2">
                        <img src="img1.png" alt="logo" >
                    </div>
                    <div id="slide-3">
                        <img src="img2.png" alt="logo">
                    </div>
                </div>
            </div>

        </div>

    </body>

    <?php include 'includes/footer.php';?>

</html>