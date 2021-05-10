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

    header("Location: managebooking.php");

}else{

    $id_get = $_GET['id'];

}

if(isset($_POST['return'])){

    $p_returntime = $_POST['returntime'];
    $p_returnlocation = $_POST['returnlocation'];

    $p_carid = $_POST['carid'];

    $update = "UPDATE BOOKING
                SET RETURNPOSTCODE = '".$p_returnlocation."', RETURNTIME = '".$p_returntime."'
                WHERE ID = '".$id_get."'";

    $stid = oci_parse ($conn, $update);
    oci_execute($stid);

    $update2 = "UPDATE CAR
                SET POSTCODE = '".$p_returnlocation."'
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
                <h1>Return Car: <br></h1>
            </div>

            <?php

            $query = "SELECT * FROM BOOKING WHERE ID = '".$id_get."'";

            $stid = oci_parse ($conn, $query);
            oci_execute($stid);

            while (oci_fetch($stid)) {
                $carid = oci_result($stid, 'CAR');
                $postcode = oci_result($stid, 'POSTCODE');
                $bookdate = oci_result($stid, 'BOOKDATE');
                $booktime = oci_result($stid, 'BOOKTIME');
                $returntime = oci_result($stid, 'RETURNTIME');
                $length = oci_result($stid, 'LENGTH');
            }

            $query = "SELECT * FROM LOCATION WHERE POSTCODE = '".$postcode."'";

            $stid = oci_parse ($conn, $query);
            oci_execute($stid);

            while (oci_fetch($stid)) {
                $name = oci_result($stid, 'NAME');
            }

            $returntime = ($length * 100) + $booktime;

            $stid = 'SELECT * FROM LOCATION';

            $stid = oci_parse($conn, $stid);
            oci_execute($stid);

            ?>

            <form action="#" method="post">
                <h7>Booking ID:</h7><br>
                <input type="text" value="<?php echo $id_get ?>" required disabled><br>
                <h7>Car ID:</h7><br>
                <input type="text" value="<?php echo $carid ?>" required disabled><br>
                <input hidden name="carid" value="<?php echo $carid ?>">
                <h7>Initial Location:</h7><br>
                <input type="text"  value="<?php echo $postcode . " - " . $name ?>" pattern="[0-9]{4}" required disabled><br>
                <h7><b><i>Return Location: </i></b></h7><br>
                <select name="returnlocation" class="select" required>
                    <?php while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) { ?>
                    <option value="<?php echo $row[0] ?>">  <?php echo $row[0] . " - " . $row[1]?>  </option>
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
                <h7><b><i>Return Time:</i></b></h7><br>
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
                    <option value="0001"<?php if($length == '1'){echo("selected");}?>>1 Hour</option>
                    <option value="0002"<?php if($length == '2'){echo("selected");}?>>2 Hours</option>
                    <option value="0004"<?php if($length == '4'){echo("selected");}?>>4 Hours</option>
                </select><br><br>
                <input type="submit" value="Return" name="return">
            </form>

            <?php
            oci_close($conn);

            ?>

        </div>

    </body>

</html>