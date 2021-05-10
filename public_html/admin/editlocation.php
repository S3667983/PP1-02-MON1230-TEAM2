<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    header("Location: ../adminportal.php");
}

if(!isset($_GET['id'])){

    header("Location: locations.php");

}else{

    $id_get = $_GET['id'];

}

if(isset($_POST['update'])){

    $p_id = $_POST['id'];
    $p_name = $_POST['name'];

    $update = "UPDATE LOCATION
                SET POSTCODE = '".$p_id."', NAME = '".$p_name."'
                WHERE POSTCODE = '".$id_get."'";


    $stid3 = oci_parse ($conn, $update);

    oci_execute($stid3);

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


        <div id="wrapper">

            <div>
                <h1>Edit Location: <br></h1>
            </div>

            <?php

            $query = "SELECT * FROM LOCATION WHERE POSTCODE = '".$id_get."'";

            $stid = oci_parse ($conn, $query);
            oci_execute($stid);

            while (oci_fetch($stid)) {
                $name = oci_result($stid, 'NAME');
            } ?>

            <form action="#" method="post">
                <h7>Postcode:</h7><br>
                <input type="text" id="id" name="id" value="<?php echo $id_get ?>" required><br>
                <h7>Name:</h7><br>
                <input type="text" id="name" name="name" value="<?php echo $name ?>" required><br>
                <br>
                <input type="submit" value="Update" name="update">
            </form>

            <?php
    oci_close($conn);

            ?>

        </div>

    </body>

</html>