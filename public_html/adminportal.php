<?php
session_start();
require_once('includes/dbconn.php');

if(isset($_SESSION['user'])){
    //if user is logged in
    echo '<script type="text/javascript">'; 
    echo 'alert("Please log out before viewing the admin portal!");'; 
    echo 'window.location.href = "index.php";';
    echo '</script>';
}else if(isset($_SESSION['admin'])){
    //if admin is already logged in
    header('Location: admin/index.php');
}

$statuspage = '';
$status = '';

if(isset($_POST['username'])){

    $user = $_POST['username'];
    $pass = $_POST['pass'];

    $query = "SELECT * FROM ADMINS WHERE USER_ADMIN = '".$user."' and PASSWORD = '".$pass."'";
    $result = oci_parse($conn, $query);
    oci_execute($result);
    $numrows = oci_fetch_all($result, $res);

    //if admin user and pass matches the database logins

    if($numrows > 0){
        $_SESSION['admin'] = "admin";
        header('Location: admin/index.php');
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
            <h1>Admin Portal Login: </h1>
        </div>

        <form action="#" method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="pass" placeholder="Password" required><br><br>
            <input type="submit" value="Log In" id="submit">
        </form>

    </div>
</html>