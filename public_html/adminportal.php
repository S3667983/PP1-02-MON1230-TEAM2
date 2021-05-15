<?php
session_start();
require_once('includes/dbconn.php');

if(isset($_SESSION['user']) || isset($_SESSION['admin'])){
    header('Location: index.php');
}

if(isset($_POST['username'])){

    $user = $_POST['username'];
    $pass = $_POST['pass'];

    $query = "SELECT * FROM ADMINS WHERE USER_ADMIN = '".$user."' and PASSWORD = '".$pass."'";
    $result = oci_parse($conn, $query);
    oci_execute($result);
    $numrows = oci_fetch_all($result, $res);

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


    <?php
        include('adminHeader.php');
    ?>

    <div class="wrapper">

        <div>
            <h1>Admin Portal Login: </h1>
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