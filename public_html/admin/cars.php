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

        //select all car and relevant location data to display on the page below

        $stid = 'SELECT * FROM CAR 
                JOIN LOCATION ON LOCATION.POSTCODE = CAR.POSTCODE 
                ORDER BY ID';

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        //new car
        echo "<h1>Cars: <a href='newcar.php'><b>+</b></a></h1><br>"; ?>

        <div class = "container">

            <?php

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<div class='item'>";
                echo "<p><b>Car ID: </b>" .$row[0] . "</p>";
                echo "<p><b>Car: </b>" .$row[4] . " " . $row[1] . " " . $row[2] . "</p>";
                echo "<p><b>Location: </b>" .$row[11] . ", " . $row[9] . " " . $row[3] . "</p>";
                echo "<p><b>Odometer: </b>" .$row[6] . " km</p>";
                echo "<p><b>Transmission: </b>" .$row[7] . "</p>";
                echo "<p><b>Base Price: </b>$" .$row[5] . " AUD</p>";
                echo "<h6><a href='editcar.php?id=".$row[0]."'> Edit Car</a></h6>";
                echo "<h6><i><b><a href='removecar.php?id=".$row[0]."'>Remove Car</a></b></i></h6>";
                echo "</div>";
            } 
            ?>

        </div>

    </body>

</html>