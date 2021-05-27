<!DOCTYPE html>
<?php
session_start();
require_once('includes/dbconn.php');

if(empty($_SESSION['user'])){
    //if user isnt logged in
    header("Location: login.php");

}else if(isset($_SESSION['admin'])){
    //if admin is logged in
    header("Location: index.php");
}

$user = $_SESSION['user'];

$statuspage = 'logout.php';
$status = 'Logout, ' . $user;

function convertTime($time) {

    //function to convert 4 digit 24 hour time into a 12hr time string

    if (strlen($time) <= 3) {
        return substr($time, 0, 1) . ":" . substr($time, -2) . " am";
    }

    if($time <= 1100){
        return substr($time, 0, 2) . ":" . substr($time, -2) . " am";
    }

    if($time >= 1300){
        $time = $time - 1200;

        return substr($time, 0, 1) . ":" . substr($time, -2) . " pm";
    }

    return substr($time, 0, 2) . ":" . substr($time, -2) . " pm";
}

?>

<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <title>Car Share Co.</title>
    </head>


    <body>

        <?php include 'includes/header.php';

        //current bookings data - where return time is null meaning it is an active booking

        $stid = "SELECT 
                BOOKING.ID, BOOKING.POSTCODE, BOOKING.BOOKDATE, BOOKING.BOOKTIME, BOOKING.LENGTH, LOCATION.NAME, LOCATION.ADDRESS, CAR.MAKE, CAR.MODEL, CAR.YEAR, CAR.PRICE
                FROM BOOKING 
                JOIN LOCATION ON LOCATION.POSTCODE = BOOKING.POSTCODE 
                JOIN CAR ON CAR.ID = BOOKING.CAR
                WHERE USERNAME = '".$user."' AND RETURNTIME IS NULL ORDER BY BOOKDATE, BOOKTIME";

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        echo "<h1>Current Bookings:</h1><br>";

        echo "<div class='container'>";

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            echo "<div class='item'>";
            echo "<p><b>Booking ID: </b>" .$row[0] . "</p>";
            echo "<p><b>Car: </b>" . $row[9] . " " . $row[7] . " " . $row[8] . "</p>";
            echo "<p><b>Location: </b>" . $row[6] . ", " . $row[5] . " " . $row[1] . "</p>";
            echo "<p><b>Booking Date: </b>" .$row[2]. "</p>";
            echo "<p><b>Booking Time: </b>" .convertTime($row[3]) . "</p>";
            echo "<p><b>Time Length (Hrs): </b>" .$row[4] . " - $" . (($row[10]/500) * $row[4]) . "</p>";
            echo "<h5><a href='returncar.php?id=".$row[0]."'>Return Car</a></h5>";
            echo "</div>";
        }

        echo "</div>";


        //past bookings data - where return time isnt null meaning there is a return time and the booking has been returned

        $stid = "SELECT BOOKING.ID, BOOKING.CAR, L1.POSTCODE, L1.NAME, L1.ADDRESS ,BOOKING.BOOKDATE, L2.POSTCODE, L2.NAME, L2.ADDRESS, BOOKING.BOOKTIME, BOOKING.LENGTH, BOOKING.RETURNTIME, BOOKING.KMDRIVEN, CAR.MAKE, CAR.MODEL, CAR.YEAR, CAR.PRICE
                FROM BOOKING
                JOIN LOCATION L1 ON L1.POSTCODE = BOOKING.POSTCODE
                JOIN LOCATION L2 ON L2.POSTCODE = BOOKING.RETURNPOSTCODE
                JOIN CAR ON CAR.ID = BOOKING.CAR
                WHERE USERNAME = '".$user."' AND RETURNTIME IS NOT NULL ORDER BY BOOKDATE, BOOKTIME";

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        echo "<h1>Past Bookings:</h1><br>";

        echo "<div class='container'>";

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            echo "<div class='item'>";
            echo "<p><b>Booking ID: </b>" .$row[0] . "</p>";
            echo "<p><b>Car: </b>" .$row[15] . " " . $row[13] . " " . $row[14] . "</p>";
            echo "<p><b>Initial Location: </b>" .$row[4] . ", " .$row[3] . " " . $row[2] . "</p>";
            echo "<p><b>Return Location: </b>" .$row[8] . ", " .$row[7] . " " . $row[6] . "</p>";
            echo "<p><b>Booking Date: </b>" .$row[5] . "</p>";
            echo "<p><b>Booking Time: </b>" .convertTime($row[9]) . "</p>";
            echo "<p><b>Return Time: </b>" .convertTime($row[11]) . "</p>";
            echo "<p><b>Time Length (Hrs): </b>" .$row[10] . " - $" . (($row[16]/500) * $row[10]) . "</p>";
            echo "<p><b>Kilometres Driven: </b>" .$row[12] . " km" . "</p>";
            echo "</div>";
        } 

        echo "</div>";
        ?>

    </body>

    <?php include 'includes/footer.php';?>

</html>