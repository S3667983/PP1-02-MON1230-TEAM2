<?php
session_start();
require_once('includes/dbconn.php');

if(empty($_SESSION['user'])){
    header("Location: login.php");

}else if(isset($_SESSION['admin'])){
    header("Location: index.php");
}

$user = $_SESSION['user'];

if(!isset($_GET['id'])){

    header("Location: booking.php");

}else{

    $id_get = $_GET['id'];

}

if(isset($_POST['book'])){
    
    print_r($_POST);

    $id = substr(str_shuffle("0123456789"), 0, 4); // randomly generated 4 digit ID
    $p_postcode = $_POST['postcode'];
    $p_bookdate = $_POST['bookdate'];
    $p_booktime = $_POST['booktime'];
    $p_length = $_POST['length'];

    $insert = "INSERT INTO BOOKING(ID, USERNAME, CAR, POSTCODE, BOOKDATE, BOOKTIME, LENGTH)" .
        "VALUES('".$id."','".$user."','".$id_get."','".$p_postcode."','".$p_bookdate."','".$p_booktime."','".$p_length."')";

    $changeDateFormat = oci_parse($conn, "ALTER SESSION SET NLS_DATE_FORMAT = \"YYYY-MM-DD\"");

    $stid3 = oci_parse ($conn, $insert);

    oci_execute($changeDateFormat);
    oci_execute($stid3);

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

        <header>
            <div class="container">

                <img src="img/logo.png" alt="logo" class="logo">

                <nav>
                    <ul>
                        <li><a href="#">Car/ Rental Information</a></li>
                        <li><a href="booking.php">Create Booking</a></li>
                        <li><a href="managebooking.php">Manage Booking</a></li>
                        <li><a href="#">Location</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </nav>

            </div>


        </header>


        <div id="wrapper">

            <div>
                <h1>Book Car: <br></h1>
            </div>

            <?php

            $query = "SELECT MAKE, MODEL, YEAR, POSTCODE FROM CAR WHERE ID = '".$id_get."'";

            $stid = oci_parse ($conn, $query);
            oci_execute($stid);

            while (oci_fetch($stid)) {
                $make = oci_result($stid, 'MAKE');
                $model = oci_result($stid, 'MODEL');
                $postcode = oci_result($stid, 'POSTCODE');
                $year = oci_result($stid, 'YEAR');
            } 

            $query = "SELECT * FROM LOCATION WHERE POSTCODE = '".$postcode."'";

            $stid = oci_parse ($conn, $query);
            oci_execute($stid);

            while (oci_fetch($stid)) {
                $name = oci_result($stid, 'NAME');
            }

            ?>

            <form action="#" method="post">
                <h7>Make:</h7><br>
                <input type="text" value="<?php echo $make ?>" required disabled><br>
                <h7>Model:</h7><br>
                <input type="text" value="<?php echo $model ?>" required disabled><br>
                <h7>Year:</h7><br>
                <input type="text" id="year" name="year" value="<?php echo $year ?>" required disabled><br>
                <h7>Location:</h7><br>
                <input type="text"  value="<?php echo $postcode . " - " . $name ?>" pattern="[0-9]{4}" required disabled><br>
                <input hidden name="postcode" value="<?php echo $postcode ?>">
                <h7>Booking Date:</h7><br>
                <input type="date" id="bookdate" name="bookdate" required><br>
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
                    <option value="0001">1 Hour</option>
                    <option value="0002">2 Hours</option>
                    <option value="0004">4 Hours</option>
                </select><br><br>
                <input type="submit" value="Book" name="book">
            </form>

            <?php
    oci_close($conn);

            ?>

        </div>

    </body>

</html>