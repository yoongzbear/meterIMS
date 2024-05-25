<?php
include('secure_TestLab.php'); 
include('connection.php');

if(isset($_POST['batch_id'])) {
    $batch_id = $_POST['batch_id'];

    //Query to check if the batch ID exists in the database
    $query = "SELECT * FROM batch JOIN movement ON batch.batch_id = movement.batch_id WHERE movement.batch_id = '$batch_id' ";
    $result = mysqli_query($connection, $query);
    //Query to check whether the all meter in the bacth has tested
    $query1 = "SELECT * FROM batch JOIN meter ON meter.batch_id = batch.batch_id JOIN lab_result ON lab_result.serial_num = meter.serial_num WHERE lab_result.result IS NULL AND batch.batch_id = '$batch_id'";
    $result1 = mysqli_query($connection, $query1);
    //Query to check whether the batch has been received at test lab
    $query2 = "SELECT batch.*, movement.* FROM batch JOIN movement ON batch.batch_id = movement.batch_id WHERE movement.batch_id = '$batch_id' AND movement.inbound_id IN (1, 3, 4, 5) ORDER BY movement.tracking_id DESC LIMIT 1";
    $result2 = mysqli_query($connection, $query2);

    //Check if the query returned any rows
    if(mysqli_num_rows($result) > 0 ) {
        if(mysqli_num_rows($result1) == 0 && mysqli_num_rows($result2) == 0) {
            // Batch ID exists and test result is entered
            header("Location: Insert_lab_to_inv_mov_form.php?batch_id=$batch_id");
            exit();
        } elseif (mysqli_num_rows($result1) > 0 && mysqli_num_rows($result2) == 0) {
            // Batch ID exists but test result is not entered
            echo '<script>alert("Please enter the test result before sending out!!"); window.location.href = "LabDep_Scan_to_Inv.php";</script>';
        } elseif (mysqli_num_rows($result1) == 0 && mysqli_num_rows($result2) > 0) {
            // Batch ID exists but has not been received at test lab condition 1
            echo '<script>alert("This batch has not been received at the test lab for testing."); window.location.href = "LabDep_Scan_to_Inv.php";</script>';
        }else{
            echo '<script>alert("Invalid Batch. Please try again."); window.location.href = "LabDep_Scan_to_Inv.php";</script>';
        }
    } else {
        // Batch ID does not exist
        echo '<script>alert("Invalid Batch. Please try again."); window.location.href = "LabDep_Scan_to_Inv.php";</script>';
    }
}
?>
