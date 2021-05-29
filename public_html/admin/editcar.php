<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    //if admin isnt logged in
    header("Location: ../adminportal.php");
}

if(!isset($_GET['id'])){
    //if get id isnt set
    header("Location: cars.php");

}else{

    $id_get = $_GET['id'];

}

if(isset($_POST['update'])){

    //if admin posts update car data

    $p_id = $_POST['id'];
    $p_make = $_POST['make'];
    $p_model = $_POST['model'];
    $p_postcode = $_POST['postcode'];
    $p_year = $_POST['year'];
    $p_price = $_POST['price'];
    $p_odometer = $_POST['odometer'];
    $p_transmission = $_POST['transmission'];

    $update = "UPDATE CAR
                SET ID = '".$p_id."', MAKE = '".$p_make."', MODEL = '".$p_model."', POSTCODE = '".$p_postcode."', YEAR = '".$p_year."', PRICE = '".$p_price."', ODOMETER = '".$p_odometer."', TRANSMISSION = '".$p_transmission."'
                WHERE ID = '".$id_get."'";


    $stid = oci_parse ($conn, $update);

    oci_execute($stid);

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

        <?php include '../includes/adminheader.php';

        //select car data to display in field

        $query = "SELECT * FROM CAR WHERE ID = '".$id_get."'";

        $stid = oci_parse ($conn, $query);
        oci_execute($stid);

        while (oci_fetch($stid)) {
            //assign to php variables
            $make = oci_result($stid, 'MAKE');
            $model = oci_result($stid, 'MODEL');
            $postcode = oci_result($stid, 'POSTCODE');
            $year = oci_result($stid, 'YEAR');
            $price = oci_result($stid, 'PRICE');
            $odometer = oci_result($stid, 'ODOMETER');
            $transmission = oci_result($stid, 'TRANSMISSION');
        } 

        //select location data to display in the edit car location dropdown
        $stid = 'SELECT * FROM LOCATION ORDER BY POSTCODE';

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);
        ?>

        <div class="wrapper">

            <div>
                <h1>Edit Car: <br></h1>
            </div>

            <form action="#" method="post">
                <h7>Car ID:</h7><br>
                <input type="text" name="id" value="<?php echo $id_get ?>" required><br>
                <h7>Make:</h7><br>
                <input type="text" name="make" value="<?php echo $make ?>" required><br>
                <h7>Model:</h7><br>
                <input type="text" name="model" value="<?php echo $model ?>" required><br>
                <h7>Year:</h7><br>
                <input type="text" name="year" value="<?php echo $year ?>" pattern="[0-9]{4}" required><br>
                <h7>Odometer (KM):</h7><br>
                <input type="text" name="odometer" value="<?php echo $odometer ?>" pattern="[0-9]{0-7}" required><br>
                <h7>Transmission:</h7><br>
                <select name="transmission" class="select"required>
                    <option value="Automatic"<?php if($transmission == 'Automatic'){echo("selected");}?>>Automatic</option>
                    <option value="Manual"<?php if($transmission == 'Manual'){echo("selected");}?>>Manual</option>
                    <option value="Semi-Auto"<?php if($transmission == 'Semi-Auto'){echo("selected");}?>>Semi-Auto</option>
                </select><br>
                <h7>Postcode:</h7><br>
                <select name="postcode" class="select" required>
                    <?php //location dropdown based on the previous stid query
                    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) { ?>
                    <option value="<?php echo $row[0] ?>" <?php if($postcode == $row[0]){echo("selected");}?> >  <?php echo $row[3] . ", " . $row[1] . " " . $row[0] ?>  </option>
                    <?php } ?> 
                </select><br>
                <h7>Base Price ($AUD):</h7><br>
                <input type="text" name="price" value="<?php echo $price ?>" pattern="[0-9]{0-7}" required><br>
                <br>
                <input type="submit" value="Update" name="update" id="submit">
            </form>

            <?php
    oci_close($conn);

            ?>

        </div>

    </body>

</html>