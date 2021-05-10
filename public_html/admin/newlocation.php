<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    header("Location: ../adminportal.php");
}

if(isset($_POST['id'])){

    $id = $_POST['id'];
    $name = $_POST['name'];

    $query =    "INSERT INTO LOCATION(POSTCODE, NAME)" .
        "VALUES('".$id."','".$name."')";


    $compiled = oci_parse($conn, $query);

    oci_execute($compiled);
    oci_close($conn);

    header("Location: locations.php");

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
                        <li><a href="locations.php">Locations</a></li>
                        <li><a href="logout.php">Admin Portal Logout</a></li>
                    </ul>
                </nav>
            </div>


        </header>

        <div class="container">

            <div>
                <h1>New Location: </h1>
            </div>

            <form action="#" method="post">

                <input type="text" id="id" name="id" placeholder="Postcode" required><br>
                <input type="text" id="name" name="name" placeholder="Name"required><br>
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