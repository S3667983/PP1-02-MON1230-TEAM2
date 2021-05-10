<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    header("Location: ../adminportal.php");
}

if(!isset($_GET['id'])){

    header("Location: cars.php");

}else{

    $id_get = $_GET['id'];

}

if(isset($_POST['update'])){

    $p_id = $_POST['id'];
    $p_make = $_POST['make'];
    $p_model = $_POST['model'];
    $p_postcode = $_POST['postcode'];
    $p_year = $_POST['year'];
    $p_price = $_POST['price'];
    $p_odometer = $_POST['odometer'];
    $p_transmission = $_POST['transmission'];
    $p_condition = $_POST['condition'];

    $update = "UPDATE CAR
                SET ID = '".$p_id."', MAKE = '".$p_make."', MODEL = '".$p_model."', POSTCODE = '".$p_postcode."', YEAR = '".$p_year."', PRICE = '".$p_price."', ODOMETER = '".$p_odometer."', TRANSMISSION = '".$p_transmission."', CONDITION = '".$p_condition."'
                WHERE ID = '".$id_get."'";


    $stid3 = oci_parse ($conn, $update);

    oci_execute($stid3);

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


        <div id="wrapper">

            <div>
                <h1>Edit Car: <br></h1>
            </div>

            <?php

            $query = "SELECT * FROM CAR WHERE ID = '".$id_get."'";

            $stid = oci_parse ($conn, $query);
            oci_execute($stid);

            while (oci_fetch($stid)) {
                $make = oci_result($stid, 'MAKE');
                $model = oci_result($stid, 'MODEL');
                $postcode = oci_result($stid, 'POSTCODE');
                $year = oci_result($stid, 'YEAR');
                $price = oci_result($stid, 'PRICE');
                $odometer = oci_result($stid, 'ODOMETER');
                $transmission = oci_result($stid, 'TRANSMISSION');
                $condition = oci_result($stid, 'CONDITION');
            } ?>

            <form action="#" method="post">
                <h7>ID:</h7><br>
                <input type="text" id="id" name="id" value="<?php echo $id_get ?>" required><br>
                <h7>Make:</h7><br>
                <input type="text" id="make" name="make" value="<?php echo $make ?>" required><br>
                <h7>Model:</h7><br>
                <input type="text" id="model" name="model" value="<?php echo $model ?>" required><br>
                <h7>Year:</h7><br>
                <input type="text" id="year" name="year" value="<?php echo $year ?>" required><br>
                <h7>Odometer:</h7><br>
                <input type="text" id="odometer" name="odometer" value="<?php echo $odometer ?>" pattern="[0-9]{0-7}" required><br>
                <h7>Condition:</h7><br>
                <select name="condition" class="select"required>
                    <option value="New"<?php if($condition == 'New'){echo("selected");}?>>New</option>
                    <option value="Used"<?php if($condition == 'Used'){echo("selected");}?>>Used</option>
                </select><br>
                <h7>Transmission:</h7><br>
                <select name="transmission" class="select"required>
                    <option value="Automatic"<?php if($condition == 'Automatic'){echo("selected");}?>>Automatic</option>
                    <option value="Manual"<?php if($condition == 'Manual'){echo("selected");}?>>Manual</option>
                    <option value="Semi-Auto"<?php if($condition == 'Semi-Auto'){echo("selected");}?>>Semi-Auto</option>
                </select><br>
                <h7>Postcode:</h7><br>
                <input type="text" id="postcode" name="postcode" value="<?php echo $postcode ?>" pattern="[0-9]{4}" required><br>
                <h7>Price:</h7><br>
                <input type="text" id="price" name="price" value="<?php echo $price ?>" pattern="[0-9]{0-7}" required><br>
                <br>
                <input type="submit" value="Update" name="update">
            </form>

            <?php
    oci_close($conn);

            ?>

        </div>

    </body>

</html>