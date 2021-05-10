<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    header("Location: ../adminportal.php");
}

if(isset($_POST['id'])){

    $id = $_POST['id'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $postcode = $_POST['postcode'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    $odometer = $_POST['odometer'];
    $transmission = $_POST['transmission'];
    $condition = $_POST['condition'];

    $query =    "INSERT INTO CAR(ID, MAKE, MODEL, POSTCODE, YEAR, PRICE, ODOMETER, TRANSMISSION, CONDITION)" .
        "VALUES('".$id."','".$make."','".$model."','".$postcode."','".$year."','".$price."','".$odometer."','".$transmission."','".$condition."')";


    $compiled = oci_parse($conn, $query);

    oci_execute($compiled);
    oci_close($conn);

    header("Location: cars.php");

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

        <div class="container">

            <div>
                <h1>New Car: </h1>
            </div>

            <form action="#" method="post">

                <input type="text" id="id" name="id" placeholder="ID" required><br>
                <input type="text" id="make" name="make" placeholder="Make"required><br>
                <input type="text" id="model" name="model" placeholder="Model"required><br>
                <input type="text" id="year" name="year" placeholder="Year" pattern="[0-9]{4}" required><br>
                <input type="text" id="odometer" name="odometer" placeholder="Odometer (KM)" pattern="[0-9]{0-7}" required><br>
                <select name="condition" class="select"required>
                    <option value="" selected disabled hidden>Condition</option>
                    <option value="New">New</option>
                    <option value="Used">Used</option>
                </select><br>
                <select name="transmission" class="select"required>
                    <option value="" selected disabled hidden>Transmission</option>
                    <option value="Automatic">Automatic</option>
                    <option value="Manual">Manual</option>
                    <option value="Semi-Auto">Semi-Automatic</option>
                </select><br>
                <input type="text" id="postcode" name="postcode" placeholder="Postcode" pattern="[0-9]{4}" required><br>
                <input type="text" id="price" name="price" placeholder="Price" pattern="[0-9]{0-7}" required><br>
                <br>
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