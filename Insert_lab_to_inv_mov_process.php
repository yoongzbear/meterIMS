<?php 
include ('secure_TestLab.php');
include('connection.php');

//Check if form is submitted and batch_id is set
if(isset($_POST['confirm']) && isset($_POST['batch_id'])) {
    //Assign batch_id from POST data
    $batch_id = $_POST['batch_id'];
    
    //Get the current date
    $date = date("Y-m-d"); //Format: YYYY-MM-DD
    
    //Origin and destination values
    $origin = 2;        //Air Selangor Lab
    $destination = 1;    //Air Selangor Inv
    
    //Start transaction
    mysqli_begin_transaction($connection);

    //Prepare the SQL statement for movement table
    $sql1 = "INSERT INTO movement (outbound_id, inbound_id, ship_date, batch_id) VALUES (?, ?, ?, ?)";
    
    //Prepare the statement
    $stmt1 = mysqli_prepare($connection, $sql1);
    
    //Bind parameters
    mysqli_stmt_bind_param($stmt1, "iisi", $origin, $destination, $date, $batch_id);
    
    // Execute the statement and check for errors
    if (!mysqli_stmt_execute($stmt1)) {
        // Rollback the transaction if an error occurs
        mysqli_rollback($connection);
        die('Error executing: ' . mysqli_error($connection));
    }

    //Prepare the SQL statement for updating meter table
    $sql2 = "UPDATE meter SET meter_status = 'IN TRANSIT' WHERE batch_id = ? AND meter_status != 'FAILED'";
    
    //Prepare the statement
    $stmt2 = mysqli_prepare($connection, $sql2);
    
    //Bind parameters
    mysqli_stmt_bind_param($stmt2, "i", $batch_id);
    
    // Execute the statement and check for errors
    if (!mysqli_stmt_execute($stmt2)) {
        // Rollback the transaction if an error occurs
        mysqli_rollback($connection);
        die('Error executing statement 2: ' . mysqli_error($connection));
    }

    // Commit the transaction if both statements are successful
    mysqli_commit($connection);
    echo '<script>alert("Batch movement and meter status update successful."); window.location.href = "LabDep_Scan_to_Inv.php";</script>';

    // Close the statements
    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);
    
} else {
    echo'<script>alert("Form submission error."); window.location.href = "LabDep_Scan_to_Inv.php";</script>';
} ?>