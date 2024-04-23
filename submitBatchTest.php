<?php
include('connection.php');

if(ISSET($_POST['batch_id'])){
    $batch_id = $_POST['batch_id'];
    try{
        //sql to check if batch exists and correct destination (lab test id = 2)
        $sqlBatch = "SELECT * FROM batch INNER JOIN movement ON batch.batch_id = movement.batch_id WHERE batch.batch_id = '$batch_id' AND destination = 2 AND arrival_date IS NULL;";
        $resultBatch = mysqli_query($connection, $sqlBatch);
        if (mysqli_num_rows($resultBatch) == 0) {
            throw new Exception();
        }

        //insert into lab result table
        $sqlInsert = "INSERT INTO lab_result (serial_num, receive_date) SELECT serial_num, CURDATE() FROM meter WHERE meter.batch_id = '$batch_id';";

        //location of batch to 2 (test lab) and meter status to TESTING
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
}
    catch(Exception $e){
        echo "<script>alert('Invalid Batch ID. Please try again.');
        window.location.href='receiveBatchTest.php';
        </script>";
        exit();
    }
}
?>