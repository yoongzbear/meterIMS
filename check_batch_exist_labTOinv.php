<?php
include ('secure_TestLab.php'); 
include('connection.php');

if(isset($_POST['batch_id'])) {
    $batch_id = $_POST['batch_id'];

    //Query to check if the batch ID exists in the database
    $query = "SELECT * FROM batch WHERE batch_id = '$batch_id'";
    $result = mysqli_query($connection, $query);

    //Check if the query returned any rows
    if(mysqli_num_rows($result) > 0) {
        //Batch ID exists
        header("Location:Insert_lab_to_inv_mov_form.php?batch_id= $batch_id");
        exit();
    } else {
        //Batch ID does not exist
        echo '<script>alert("Batch does not exist. Please try again."); window.location.href = "LabDep_Scan_to_Inv.php";</script>';
    }
} ?>