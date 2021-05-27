<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    //if admin isnt logged in
    header("Location: ../adminportal.php");
}

if(!isset($_GET['id'])){
    //if get id isnt set
    header("Location: locations.php");

}else{

    $id_get = $_GET['id'];

}

if(isset($_POST['update'])){

    //if admin posts update location data

    $p_id = $_POST['id'];
    $p_name = $_POST['name'];
    $p_address = $_POST['address'];
    $p_desc = $_POST['desc'];
    $p_lat = $_POST['lat'];
    $p_lon = $_POST['lon'];

    $update = "UPDATE LOCATION
                SET POSTCODE = '".$p_id."', NAME = '".$p_name."', DESCRIPTION = '".$p_desc."'
                WHERE POSTCODE = '".$id_get."'";


    $stid = oci_parse ($conn, $update);

    oci_execute($stid);

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

        <?php include '../includes/adminheader.php';

        //select all location data to display in the form

        $query = "SELECT * FROM LOCATION WHERE POSTCODE = '".$id_get."'";

        $stid = oci_parse ($conn, $query);
        oci_execute($stid);

        while (oci_fetch($stid)) {
            //assign to php variables
            $name = oci_result($stid, 'NAME');
            $desc = oci_result($stid, 'DESCRIPTION');
            $address = oci_result($stid, 'ADDRESS');
            $lat = oci_result($stid, 'LAT');
            $lon = oci_result($stid, 'LON');
        } ?>

        <div class="wrapper">

            <div>
                <h1>Edit Location: <br></h1>
            </div>

            <form action="#" method="post" id="editlocation">
                <h7>Postcode:</h7><br>
                <input type="text" name="id" value="<?php echo $id_get ?>" pattern="^(2|3)([0-9]{3})" required><br> <!-- html pattern only allowing vic/ nsw postcodes -->
                <h7>Suburb:</h7><br>
                <input type="text" name="name" value="<?php echo $name ?>" required><br>
                <h7>Address:</h7><br>
                <input type="text" name="address" value="<?php echo $address ?>" required><br>
                <h7>Description:</h7><br>
                <textarea form="editlocation" name="desc" rows="5" cols="35"required><?php echo $desc ?></textarea><br>
                <h7>Latitude:</h7><br>
                <input type="text" name="lat" value="<?php echo $lat ?>" pattern="^-?[0-9]\d*(\.\d+)?$" maxlength="7" required><br> <!-- latitude and longitude html pattern -->
                <h7>Longitude:</h7><br>
                <input type="text" name="lon" value="<?php echo $lon ?>" pattern="^-?[0-9]\d*(\.\d+)?$" maxlength="7" required><br>
                <br>
                <input type="submit" value="Update" name="update" id="submit">
            </form>

            <?php
    oci_close($conn);

            ?>

        </div>

    </body>

</html>