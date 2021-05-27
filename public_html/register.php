<?php
session_start();
require_once('includes/dbconn.php');

if(isset($_SESSION['user'])){
    //if user is already logged in, prevent from viewing page
    header("Location: index.php");
}else if(isset($_SESSION['admin'])){
    //if admin is logged in, prevent from viewing page
    header("Location: index.php");
}


$statuspage = '';
$status = '';

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

    // if a user with the same username already exists

    $query = "SELECT * FROM ACCOUNT WHERE USERNAME = '".$user."'";
    $result = oci_parse($conn, $query);
    oci_execute($result);
    $numrows = oci_fetch_all($result, $res);

    if($numrows > 0){
        header('Location: register.php');
    }

    $query =    "INSERT INTO ACCOUNT(USERNAME, PASSWORD, LASTNAME, FIRSTNAME, EMAIL, DOB, ADDRESS, STATE, SUBURB, POSTCODE, PHONE)" .
        "VALUES('".$user."','".$pass."','".$lastname."','".$firstname."','".$email."','".$dob."','".$address."','".$state."','".$suburb."','".$postcode."','".$ph."')";


    //oracle specific date format setting
    $changeDateFormat = oci_parse($conn, "ALTER SESSION SET NLS_DATE_FORMAT = \"YYYY-MM-DD\"");

    $compiled = oci_parse($conn, $query);

    oci_execute($changeDateFormat);
    oci_execute($compiled);
    oci_close($conn);

    //assign session username
    $_SESSION['user'] = $user;

    header("Location: index.php");

}


?>
<html>

    <head>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <title>Car Share Co.</title>
    </head>

    <?php include 'includes/header.php';?>

    <body>
        <div class="wrapper">

            <div>
                <h1>Register: </h1>
            </div>

            <form action="#" method="post">

                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password"required><br>
                <input type="text" name="firstname" placeholder="First Name"required><br>
                <input type="text" name="lastname" placeholder="Last Name"required><br>
                <input type="email" name="email" placeholder="Email"required><br>
                <input type="date" name="dob" required><br>
                <input type="text" name="address" placeholder="Address"required><br>
                <select name="state" class="select"required>
                    <option value="NSW">NSW</option>
                    <option value="VIC">VIC</option>
                </select><br>
                <input type="text" name="suburb" placeholder="Suburb"required><br>
                <input type="text" name="postcode" placeholder="Postcode" pattern="[0-9]{4}" required><br>
                <input type="text" name="phone" placeholder="Phone Number" pattern="[0-9]{10}" required><br><br>

                <input type="submit" value="Create" class="submit"><br><br>

                <input type="checkbox" id="priv" name="privacypolicy" required> I agree to the <a href="https://www.termsfeed.com/live/4c420d40-4eb7-452b-88a6-d066757767c5" target="_blank">Privacy Policy</a><br>
                
            </form>

        </div>
    </body>

    <?php include 'includes/footer.php';?>

</html>