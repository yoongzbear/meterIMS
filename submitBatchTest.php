<?php
include('connection.php');
$batch_id = $_POST['batch_id'];

//insert into lab result table
$sqlInsert = "INSERT INTO lab_result (serial_num, receive_date) SELECT serial_num, CURDATE() FROM meter WHERE meter.batch_id = '$batch_id';";

//location of batch to 2 (test lab) 
$sqlUpdateMeter = "UPDATE meter INNER JOIN batch ON meter.batch_id = batch.batch_id SET batch.location_id = 2, meter.meter_status = 'TESTING' WHERE meter.batch_id = '$batch_id';";

//update movement tracking arrival date
$sqlUpdateMovement = "UPDATE movement SET arrival_date = CURDATE() WHERE batch_id = '$batch_id' AND arrival_date IS NULL;";

if (mysqli_query($connection, $sqlInsert) && mysqli_query($connection, $sqlUpdateMeter) && mysqli_query($connection, $sqlUpdateMovement)){
    echo "<script>alert('Meter batch received successfully!');
    window.location.href='receiveBatchTest.php';
    </script>";
} else {
    echo "<script>alert('Meter batch failed to receive, try again.');
    window.location.href='receiveBatchTest.php';
    </script>";
}
?>