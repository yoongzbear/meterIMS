<?php 
include ('secure_TestLab.php');
include('connection.php');

// Check if form is submitted and batch_id is set
if (isset($_POST['confirm']) && isset($_POST['batch_id'])) {
    // Assign batch_id from POST data
    $batch_id = $_POST['batch_id'];

    // Query to get batch info
    $batchinfo_sql = "SELECT * FROM batch WHERE batch_id = $batch_id";
    $infoResult = mysqli_query($connection, $batchinfo_sql);
    $infoRow = mysqli_fetch_array($infoResult);
    if (!$infoRow) {
        die('Batch ID not found: ' . mysqli_error($connection));
    }
    $meter_type = $infoRow['meter_type'];
    $meter_model = $infoRow['meter_model'];
    $meter_size = $infoRow['meter_size'];
    $meter_quantity = $infoRow['quantity'];

    // Start transaction
    mysqli_begin_transaction($connection);

    // Insert new batch
    $insert_sql = "INSERT INTO batch (meter_type, meter_model, meter_size, quantity) VALUES ('$meter_type', '$meter_model', '$meter_size', '$meter_quantity')";
    if (!mysqli_query($connection, $insert_sql)) {
        mysqli_rollback($connection);
        die('Error inserting into batch table: ' . mysqli_error($connection));
    }

    // Get batch id of new batch
    $new_batch_id = mysqli_insert_id($connection);

    // Update meters with new batch id where status is PASS
    $updateBatch_sql = "UPDATE meter SET batch_id = '$new_batch_id' WHERE batch_id = '$batch_id' AND meter_status = 'TESTED'";
    if (!mysqli_query($connection, $updateBatch_sql)) {
        mysqli_rollback($connection);
        die('Error updating meter table: ' . mysqli_error($connection));
    }

    // Query to count failed meters
    $countFailedMeter = "SELECT COUNT(*) AS failed_count FROM meter WHERE batch_id = $batch_id AND meter_status = 'FAILED'";
    $countResult = mysqli_query($connection, $countFailedMeter);
    if (!$countResult) {
        mysqli_rollback($connection);
        die('Error counting failed meters: ' . mysqli_error($connection));
    }
    $countRow = mysqli_fetch_assoc($countResult);
    $failed_count = $countRow['failed_count'];

    // Update the quantity of the old batch with the count of failed meters
    $updateOldBatchQuantity = "UPDATE batch SET quantity = '$failed_count' WHERE batch_id = '$batch_id'";
    if (!mysqli_query($connection, $updateOldBatchQuantity)) {
        mysqli_rollback($connection);
        die('Error updating old batch quantity: ' . mysqli_error($connection));
    }

    // Get the current date
    $date = date("Y-m-d"); // Format: YYYY-MM-DD
    
    // Origin and destination values
    $origin = 2;        // Air Selangor Lab
    $destination = 1;   // Air Selangor Inv

    // Prepare the SQL statement for movement table
    $sql1 = "INSERT INTO movement (outbound_id, inbound_id, ship_date, batch_id) VALUES (?, ?, ?, ?)";
    $stmt1 = mysqli_prepare($connection, $sql1);
    mysqli_stmt_bind_param($stmt1, "iisi", $origin, $destination, $date, $new_batch_id);

    // Execute the statement and check for errors
    if (!mysqli_stmt_execute($stmt1)) {
        mysqli_rollback($connection);
        die('Error executing statement 1: ' . mysqli_error($connection));
    }

    // Prepare the SQL statement for updating meter table
    $sql2 = "UPDATE meter SET meter_status = 'IN TRANSIT' WHERE batch_id = ? AND meter_status != 'FAILED'";
    $stmt2 = mysqli_prepare($connection, $sql2);
    mysqli_stmt_bind_param($stmt2, "i", $new_batch_id);

    // Execute the statement and check for errors
    if (!mysqli_stmt_execute($stmt2)) {
        mysqli_rollback($connection);
        die('Error executing statement 2: ' . mysqli_error($connection));
    }

    // Commit the transaction if all statements are successful
    mysqli_commit($connection);
    echo "<script>
    alert('Batch, batch movement, and meter status are updated successfully! You will be redirected to another window to print the new Batch QR for passed meters.');
    window.open('NewBatch_forPassBatch.php?Batch_ID=$new_batch_id');
    window.location.href = 'LabDep_Scan_to_Inv.php';
    </script>";

    // Close the statements
    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);

} else {
    echo '<script>alert("Form submission error."); window.location.href = "LabDep_Scan_to_Inv.php";</script>';
}
?>
