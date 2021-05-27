<?php
session_start();
require_once('includes/dbconn.php');

if(empty($_SESSION['user'])){
    //if user isnt logged in, redirect to login page
    header("Location: login.php");

}else if(isset($_SESSION['admin'])){
    //if admin is logged in, prevent from viewing page
    header("Location: index.php");
}

$user = $_SESSION['user'];

$statuspage = 'logout.php';
$status = 'Logout, ' . $user;

if(!isset($_GET['id'])){
    //if car id isnt set in the GET field
    header("Location: managebooking.php");

}else{

    $id_get = $_GET['id'];

}

if(isset($_POST['return'])){

    $p_returntime = $_POST['returntime'];
    $p_returnlocation = $_POST['returnlocation'];
    $p_kmdriven = $_POST['kmdriven'];

    $updateodometer = $_POST['odometer'] + $p_kmdriven;

    $p_carid = $_POST['carid'];

    // update booking table with return data
    $update = "UPDATE BOOKING
                SET RETURNPOSTCODE = '".$p_returnlocation."', RETURNTIME = '".$p_returntime."', KMDRIVEN = '".$p_kmdriven."'
                WHERE ID = '".$id_get."'";

    $stid = oci_parse ($conn, $update);
    oci_execute($stid);

    //update car data with new odometer and postcode
    $update2 = "UPDATE CAR
                SET POSTCODE = '".$p_returnlocation."', ODOMETER = '".$updateodometer."'
                WHERE ID = '".$p_carid."'";

    $stid2 = oci_parse ($conn, $update2);
    oci_execute($stid2);


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

        <?php include 'includes/header.php';

        $query = "SELECT BOOKING.CAR, BOOKING.POSTCODE, BOOKING.BOOKDATE, BOOKING.BOOKTIME, BOOKING.RETURNTIME, BOOKING.LENGTH, CAR.MAKE, CAR.MODEL, CAR.YEAR, CAR.PRICE, CAR.ODOMETER, LOCATION.NAME, LOCATION.ADDRESS
                    FROM BOOKING 
                    JOIN CAR ON CAR.ID = BOOKING.CAR
                    JOIN LOCATION ON LOCATION.POSTCODE = BOOKING.POSTCODE
                    WHERE BOOKING.ID = '".$id_get."'";

        $stid = oci_parse ($conn, $query);
        oci_execute($stid);

        while (oci_fetch($stid)) {
            //set variables from database information

            $carid = oci_result($stid, 'CAR');
            $car = oci_result($stid, 'YEAR') . " " . oci_result($stid, 'MAKE') . " " . oci_result($stid, 'MODEL');
            $location = oci_result($stid, 'ADDRESS') . ", " . oci_result($stid, 'NAME') . " " . oci_result($stid, 'POSTCODE');
            $bookdate = oci_result($stid, 'BOOKDATE');
            $booktime = oci_result($stid, 'BOOKTIME');
            $returntime = oci_result($stid, 'RETURNTIME');
            $length = oci_result($stid, 'LENGTH');
            $priceperhour =  " $" . oci_result($stid, 'PRICE') / 500 * $length;
            $odometer = oci_result($stid, 'ODOMETER');
        }

        $returntime = ($length * 100) + $booktime;

        //query to fill the return locations in the return location dropdown

        $stid = 'SELECT * FROM LOCATION ORDER BY POSTCODE';

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        ?>

        <div class="wrapper">

            <div>
                <h1>Return Car: <br></h1>
            </div>

            <form action="#" method="post">

                <h7>Booking ID:</h7><br>
                <input type="text" value="<?php echo $id_get ?>" required disabled><br>
                <h7>Car:</h7><br>
                <input type="text" value="<?php echo $car ?>" required disabled><br>
                <input hidden name="carid" value="<?php echo $carid ?>">
                <h7>Initial Location:</h7><br>
                <input type="text"  value="<?php echo $location ?>" pattern="[0-9]{4}" required disabled><br>
                <h7><b><i>Return Location: </i></b></h7><br>
                <select name="returnlocation" class="select" required>
                    <?php while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) { ?>
                    <option value="<?php echo $row[0] ?>">  <?php echo $row[3] . ", " . $row[1] . " " . $row[0]?>  </option>
                    <?php } ?>
                </select><br>
                <h7>Booking Date:</h7><br>
                <input type="text" value="<?php echo $bookdate ?>" required disabled><br>
                <h7>Booking Time:</h7><br>
                <select name="booktime" class="select"required disabled>
                    <option value="0900"<?php if($booktime == '0900'){echo("selected");}?>>9:00am</option>
                    <option value="1000"<?php if($booktime == '1000'){echo("selected");}?>>10:00am</option>
                    <option value="1100"<?php if($booktime == '1100'){echo("selected");}?>>11:00am</option>
                    <option value="1200"<?php if($booktime == '1200'){echo("selected");}?>>12:00pm</option>
                    <option value="1300"<?php if($booktime == '1300'){echo("selected");}?>>1:00pm</option>
                    <option value="1400"<?php if($booktime == '1400'){echo("selected");}?>>2:00pm</option>
                    <option value="1500"<?php if($booktime == '1500'){echo("selected");}?>>3:00pm</option>
                    <option value="1600"<?php if($booktime == '1600'){echo("selected");}?>>4:00pm</option>
                    <option value="1700"<?php if($booktime == '1700'){echo("selected");}?>>5:00pm</option>
                </select><br>
                <h7>Return Time:</h7><br>
                <select class="select"required disabled>
                    <option value="1000"<?php if($returntime == '1000'){echo("selected");}?>>10:00am</option>
                    <option value="1100"<?php if($returntime == '1100'){echo("selected");}?>>11:00am</option>
                    <option value="1200"<?php if($returntime == '1200'){echo("selected");}?>>12:00pm</option>
                    <option value="1300"<?php if($returntime == '1300'){echo("selected");}?>>1:00pm</option>
                    <option value="1400"<?php if($returntime == '1400'){echo("selected");}?>>2:00pm</option>
                    <option value="1500"<?php if($returntime == '1500'){echo("selected");}?>>3:00pm</option>
                    <option value="1600"<?php if($returntime == '1600'){echo("selected");}?>>4:00pm</option>
                    <option value="1700"<?php if($returntime == '1700'){echo("selected");}?>>5:00pm</option>
                    <option value="1800"<?php if($returntime == '1800'){echo("selected");}?>>6:00pm</option>
                    <option value="1900"<?php if($returntime == '1000'){echo("selected");}?>>7:00pm</option>
                    <option value="2000"<?php if($returntime == '2000'){echo("selected");}?>>8:00pm</option>
                    <option value="2100"<?php if($returntime == '2100'){echo("selected");}?>>9:00pm</option>
                </select><br>
                <input hidden name="returntime" value="<?php echo $returntime ?>">
                <h7>Time Length (Hrs):</h7><br>
                <select name="length" class="select"required disabled>
                    <option value="0001"<?php if($length == '1'){echo("selected");}?>>1 Hour <?php echo " - " . $priceperhour ?> </option>
                    <option value="0002"<?php if($length == '2'){echo("selected");}?>>2 Hours <?php echo " - " . $priceperhour ?> </option>
                    <option value="0004"<?php if($length == '4'){echo("selected");}?>>4 Hours <?php echo " - " . $priceperhour ?> </option>
                </select><br>
                <b><i><h7>Kilometres Driven:</h7></i></b><br>
                <input type="text" name="kmdriven" pattern="\d*" maxlength="4" required> km<br>
                <input hidden name="odometer" value="<?php echo $odometer ?>">
                <br>
                <input type="submit" value="Return" name="return" id="submit">

            </form>

            <?php
    oci_close($conn);

            ?>

        </div>

    </body>

    <?php include 'includes/footer.php';?>

</html>