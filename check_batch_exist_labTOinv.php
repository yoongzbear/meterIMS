<?php
include ('secure_TestLab.php'); 
include('connection.php');

if(isset($_POST['batch_id'])) {
    $batch_id = $_POST['batch_id'];

    //Query to check if the batch ID exists in the database
    $query = "SELECT * FROM batch WHERE batch_id = '$batch_id'";
    $result = mysqli_query($connection, $query);
    $query1= "SELECT * FROM batch JOIN meter ON meter.batch_id = batch.batch_id JOIN lab_result ON lab_result.serial_num = meter.serial_num WHERE lab_result.result IS NOT NULL AND batch.batch_id = '$batch_id'";
    $result1 = mysqli_query($connection, $query1);
    //Check if the query returned any rows
    if(mysqli_num_rows($result)>0 && mysqli_num_rows($result1)>0) {
        //Batch ID exists
        header("Location:Insert_lab_to_inv_mov_form.php?batch_id= $batch_id");
        exit();
    } if(mysqli_num_rows($result)>0 && mysqli_num_rows($result1)==0){
        echo '<script>alert("Please enter the test result before sending out!!"); window.location.href = "LabDep_Scan_to_Inv.php";</script>';
    }else {
        //Batch ID does not exist
        echo '<script>alert("Batch does not exist. Please try again."); window.location.href = "LabDep_Scan_to_Inv.php";</script>';
    }
} ?>
