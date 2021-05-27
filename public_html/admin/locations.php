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

        //select all location data to display

        $stid = 'SELECT * FROM LOCATION ORDER BY POSTCODE';

        $stid = oci_parse($conn, $stid);
        oci_execute($stid); 

        echo "<h1>Locations: <a href='newlocation.php'><b>+</b></a></h1><br><br>";

        ?>

        <div class="container">

            <?php
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<div class='item'>";
                echo "<h3>" . $row[1] . " " . $row[0] . "</h3>";
                echo "<p>" .$row[3] . ", " . $row[1] . " " . $row[0] . "</p>";
                echo "<p>" .$row[2] . "</p>";
                echo "<h6><i><b>Lat: </b>" .$row[4] . ", Lon: " . $row[5] . "</i></h6>";
                echo "<h6><a href='editlocation.php?id=".$row[0]."'> Edit Location</a></h6>";
                echo "<h6><i><b><a href='removelocation.php?id=".$row[0]."'>Remove Location</a></b></i></h6>";
                echo "</div>";
            } 
            ?>

        </div>

    </body>

</html>