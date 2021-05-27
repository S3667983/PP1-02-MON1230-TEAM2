<?php
session_start();
require_once('includes/dbconn.php');

if(empty($_SESSION['user'])){
    //if user is logged in
    header("Location: login.php");

}else if(isset($_SESSION['admin'])){
    //if admin is logged in
    header("Location: index.php");
}

$user = $_SESSION['user'];

$statuspage = 'logout.php';
$status = 'Logout, ' . $user;

if(!isset($_GET['id'])){
    //if get ID isnt set, return user to booking page
    header("Location: booking.php");

}else{

    $id_get = $_GET['id'];

}

if(isset($_POST['book'])){

    //if user submits form to book car

    print_r($_POST);

    $id = substr(str_shuffle("0123456789"), 0, 4); // randomly generated 4 digit ID
    $p_postcode = $_POST['postcode'];
    $p_bookdate = $_POST['bookdate'];
    $p_booktime = $_POST['booktime'];
    $p_length = $_POST['length'];
    $p_price = $_POST['priceperhour'] * $p_length;

    $insert = "INSERT INTO BOOKING(ID, USERNAME, CAR, POSTCODE, BOOKDATE, BOOKTIME, LENGTH, PRICE)" .
        "VALUES('".$id."','".$user."','".$id_get."','".$p_postcode."','".$p_bookdate."','".$p_booktime."','".$p_length."','".$p_price."')";

    //oracle specific date format
    $changeDateFormat = oci_parse($conn, "ALTER SESSION SET NLS_DATE_FORMAT = \"YYYY-MM-DD\"");

    $stid = oci_parse ($conn, $insert);

    oci_execute($changeDateFormat);
    oci_execute($stid);

    oci_close($conn);

    header("Location: managebooking.php");

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


        <div class="wrapper">

            <div>
                <h1>Book Car: <br></h1>
            </div>

            <?php

            //select all car and location data where id matches
            $query = "SELECT CAR.MAKE, CAR.MODEL, CAR.YEAR, CAR.POSTCODE, CAR.PRICE, LOCATION.NAME, LOCATION.ADDRESS 
                    FROM CAR 
                    JOIN LOCATION ON LOCATION.POSTCODE = CAR.POSTCODE WHERE ID = '".$id_get."'";

            $stid = oci_parse ($conn, $query);
            oci_execute($stid);

            while (oci_fetch($stid)) {
                //assign variables
                $make = oci_result($stid, 'MAKE');
                $model = oci_result($stid, 'MODEL');
                $postcode = oci_result($stid, 'POSTCODE');
                $year = oci_result($stid, 'YEAR');
                $priceperhour = oci_result($stid, 'PRICE') / 500;
                $name = oci_result($stid, 'NAME');
                $address = oci_result($stid, 'ADDRESS');
            } 

            $query = "SELECT * FROM LOCATION WHERE POSTCODE = '".$postcode."'";

            ?>

            <form action="#" method="post">
                <h7>Car:</h7><br>
                <input type="text" value="<?php echo $year . " " . $make . " " . $model ?>" required disabled><br>
                <h7>Location:</h7><br>
                <input type="text"  value="<?php echo $address . ", " . $name . " " . $postcode ?>" pattern="[0-9]{4}" required disabled><br>
                <input hidden name="postcode" value="<?php echo $postcode ?>">
                <h7>Booking Date:</h7><br>
                <input type="date" name="bookdate" required><br>
                <h7>Booking Time:</h7><br>
                <select name="booktime" class="select"required>
                    <option value="0900">9:00am</option>
                    <option value="1000">10:00am</option>
                    <option value="1100">11:00am</option>
                    <option value="1200">12:00pm</option>
                    <option value="1300">1:00pm</option>
                    <option value="1400">2:00pm</option>
                    <option value="1500">3:00pm</option>
                    <option value="1600">4:00pm</option>
                    <option value="1700">5:00pm</option>
                </select><br>
                <h7>Time Length (Hrs):</h7><br>
                <select name="length" class="select"required>
                    <option value="1">1 Hour - <?php echo "$".$priceperhour ?></option>
                    <option value="2">2 Hours - <?php echo "$".$priceperhour * 2 ?></option>
                    <option value="4">4 Hours - <?php echo "$".$priceperhour * 4 ?></option>
                </select><br><br>
                <input hidden name="priceperhour" value="<?php echo $priceperhour ?>">
                <input type="submit" value="Book" name="book" id="submit">
            </form>

            <?php
    oci_close($conn);
            ?>

        </div>

    </body>

    <?php include 'includes/footer.php';?>

</html>