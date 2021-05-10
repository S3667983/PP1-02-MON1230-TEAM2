<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    header("Location: ../adminportal.php");
}

if(isset($_POST['username'])){

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

    $query =    "INSERT INTO ACCOUNTS(USERNAME, PASSWORD, LASTNAME, FIRSTNAME, EMAIL, DOB, ADDRESS, STATE, SUBURB, POSTCODE, PHONE)" .
        "VALUES('".$user."','".$pass."','".$lastname."','".$firstname."','".$email."','".$dob."','".$address."','".$state."','".$suburb."','".$postcode."','".$ph."')";


    $changeDateFormat = oci_parse($conn, "ALTER SESSION SET NLS_DATE_FORMAT = \"YYYY-MM-DD\"");

    $compiled = oci_parse($conn, $query);

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

        <body>
            <div class="container">

                <div>
                    <h1>Register: </h1>
                </div>

                <form action="#" method="post">

                    <input type="text" id="username" name="username" placeholder="Username" required><br>
                    <input type="password" id="password" name="password" placeholder="Password"required><br>
                    <input type="text" id="firstname" name="firstname" placeholder="First Name"required><br>
                    <input type="text" id="lastname" name="lastname" placeholder="Last Name"required><br>
                    <input type="email" id="email" name="email" placeholder="Email"required><br>
                    <input type="date" id="dob" name="dob" required><br>
                    <input type="text" id="address" name="address" placeholder="Address"required><br>
                    <select name="state" class="select"required>
                        <option value="QLD">QLD</option>
                        <option value="NSW">NSW</option>
                        <option value="VIC">VIC</option>
                        <option value="TAS">TAS</option>
                        <option value="SA">SA</option>
                        <option value="WA">WA</option>
                        <option value="NT">NT</option>
                        <option value="ACT">ACT</option>
                    </select><br>
                    <input type="text" id="suburb" name="suburb" placeholder="Suburb"required><br>
                    <input type="text" id="postcode" name="postcode" placeholder="Postcode" pattern="[0-9]{4}" required><br>
                    <input type="text" id="phone" name="phone" placeholder="Phone Number" pattern="[0-9]{10}" required><br>

                    <input type="submit" value="Create" class="btn">
                </form>

            </div>
        </body>

        </html>

    <!--

<!DOCTYPE html>
<html lang="en">
<head>
<title>Login</title>
</head>
<link rel="stylesheet" href="loginregisterstyle.css" type="text/css">
<body>
<div class="container">
<form action="">
<div class="form-group">
<label for="regFullName"><b>Full Name</b></label>
<input type="text" placeholder="Full Name" name="regFullName" id="regFullName" required>
</div>

<div class="form-group">
<label for="regUserName"><b>Username</b></label>
<input type="text" placeholder="Username" name="regUserName" id="regUserName" required>
</div>

<div class="form-group">
<label for="logPassword"><b>Password</b></label>
<input type="text" placeholder="Password" name="logPassword" id="logPassword" required>
</div>

<div class="form-group">
<label for="regDOB"><b>Date of Birth</b></label>
<input type="date" placeholder="" name="regDOB" id="regDOB" required>
</div>

<div class="form-group">
<label for="regPhone"><b>Phone Number</b></label>
<input type="number" placeholder="Phone Number" name="regPhone" id="regPhone" required>
</div>


<input type="submit" class="btn" value="Register" name="regButton" id="regButton" onclick="window.location.href='login.html'">
</form>
</div>


</body>

</html> --!>