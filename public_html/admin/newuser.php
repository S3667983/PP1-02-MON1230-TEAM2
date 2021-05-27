<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    //if admin isnt logged in
    header("Location: ../adminportal.php");
}

if(isset($_POST['username'])){
    
    //if admin posts data to create a new user

    $user = $_POST['username'];
    $pass = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $suburb = $_POST['suburb'];
    $postcode = $_POST['postcode'];
    $ph = $_POST['phone'];

    $stid =    "INSERT INTO ACCOUNT(USERNAME, PASSWORD, LASTNAME, FIRSTNAME, EMAIL, DOB, ADDRESS, STATE, SUBURB, POSTCODE, PHONE)" .
        "VALUES('".$user."','".$pass."','".$lastname."','".$firstname."','".$email."','".$dob."','".$address."','".$state."','".$suburb."','".$postcode."','".$ph."')";


    //oracle specific date format
    $changeDateFormat = oci_parse($conn, "ALTER SESSION SET NLS_DATE_FORMAT = \"YYYY-MM-DD\"");

    $compiled = oci_parse($conn, $stid);

    oci_execute($changeDateFormat);
    oci_execute($compiled);
    
    oci_close($conn);

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

        <?php include '../includes/adminheader.php';?>

        <body>
            
            <div class="wrapper">

                <div>
                    <h1>Add New User: </h1>
                </div>

                <form action="#" method="post">

                    <input type="text" name="username" placeholder="Username" required><br>
                    <input type="password" name="password" placeholder="Password"required><br>
                    <input type="text" name="firstname" placeholder="First Name"required><br>
                    <input type="text" name="lastname" placeholder="Last Name"required><br>
                    <input type="email" name="email" placeholder="Email"required><br>
                    <input type="date" name="dob" required><br>
                    <input type="text" name="address" placeholder="Address"required><br>
                    <input type="text" name="suburb" placeholder="Suburb"required><br>
                    <input type="text" name="postcode" placeholder="Postcode" pattern="[0-9]{4}" required><br>
                    <select name="state" class="select"required>
                        <option disabled selected hidden>State</option>
                        <option value="NSW">NSW</option>
                        <option value="VIC">VIC</option>
                    </select><br>
                    <input type="text" name="phone" placeholder="Phone Number" pattern="[0-9]{10}" required><br><br>

                    <input type="submit" value="Create" id="submit">
                </form>

            </div>
        </body>
    </body>

</html>