<!DOCTYPE html>
<?php
session_start();
require_once('../includes/dbconn.php');

if(empty($_SESSION['admin'])){
    header("Location: ../adminportal.php");
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

        <?php

        $stid = 'SELECT * FROM ACCOUNTS';

        $stid = oci_parse($conn, $stid);
        oci_execute($stid);

        echo "<h1>Users: <a href='newuser.php'><b>+</b></a></h1><br>";

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            echo "<h6><i><b>Username: </b>" .$row[0] . "</i></h6>";
            echo "<h6><i><b>Password: </b>" .$row[1] . "</i></h6>";
            echo "<h6><i><b>First Name: </b>" .$row[3] . "</i></h6>";
            echo "<h6><i><b>Last Name: </b>" .$row[2] . "</i></h6>";
            echo "<h6><i><b>Email: </b>" .$row[5] . "</i></h6>";
            echo "<h6><i><b>Date of Birth: </b>" .$row[6] . "</i></h6>";
            echo "<h6><i><b>Address: </b>" .$row[7] . ", " . $row[9] . ", " . $row[8] . ", " .$row[10] . "</i></h6>";
            echo "<h6><i><b>Phone No: </b>" .$row[4] . "</i></h6>";
            echo "<h6><a href='edituser.php?user=".$row[0]."'> Edit User</a></h6>";
            echo "<h6><i><b><a href='removeuser.php?user=".$row[0]."'>Remove User </a></b></i></h6>";
            echo "<p>--------------------------------------------------------</p>\n";
        } 
        ?>


    </body>

</html>