<!DOCTYPE html>
<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    header("Location: ../adminportal.php");
}

?>

<html>

    <head>
        <link rel="stylesheet" href="../style.css">
        <meta charset="UTF-8">
        <title>Admin Portal</title>
    </head>


    <body>

        <header>
            <div class="container">

                <img src="../img/logo.png" alt="logo" class="logo">

                <nav>
                    <ul>
                        <li><a href="users.php">Users</a></li>
                        <li><a href="cars.php">Cars</a></li>
                        <li><a href="logout.php">Admin Portal Logout</a></li>
                    </ul>
                </nav>
            </div>


        </header>

    </body>

</html>