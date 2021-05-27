<!DOCTYPE html>
<?php
error_reporting(E_ERROR | E_PARSE); //hides minimal warning from location proximity function

session_start();
require_once('includes/dbconn.php');

if(isset($_SESSION['user'])){
    //if user is logged in display username in header
    $user = $_SESSION['user'];

    $statuspage = 'logout.php';
    $status = 'Logout, ' . $user;
}else{
    $statuspage = 'login.php';
    $status = 'Login';
}

if(isset($_POST['postcode'])){

    //select all postcodes from the location database

    $userpostcode = $_POST['postcode'];

    $locationquery = "SELECT POSTCODE FROM LOCATION";

    $locationquery = oci_parse($conn, $locationquery);
    oci_execute($locationquery);

    $locationpostcodes = [];

    //push all locations into an array to be sorted by a function and determine location proximity

    while (($row = oci_fetch_array($locationquery, OCI_BOTH)) != false) {
        array_push($locationpostcodes, $row[0]);
    }

    $lowernumber = locationProximity($locationpostcodes, $userpostcode);

    header("Location: booking.php?postcode=".$lowernumber."");

}

function locationProximity($locations, $postcode) {

    //find closest postcode from the inputted postcode

    sort($locations);

    foreach ($locations as $locs) {

        if ($locs > $postcode){
            //if distance between number in array and postcode is closer than the previous distance
            if(($locs-$number)<($postcode-$prev))
                return $locs;
            else
                return $prev;
        }else{

            $prev = $locs;

        }                                        
    }
    //return the last if no closest match previously
    return end($locs);
}

?>

<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <title>Car Share Co.</title>
    </head>


    <body>

        <?php include 'includes/header.php';?>

        <?php

        //select all location data to display

        $stid = 'SELECT * FROM LOCATION ORDER BY POSTCODE';

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        echo "<h1>Locations:</h1>";

        if(isset($_SESSION['user'])){

            //if user is logged in, grab their postcode data to use to gauge proximity to locations in the database

            $userquery = "SELECT * FROM ACCOUNT WHERE USERNAME = '".$user."'";

            $userquery = oci_parse($conn, $userquery);
            oci_execute($userquery);

            while (oci_fetch($userquery)) {
                $userpostcode = oci_result($userquery, 'POSTCODE');
            }

            //select all postcodes in database

            $locationquery = "SELECT POSTCODE FROM LOCATION";

            $locationquery = oci_parse($conn, $locationquery);
            oci_execute($locationquery);

            $locationpostcodes = [];

            //push all retrieved postcodes to the locationpostcodes array

            while (($row = oci_fetch_array($locationquery, OCI_BOTH)) != false) {
                array_push($locationpostcodes, $row[0]);
            }
            
            //run function based on users logged in postcode and locations in database

            $lowernumber = locationProximity($locationpostcodes, $userpostcode);
            
            echo "<div class='container'>";

            echo "<div class='item'><h5><a href='booking.php?postcode=".$lowernumber."'>Search for Cars at my Nearest Location! </a> or</h5>";

        }else{
            echo "<div class='container'>";
            
            echo "<div class='item'><br>";
        } ?>

            <form action="#" method="post">
                <!-- Form for user to input their own postcode instead of using their logged in postcode -->
                <input type="text" placeholder="VIC / NSW Postcode: " name="postcode" pattern="^(2|3)([0-9]{3})" required>
                <br><br>
                <input type="submit" value="Find Nearest Location" name="search" id="submit">
            </form>
        
                </div>


            <?php
        
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<div class='item'>";
                echo "<h3>" . $row[1] . " " . $row[0] . "</h3>";
                echo "<p>" .$row[3] . ", " . $row[1] . " " . $row[0] . "</p>";
                echo "<p>" .$row[2] . "</p>";
                echo "<h6><i><b>Lat: </b>" .$row[4] . ", Lon: " . $row[5] . "</i></h6>";
                echo "<h6><a href='booking.php?postcode=".$row[0]."'>Cars at this location!</a></h6>";
                echo "</div>";
            } 

            oci_close($conn);
            ?>

        </div>

    </body>

    <?php include 'includes/footer.php';?>

</html>