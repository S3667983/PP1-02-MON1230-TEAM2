<!DOCTYPE html>
<?php
session_start();
require_once('includes/dbconn.php');

if(empty($_SESSION['user'])){
    header("Location: login.php");

}else if(isset($_SESSION['admin'])){
    header("Location: index.php");
}

$user = $_SESSION['user'];

?>

<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <title>Car Share Co.</title>
    </head>


    <body>

        <header>
            <div class="container">

                <img src="img/logo.png" alt="logo" class="logo">

                <nav>
                    <ul>
                        <li><a href="#">Car/ Rental Information</a></li>
                        <li><a href="booking.php">Create Booking</a></li>
                        <li><a href="managebooking.php">Manage Booking</a></li>
                        <li><a href="#">Location</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </nav>
            </div>


        </header>

        <?php

        $stid = "SELECT * FROM BOOKING WHERE USERNAME = '".$user."' AND RETURNTIME IS NULL";

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        echo "<h1>Current Bookings:</h1><br>";

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            echo "<h6><i><b>Booking ID: </b>" .$row[0] . "</i></h6>";
            echo "<h6><i><b>Car ID: </b>" .$row[2] . "</i></h6>";
            echo "<h6><i><b>Location: </b>" .$row[3] . "</i></h6>";
            echo "<h6><i><b>Booking Date: </b>" .$row[4] . "</i></h6>";
            echo "<h6><i><b>Booking Time: </b>" .$row[6] . "</i></h6>";
            echo "<h6><i><b>Time Length (Hrs): </b>" .$row[8] . "</i></h6>";
            echo "<h6><a href='returncar.php?id=".$row[0]."'>Return Car</a></h6>";
            echo "<p>--------------------------------------------------------</p>\n";
        }

        $stid = "SELECT * FROM BOOKING WHERE USERNAME = '".$user."' AND RETURNTIME IS NOT NULL";

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        echo "<h1>Past Bookings:</h1><br>";

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            echo "<h6><i><b>Booking ID: </b>" .$row[0] . "</i></h6>";
            echo "<h6><i><b>Car ID: </b>" .$row[2] . "</i></h6>";
            echo "<h6><i><b>Initial Location: </b>" .$row[3] . "</i></h6>";
            echo "<h6><i><b>Return Location: </b>" .$row[5] . "</i></h6>";
            echo "<h6><i><b>Booking Date: </b>" .$row[4] . "</i></h6>";
            echo "<h6><i><b>Booking Time: </b>" .$row[6] . "</i></h6>";
            echo "<h6><i><b>Return Time: </b>" .$row[7] . "</i></h6>";
            echo "<h6><i><b>Time Length (Hrs): </b>" .$row[8] . "</i></h6>";
            echo "<p>--------------------------------------------------------</p>\n";
        } 
        ?>

    </body>
    <?php
        include('footer.php');
    ?>

</html>