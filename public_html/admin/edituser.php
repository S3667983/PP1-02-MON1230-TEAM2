<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    header("Location: ../adminportal.php");
}

if(!isset($_GET['user'])){

    header("Location: users.php");

}else{

    $user_get = $_GET['user'];

}

if(isset($_POST['update'])){

    $p_user = $_POST['user'];
    $p_pass = $_POST['pass'];
    $p_fname = $_POST['fname'];
    $p_lname = $_POST['lname'];
    $p_email = $_POST['email'];
    $p_dob = $_POST['dob'];
    $p_address = $_POST['address'];
    $p_state = $_POST['state'];
    $p_suburb = $_POST['suburb'];
    $p_postcode = $_POST['postcode'];
    $p_phone = $_POST['phone'];

    $update = "UPDATE ACCOUNTS
                SET USERNAME = '".$p_user."', PASSWORD = '".$p_pass."', FIRSTNAME = '".$p_fname."', LASTNAME = '".$p_lname."', EMAIL = '".$p_email."', DOB = '".$p_dob."', ADDRESS = '".$p_address."', STATE = '".$p_state."', SUBURB = '".$p_suburb."', POSTCODE = '".$p_postcode."', PHONE = '".$p_phone."'
                WHERE USERNAME = '".$user_get."'";

    $changeDateFormat = oci_parse($conn, "ALTER SESSION SET NLS_DATE_FORMAT = \"YYYY-MM-DD\"");


    $stid3 = oci_parse ($conn, $update);

    oci_execute($changeDateFormat);
    oci_execute($stid3);

    header("Location: users.php");

}

?>
<html>
    <head>
        <link rel="stylesheet" href="../style.css">
        <meta charset="UTF-8">
        <title>Admin Portal</title>
    </head>


    <body>

        <header>
            <div class="container">

                <img src="../img/logo.png" alt="logo" class="logo">

                <nav>
                    <ul>
                        <li><a href="users.php">Users</a></li>
                        <li><a href="cars.php">Cars</a></li>
                        <li><a href="logout.php">Admin Portal Logout</a></li>
                    </ul>
                </nav>
            </div>


        </header>


        <div id="wrapper">

            <div>
                <h1>Edit User: <br></h1>
            </div>

            <?php

            $query = "SELECT * FROM ACCOUNTS WHERE USERNAME = '".$user_get."'";

            $stid = oci_parse ($conn, $query);
            oci_execute($stid);

            while (oci_fetch($stid)) {
                $pass = oci_result($stid, 'PASSWORD');
                $fname = oci_result($stid, 'FIRSTNAME');
                $lname = oci_result($stid, 'LASTNAME');
                $email = oci_result($stid, 'EMAIL');
                $dob = oci_result($stid, 'DOB');
                $address = oci_result($stid, 'ADDRESS');
                $state = oci_result($stid, 'STATE');
                $suburb = oci_result($stid, 'SUBURB');
                $postcode = oci_result($stid, 'POSTCODE');
                $ph = oci_result($stid, 'PHONE');
            } ?>

            <form action="#" method="post">
                <h7>Username:</h7><br>
                <input type="text" id="user" name="user" value="<?php echo $user_get ?>" required><br>
                <h7>Password:</h7><br>
                <input type="password" id="pass" name="pass" value="<?php echo $pass ?>" required><br>
                <h7>First Name:</h7><br>
                <input type="text" id="fname" name="fname" value="<?php echo $fname ?>" required><br>
                <h7>Last Name:</h7><br>
                <input type="text" id="lname" name="lname" value="<?php echo $lname ?>" required><br>
                <h7>Email:</h7><br>
                <input type="email" id="email" name="email" value="<?php echo $email ?>" required><br>
                <h7>Date of Birth:</h7><br>
                <input type="date" id="dob" name="dob" value="<?php echo $dob ?>" required><br>
                <h7>Address:</h7><br>
                <input type="text" id="address" name="address" value="<?php echo $address ?>" required><br>
                <h7>State:</h7><br>
                <input type="text" id="state" name="state" value="<?php echo $state ?>" required><br>
                <h7>Suburb:</h7><br>
                <input type="text" id="suburb" name="suburb" value="<?php echo $suburb ?>" required><br>
                <h7>Postcode:</h7><br>
                <input type="text" id="postcode" name="postcode" value="<?php echo $postcode ?>" pattern="[0-9]{4}" required><br>
                <h7>Phone No:</h7><br>
                <input type="text" id="phone" name="phone" value="<?php echo $ph ?>" pattern="[0-9]{10}" required><br>
                <br>
                <input type="submit" value="Update" name="update">
            </form>

            <?php
    oci_close($conn);

            ?>

        </div>

    </body>

</html>