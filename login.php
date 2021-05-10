<?php
session_start();
require_once('includes/dbconn.php');

if(isset($_SESSION['user']) || isset($_SESSION['admin'])){
    header('Location: index.php');
}

if(isset($_POST['username'])){

    $user = $_POST['username'];
    $pass = $_POST['pass'];

    $query = "SELECT * FROM ACCOUNTS WHERE USERNAME = '".$user."' and PASSWORD = '".$pass."'";
    $result = oci_parse($conn, $query);
    oci_execute($result);
    $numrows = oci_fetch_all($result, $res);

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


    <header>
        <div class="container">

            <img src="img/logo.png" alt="logo" class="logo">

            <nav>
                <ul>
                    <li><a href="#">Car/ Rental Information</a></li>
                    <li><a href="#">Create Booking</a></li>
                    <li><a href="#">Manage Booking</a></li>
                    <li><a href="#">Location</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="wrapper">

        <div>
            <h1>Login: </h1>
        </div>

        <form action="#" method="post">
            <input type="text" id="username" name="username" placeholder="Username" required><br>
            <input type="password" id="pass" name="pass" placeholder="Password" required><br><br>
            <input type="submit" value="Log In">
        </form>

    </div>
    <?php
        include('footer.php');
    ?>
</html>