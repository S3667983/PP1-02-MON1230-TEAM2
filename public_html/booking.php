<!DOCTYPE html>
<?php
session_start();
require_once('includes/dbconn.php');

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];

    $statuspage = 'logout.php';
    $status = 'Logout';
}else{
    $loggedin = false;

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

        <header>
            <div class="container">

                <img src="img/logo.png" alt="logo" class="logo">

                <nav>
                    <ul>
                        <li><a href="#">Car/ Rental Information</a></li>
                        <li><a href="booking.php">Create Booking</a></li>
                        <li><a href="managebooking.php">Manage Booking</a></li>
                        <li><a href="#">Location</a></li>
                        <li><a href="<?php echo $statuspage ?>"><?php echo $status ?></a></li>
                    </ul>
                </nav>
            </div>


        </header>

        <?php

    $stid = 'SELECT * FROM CAR';

                               $stid = oci_parse($conn, $stid);
                               oci_execute($stid);

                               echo "<h1>Cars Available to Book:</h1><br>";

                               while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                                   echo "<h6><i><b>ID: </b>" .$row[0] . "</i></h6>";
                                   echo "<h6><i><b>Make: </b>" .$row[1] . "</i></h6>";
                                   echo "<h6><i><b>Model: </b>" .$row[2] . "</i></h6>";
                                   echo "<h6><i><b>Year: </b>" .$row[4] . "</i></h6>";
                                   echo "<h6><i><b>Transmission: </b>" .$row[7] . "</i></h6>";
                                   echo "<h6><i><b>Condition: </b>" .$row[8] . "</i></h6>";
                                   echo "<h6><i><b>Odometer: </b>" .$row[6] . "km</i></h6>";
                                   echo "<h6><i><b>Location: </b>" .$row[3] . "</i></h6>";
                                   echo "<h6><i><b>Price: </b>$" .$row[5] . "AUD</i></h6>";
                                   echo "<h6><a href='bookcar.php?id=".$row[0]."'> Book Car</a></h6>";
                                   echo "<p>--------------------------------------------------------</p>\n";
                               } 


                               oci_close($conn);
        ?>

    </body>
    <?php
        include('footer.php');
    ?>

</html>