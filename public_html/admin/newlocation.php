<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    //if admin isnt logged in
    header("Location: ../adminportal.php");
}

if(isset($_POST['id'])){

    //if admin posts location data

    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $desc = $_POST['desc'];
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];

    $stid =    "INSERT INTO LOCATION(POSTCODE, NAME, DESCRIPTION, ADDRESS, LAT, LON)" .
        "VALUES('".$id."','".$name."','".$desc."','".$address."','".$lat."','".$lon."')";

    $compiled = oci_parse($conn, $stid);

    oci_execute($compiled);
    oci_close($conn);

    header("Location: locations.php");

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

        <div class="wrapper">

            <div>
                <h1>New Location: </h1>
            </div>

            <form action="#" method="post">

                <input type="text" name="id" placeholder="Postcode" required><br>
                <input type="text" name="name" placeholder="Suburb"required><br>
                <input type="text" name="address" placeholder="Address"required><br>
                <input type="text" name="desc" placeholder="Description"required><br>
                <input type="text" name="lat" placeholder="Latitude" pattern="^-?[0-9]\d*(\.\d+)?$" maxlength="7" required><br> <!-- pattern allows max length of 7 characters and numbers with decimals to allow for latitude and longitude -->
                <input type="text" name="lon" placeholder="Longitude" pattern="^-?[0-9]\d*(\.\d+)?$" maxlength="7" required><br>
                <br>
                <input type="submit" value="Create" id="submit">

            </form>

        </div>
    </body>

</html>