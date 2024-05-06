<?php
include('connection.php');

if(ISSET($_GET['batch_id'])){
    $batch_id = $_GET['batch_id'];
    try{
        //sql to check if batch exists and correct destination (lab test id = 2)
        $sqlBatch = "SELECT * FROM batch INNER JOIN movement ON batch.batch_id = movement.batch_id WHERE batch.batch_id = '$batch_id' AND inbound_id = 2 AND arrival_date IS NULL;";
        $resultBatch = mysqli_query($connection, $sqlBatch);
        if (mysqli_num_rows($resultBatch) == 0) {
            throw new Exception();
        }
        
        //check if got warranty or not (if test id already created for the meter, then got warranty)
        $sqlCheckWarranty = "SELECT * FROM lab_result WHERE serial_num IN (SELECT serial_num FROM meter WHERE batch_id = '$batch_id');";
        $resultCheckWarranty = mysqli_query($connection, $sqlCheckWarranty);

        if (mysqli_num_rows($resultCheckWarranty) > 0) {
            //update lab result receive date for the warranty
            $sqlLabResult = "UPDATE lab_result SET receive_date = CURDATE() WHERE serial_num IN (SELECT serial_num FROM meter WHERE batch_id = '$batch_id');";            
        } else {
            //insert into lab result table - for initial test
            $sqlLabResult = "INSERT INTO lab_result (serial_num, receive_date) SELECT serial_num, CURDATE() FROM meter WHERE batch_id = '$batch_id';";
        }    
        
        //meter status to TESTING
        $sqlUpdateMeter = "UPDATE meter SET meter_status = 'TESTING' WHERE batch_id = '$batch_id';";

        //update movement tracking arrival date
        $sqlUpdateMovement = "UPDATE movement SET arrival_date = CURDATE() WHERE batch_id = '$batch_id' AND arrival_date IS NULL;";

        if (mysqli_query($connection, $sqlLabResult) && mysqli_query($connection, $sqlUpdateMeter) && mysqli_query($connection, $sqlUpdateMovement)){
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
} ?>