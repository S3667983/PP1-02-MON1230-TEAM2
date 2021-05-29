<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    //if admin isnt logged in
    header("Location: ../adminportal.php");
}

if(isset($_POST['id'])){

    //if admin posts the new car form    

    $id = $_POST['id'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $postcode = $_POST['postcode'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    $odometer = $_POST['odometer'];
    $transmission = $_POST['transmission'];

    $stid =    "INSERT INTO CAR(ID, MAKE, MODEL, POSTCODE, YEAR, PRICE, ODOMETER, TRANSMISSION)" .
        "VALUES('".$id."','".$make."','".$model."','".$postcode."','".$year."','".$price."','".$odometer."','".$transmission."')";


    $compiled = oci_parse($conn, $stid);

    oci_execute($compiled);
    oci_close($conn);

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

        //select all location data, ordering by postcode to display in the car location dropdown

        $stid = 'SELECT * FROM LOCATION ORDER BY POSTCODE';

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        oci_close($conn);

        ?>

        <div class="wrapper">

            <div>
                <h1>New Car: </h1>
            </div>

            <form action="#" method="post">
                <input type="text" name="id" placeholder="Car ID" required><br>
                <input type="text" name="make" placeholder="Make"required><br>
                <input type="text" name="model" placeholder="Model"required><br>
                <input type="text" name="year" placeholder="Year" pattern="[0-9]{4}" required><br>
                <input type="text" name="odometer" placeholder="Odometer (KM)" pattern="[0-9]{0-7}" required><br>
                <select name="transmission" class="select"required>
                    <option value="" selected disabled hidden>Transmission</option>
                    <option value="Automatic">Automatic</option>
                    <option value="Manual">Manual</option>
                    <option value="Semi-Auto">Semi-Automatic</option>
                </select><br>
                <select name="postcode" class="select" required>
                    <option value="" selected disabled hidden>Location </option>
                    <?php while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) { // location dropdown ?>
                    <option value="<?php echo $row[0] ?>">  <?php echo $row[3] . ", " . $row[1] . " " . $row[0]?>  </option>
                    <?php } ?>
                </select><br>
                <input type="text" name="price" placeholder="Base Price ($AUD)" pattern="[0-9]{0-7}" required><br>
                <br>
                <input type="submit" value="Create" id="submit">
            </form>

        </div>
    </body>

</html>