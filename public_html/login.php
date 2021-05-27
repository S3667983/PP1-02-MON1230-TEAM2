<?php
session_start();
require_once('includes/dbconn.php');

if(isset($_SESSION['user']) || isset($_SESSION['admin'])){
    //if user or admin is already logged in
    header('Location: index.php');
}

$statuspage = '';
$status = '';

if(isset($_POST['username'])){

    $user = $_POST['username'];
    $pass = $_POST['pass'];

    $query = "SELECT * FROM ACCOUNT WHERE USERNAME = '".$user."' and PASSWORD = '".$pass."'";
    $result = oci_parse($conn, $query);
    oci_execute($result);
    $numrows = oci_fetch_all($result, $res);
    
    //if there is a match to the username and pass in the database

    if($numrows > 0){
        $_SESSION['user'] = $user;
        header('Location: index.php');
    }

    oci_close($conn);
}

?>
<html>

    <head>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <title>Car Share Co.</title>
    </head>


    <?php include 'includes/header.php';?>

    <div class="wrapper">

        <div>
            <h1>Login: </h1>
        </div>

        <form action="#" method="post" class="login">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="pass" placeholder="Password" required><br><br>
            <input type="submit" id="submit" value="Log In">
        </form>
        
        <p><a href="register.php">Register a New Account</a></p>

    </div>

    <?php include 'includes/footer.php';?>
    
</html>