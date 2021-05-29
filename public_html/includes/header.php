<header>
    <div class="container">
        <a href="index.php"><img src="img/logo.png" alt="logo" class="logo"></a>
        <nav>
            <ul>
                <li><a href="index.php">Car/ Rental Information</a></li>
                <li><a href="booking.php">Create Booking</a></li>
                <li><a href="managebooking.php">Manage Booking</a></li>
                <li><a href="location.php">Locations</a></li>
                <?php if(isset($_SESSION['user'])){
                echo "<li><a href='edituser.php'>Account</a></li>";
                } ?>
                <li><a href="<?php echo $statuspage ?>"><?php echo $status ?></a></li>
            </ul>
        </nav>
    </div>
</header>