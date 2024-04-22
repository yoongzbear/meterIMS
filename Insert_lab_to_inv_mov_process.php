<?php 
//include ('secure_TestLab.php'); 
include('connection.php');

// Check if form is submitted and batch_id is set
if(isset($_POST['confirm']) && isset($_POST['batch_id'])) {
    // Assign batch_id from POST data
    $batch_id = $_POST['batch_id'];
    
    // Get the current date
    $date = date("Y-m-d"); // Format: YYYY-MM-DD
    
    // Origin and destination values
    $origin = 2;        //"Air Selangor Lab"
    $destination = 1;    //"Air Selangor Inv"
    
    // Prepare the SQL statement for movement table
    $sql1 = "INSERT INTO movement (origin, destination, ship_date, batch_id) VALUES (?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt1 = mysqli_prepare($connection, $sql1);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt1, "iisi", $origin, $destination, $date, $batch_id);
    
    // Execute the statement
    mysqli_stmt_execute($stmt1);
    
    
    // Prepare the SQL statement for updating meter table
    $sql2 = "UPDATE meter SET meter_status = 'IN TRANSIT' WHERE batch_id = ?";
    
    // Prepare the statement
    $stmt2 = mysqli_prepare($connection, $sql2);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt2, "i", $batch_id);
    
    // Execute the statement
    mysqli_stmt_execute($stmt2);
    
    // Check if update was successful for both statements
    if(mysqli_stmt_affected_rows($stmt2) > 0 && mysqli_stmt_affected_rows($stmt1) > 0) {
        echo '<script>alert("Batch movement and meter status update successful."); window.location.href = "TestLab_QRmenu.php";</script>';
    } else {
        echo '<script>alert("Error: the meter status for that batch id has been updated' . mysqli_error($connection) . '"); window.location.href = "TestLab_QRmenu.php";</script>';
    }

    // Close the statement
    mysqli_stmt_close($stmt1);
    // Close the statement
    mysqli_stmt_close($stmt2);
    
} else {
    echo'<script>alert("Form submission error."); window.location.href = "TestLab_QRmenu.php";</script>';
}
?>
