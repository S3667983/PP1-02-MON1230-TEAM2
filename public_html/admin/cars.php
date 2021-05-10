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

        <?php

        $stid = 'SELECT * FROM CAR';

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        echo "<h1>Cars: <a href='newcar.php'><b>+</b></a></h1><br>";

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            echo "<h6><i><b>ID: </b>" .$row[0] . "</i></h6>";
            echo "<h6><i><b>Make: </b>" .$row[1] . "</i></h6>";
            echo "<h6><i><b>Model: </b>" .$row[2] . "</i></h6>";
            echo "<h6><i><b>Year: </b>" .$row[4] . "</i></h6>";
            echo "<h6><i><b>Transmission: </b>" .$row[7] . "</i></h6>";
            echo "<h6><i><b>Condition: </b>" .$row[8] . "</i></h6>";
            echo "<h6><i><b>Odometer: </b>" .$row[6] . "km</i></h6>";
            echo "<h6><i><b>Postcode: </b>" .$row[3] . "</i></h6>";
            echo "<h6><i><b>Price: </b>$" .$row[5] . "AUD</i></h6>";
            echo "<h6><a href='editcar.php?id=".$row[0]."'> Edit Car</a></h6>";
            echo "<h6><i><b><a href='removecar.php?id=".$row[0]."'>Remove Car</a></b></i></h6>";
            echo "<p>--------------------------------------------------------</p>\n";
        } 
        ?>

    </body>

</html>