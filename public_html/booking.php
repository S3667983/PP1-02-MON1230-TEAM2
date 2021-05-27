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


    <body>

        <?php include 'includes/header.php';

        if(isset($_GET['postcode'])){
            //if get postcode is set then get cars only from the selected postcode
            $stid = "SELECT * FROM CAR JOIN LOCATION ON LOCATION.POSTCODE = CAR.POSTCODE WHERE CAR.POSTCODE = '" .$_GET['postcode']. "' ORDER BY CAR.ID";
        }else{
            //select all cars
            $stid = 'SELECT * FROM CAR JOIN LOCATION ON LOCATION.POSTCODE = CAR.POSTCODE ORDER BY CAR.ID';
        }

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        if(isset($_GET['postcode'])){
            //assign postcode in the website header
            echo "<h1>Cars Available to Book from '". $_GET['postcode'] ."':</h1><br><br>";
        }else{
            echo "<h1>Cars Available to Book:</h1><br><br>";
        }

        echo "<div class='container'>";

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {

            //price per hour based on base car price / 500
            $priceperhour = $row[5]/500;

            echo "<div class='item' id='booking'>";
            echo "<img src='img/" . $row[0] . ".jpg'>";
            echo "<p><b>" .$row[4] . " " . $row[1] . " " . $row[2] . "</b></p>";
            echo "<p>" .$row[11] . ", " . $row[9]. " " . $row[3]. "</p>";
            echo "<p>" .$row[7] . ", " . $row[6] . " km</p>";
            echo "<p>$" .$priceperhour . " per hour". "</p>";
            echo "<p><a href='bookcar.php?id=".$row[0]."'> Book Car</a></p>"; 
            echo "</div>"; ?>


        <?php

        } 

        oci_close($conn);
        ?>

        </div>

    </body>

<?php include 'includes/footer.php';?>

</html>