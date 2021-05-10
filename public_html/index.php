<!DOCTYPE html>
<?php
session_start();
require_once('includes/dbconn.php');

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];

    $statuspage = 'logout.php';
    $status = 'Logout';
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
                        <li><a href="<?php echo $statuspage ?>"><?php echo $status ?></a></li>
                    </ul>
                </nav>
            </div>


        </header>

    </body>

</html>