<?php
include('connection.php');
$serial_num = $_GET['serial_num'];
$address = $_GET['address'];
$postcode = $_GET['postcode'];
$city = $_GET['city'];
$installAdd = $address . ', ' . $postcode . ', ' . $city;

//update meter information
$sql = "UPDATE meter SET install_date = CURDATE(), install_address = '$installAdd', meter_status = 'INSTALLED' WHERE serial_num = '$serial_num'";
if (mysqli_query($connection, $sql)) {
    echo "<script>alert('Meter installation form submitted successfully!');
    window.location.href='meterInstall.php';
    </script>";
} else {
    echo "<script>alert('Meter installation form failed to submit, try again.');
    window.location.href='meterInstall.php';
    </script>";
} ?>