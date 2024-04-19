<?php
include 'secure_TestLab.php';
include 'connection.php';

$test_id = $_GET['test_id'];
$sql = "SELECT * FROM lab_result WHERE test_id = '$test_id'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM meter INNER JOIN batch ON meter.batch_id = batch.batch_id INNER JOIN manufacturer ON meter.manu_id = manufacturer.manu_id INNER JOIN lab_result ON lab_result.serial_num = meter.serial_num WHERE test_id = '$test_id'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

?>