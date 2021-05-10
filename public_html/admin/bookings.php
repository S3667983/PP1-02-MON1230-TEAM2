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
                        <li><a href="locations.php">Locations</a></li>
                        <li><a href="logout.php">Admin Portal Logout</a></li>
                    </ul>
                </nav>
            </div>


        </header>

        <?php

        $stid = 'SELECT * FROM LOCATION';

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        echo "<h1>Locations: <a href='newlocation.php'><b>+</b></a></h1><br>";

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            echo "<h6><i><b>Postcode: </b>" .$row[0] . "</i></h6>";
            echo "<h6><i><b>Name: </b>" .$row[1] . "</i></h6>";
            echo "<h6><a href='editlocation.php?id=".$row[0]."'> Edit Location</a></h6>";
            echo "<h6><i><b><a href='removelocation.php?id=".$row[0]."'>Remove Location</a></b></i></h6>";
            echo "<p>--------------------------------------------------------</p>\n";
        } 
        ?>

    </body>

</html>