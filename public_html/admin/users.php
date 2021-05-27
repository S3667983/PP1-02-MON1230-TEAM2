<!DOCTYPE html>
<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    //if admin isnt logged in
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

        <?php include '../includes/adminheader.php';?>

        <?php

        //select all user data and display such

        $stid = 'SELECT * FROM ACCOUNT ORDER BY USERNAME';

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        echo "<h1>Users: <a href='newuser.php'><b>+</b></a></h1><br>"; ?>

        <div class = "container">

            <?php
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<div class='item'>";
                echo "<p><b>Username: </b>" .$row[0] . "</p>";
                echo "<p><b>Password: </b>" .$row[1] . "</p>";
                echo "<p><b>First Name: </b>" .$row[3] . "</p>";
                echo "<p><b>Last Name: </b>" .$row[2] . "</p>";
                echo "<p><b>Email: </b>" .$row[5] . "</p>";
                echo "<p><b>Date of Birth: </b>" .$row[6] . "</p>";
                echo "<p><b>Address: </b>" .$row[7] . ", " . $row[9] . ", " . $row[8] . ", " .$row[10] . "</p>";
                echo "<p><b>Phone No: </b>" .$row[4] . "</p>";
                echo "<h6><a href='edituser.php?user=".$row[0]."'> Edit User</a></h6>";
                echo "<h6><i><b><a href='removeuser.php?user=".$row[0]."'>Remove User </a></b></i></h6>";
                echo "</div>";
            } 
            ?>
            
        </div>

    </body>

</html>