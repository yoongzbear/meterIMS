<?php
include 'secure_Reg.php';
include 'connection.php';

if(isset($_GET['Meter_ID'])) {
    $batch_id = $_GET['batch_id'];
    $serial_num = $_GET['Meter_ID'];
    $meterQuantity = $_GET['meterQuantity'];

    // Query to check if the serial num exists in the database
    $query = "SELECT * FROM meter WHERE serial_num = '$serial_num'";
    $result = mysqli_query($connection, $query);

    // Check if the query returned any rows
    if(mysqli_num_rows($result) > 0) {
        //To check if the meter scanned exist in the batch
        $sqlMeterExist = "SELECT * FROM meter WHERE serial_num != '$serial_num' AND batch_id != '$batch_id'";
        $resultMeterExist = mysqli_query($connection, $sqlMeterExist);
        if(mysqli_num_rows($resultMeterExist) > 0) {            // serial num exists
            header("Location:store_ShipAddMeter.php?Meter_ID=$serial_num&Batch_ID=$batch_id&meterQuantity=$meterQuantity");
            exit();
        } else {
            echo '<script>alert("Meter have been scanned. Please try again with other meter."); window.location.href = "store_ShipOrderScanMeterQR.php?Batch_ID='.$batch_id.'&meterQuantity='.$meterQuantity.'";</script>';
        }
    } else {
        // serial num does not exist
        echo '<script>alert("Serial number does not exist. Please try again."); window.location.href = "store_ShipOrderScanMeterQR.php?Batch_ID='.$batch_id.'&meterQuantity='.$meterQuantity.'";</script>';
    }
}
?>
