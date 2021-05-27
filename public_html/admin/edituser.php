<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    //if admin isnt logged in
    header("Location: ../adminportal.php");
}

if(!isset($_GET['user'])){
    //if get user isnt set
    header("Location: users.php");

}else{

    $user_get = $_GET['user'];

}

if(isset($_POST['update'])){

    //if admin posts update user data

    $p_user = $_POST['user'];
    $p_pass = $_POST['pass'];
    $p_fname = $_POST['fname'];
    $p_lname = $_POST['lname'];
    $p_email = $_POST['email'];
    $p_address = $_POST['address'];
    $p_state = $_POST['state'];
    $p_suburb = $_POST['suburb'];
    $p_postcode = $_POST['postcode'];
    $p_phone = $_POST['phone'];

    $update = "UPDATE ACCOUNT
                SET USERNAME = '".$p_user."', PASSWORD = '".$p_pass."', FIRSTNAME = '".$p_fname."', LASTNAME = '".$p_lname."', EMAIL = '".$p_email."', ADDRESS = '".$p_address."', STATE = '".$p_state."', SUBURB = '".$p_suburb."', POSTCODE = '".$p_postcode."', PHONE = '".$p_phone."'
                WHERE USERNAME = '".$user_get."'";


    //oracle specific date format
    $changeDateFormat = oci_parse($conn, "ALTER SESSION SET NLS_DATE_FORMAT = \"YYYY-MM-DD\"");


    $stid = oci_parse ($conn, $update);

    oci_execute($changeDateFormat);
    oci_execute($stid);

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

        <?php include '../includes/adminheader.php';

        //select all user data where username matches
        $query = "SELECT * FROM ACCOUNT WHERE USERNAME = '".$user_get."'";

        $stid = oci_parse ($conn, $query);
        oci_execute($stid);

        while (oci_fetch($stid)) {
            //grab variables in php to display in form
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

        <div class="wrapper">

            <div>
                <h1>Edit User: <br></h1>
            </div>

            <form action="#" method="post">
                <h7>Username:</h7><br>
                <input type="text" name="user" value="<?php echo $user_get ?>" required><br>
                <h7>Password:</h7><br>
                <input type="password" name="pass" value="<?php echo $pass ?>" required><br>
                <h7>First Name:</h7><br>
                <input type="text" name="fname" value="<?php echo $fname ?>" required><br>
                <h7>Last Name:</h7><br>
                <input type="text" name="lname" value="<?php echo $lname ?>" required><br>
                <h7>Email:</h7><br>
                <input type="email" name="email" value="<?php echo $email ?>" required><br>
                <h7>Date of Birth:</h7><br>
                <input type="text" name="dob" value="<?php echo $dob ?>" disabled required><br>
                <h7>Address:</h7><br>
                <input type="text" name="address" value="<?php echo $address ?>" required><br>
                <h7>State:</h7><br>
                <select name="state" class="select"required>
                    <option value="NSW" <?php if($state == 'NSW'){echo("selected");}?> >NSW</option>
                    <option value="VIC" <?php if($state == 'VIC'){echo("selected");}?> >VIC</option>
                </select><br>
                <h7>Suburb:</h7><br>
                <input type="text" name="suburb" value="<?php echo $suburb ?>" required><br>
                <h7>Postcode:</h7><br>
                <input type="text" name="postcode" value="<?php echo $postcode ?>" pattern="[0-9]{4}" required><br>
                <h7>Phone No:</h7><br>
                <input type="text" name="phone" value="<?php echo $ph ?>" pattern="[0-9]{10}" required><br>
                <br>
                <input type="submit" value="Update" name="update" id="submit">
            </form>

            <?php
    oci_close($conn);
            ?>

        </div>

    </body>

</html>