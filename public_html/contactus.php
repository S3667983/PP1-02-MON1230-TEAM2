<?php
session_start();
require_once('includes/dbconn.php');

if(isset($_SESSION['user'])){
    //if user is logged in
    $user = $_SESSION['user'];

    $statuspage = 'logout.php';
    $status = 'Logout, ' . $user;
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


    <?php include 'includes/header.php';?>

    <div class="wrapper">

            <h1>Contact Us: </h1>
            <p>Want to send us a query? Send an email address with your question to be contacted soon !</p><br>

        <form action="https://formspree.io/f/xeqvaykw" method="POST" id="my-form">
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname">
            </div>

            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email">
            </div>

            <div class="form-group">
                <label for="message">Message</label>  
                <textarea name="message" id="message" cols="30" rows="10"></textarea>
            </div>

            <input type="submit" value="Submit" id="submit">
        </form>

    </div>

    <?php include 'includes/footer.php';?>

</html>