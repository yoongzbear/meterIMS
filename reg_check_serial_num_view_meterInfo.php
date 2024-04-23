<?php
include 'secure_Reg.php';
include 'connection.php';

if(isset($_POST['serial_num'])) {
    $serial_num = $_POST['serial_num'];

    // Query to check if the serial num exists in the database
    $query = "SELECT * FROM meter WHERE serial_num = '$serial_num'";
    $result = mysqli_query($connection, $query);

    // Check if the query returned any rows
    if(mysqli_num_rows($result) > 0) {
        // serial num exists
        header("Location:RegDep_view_meter_info.php?serial_num= $serial_num");
        exit();
    } else {
        // serial num does not exist
        echo '<script>alert("Serial number does not exist. Please try again."); window.location.href = "RegDep_Scan_View_meter_info.php";</script>';
    }
}
?>