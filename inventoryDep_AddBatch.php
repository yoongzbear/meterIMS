<?php
    include('secure_Inv.php');
    include('connection.php');
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $meter_type = $_POST["meter_type"];
        $meter_model = $_POST["meter_model"];
        $meter_size = $_POST["meter_size"];
        $manu_id = $_POST["manu_id"];
        
        //Insert meter batch info
        $sqlBatch = "INSERT INTO batch (location_id, meter_type, meter_model, meter_size) 
                     VALUES (1, '$meter_type', '$meter_model', '$meter_size')";
        
        $result = mysqli_query($connection, $sqlBatch);
        
        if ($result) {
            //Get batch ID
            $batch_id = mysqli_insert_id($connection);
            
            //Redirect to the form page with batch ID and manufacturer ID as parameters
            header("Location: inventoryDep_AddMeterForm.php?Batch_ID=$batch_id&manu_id=$manu_id");
            exit;
        } else {
            //Display error message and go back to the previous page on failure
            echo "<script>alert('Failed to add new meter.');</script>";
            echo "<script>window.history.back();</script>";
            exit; 
        }
    } else {
        //If the form is not submitted via POST request, redirect to an appropriate page
        header("Location: error.php");
        exit;
    }
?>
