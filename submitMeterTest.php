<?php
include('connection.php');

$serial_num = $_POST['serial_num'];
$testResult = $_POST['testResult'];
if ($testResult == 'FAIL') {
    $defect = $_POST['defect'];
}
$insertSuccess = false;

$sqlMeter = "SELECT * FROM meter WHERE serial_num = '$serial_num'";
$resultMeter = mysqli_query($connection, $sqlMeter);
$rowMeter = mysqli_fetch_assoc($resultMeter);

//function to update warranty status
function updateWarrantyStatus($serial_num, $testResult, $defect, $lastTestId) {
    include('connection.php');
    $sqlWarranty = "SELECT *, YEAR(lab_result.receive_date) AS receive_year FROM warranty INNER JOIN lab_result ON warranty.serial_num = lab_result.serial_num INNER JOIN meter ON warranty.serial_num = meter.serial_num WHERE warranty.serial_num = '$serial_num'";
    $resultWarranty = mysqli_query($connection, $sqlWarranty);
    $rowWarranty = mysqli_fetch_assoc($resultWarranty);
    $yearDiff = $rowWarranty['receive_year'] - $rowWarranty['manufactured_year']; 
    if ($rowWarranty) {
        if ($testResult == 'FAIL' && $defect != '0' && $yearDiff <= 3) {
            $sqlUpdateWarranty = "UPDATE warranty INNER JOIN lab_result ON warranty.serial_num = lab_result.serial_num SET lab_result.test_date = CURDATE(), warranty.warranty_status = 'CAN CLAIM', warranty.test_id = '$lastTestId' WHERE warranty.warranty_id = ( SELECT warranty_id FROM ( SELECT warranty.warranty_id FROM warranty INNER JOIN lab_result ON warranty.serial_num = lab_result.serial_num WHERE warranty.serial_num = '$serial_num' ORDER BY lab_result.receive_date DESC, warranty.warranty_id DESC LIMIT 1 ) AS subquery );";            
        } else {
            $sqlUpdateWarranty = "UPDATE warranty INNER JOIN lab_result ON warranty.serial_num = lab_result.serial_num SET lab_result.test_date = CURDATE(), warranty.warranty_status = 'CANNOT CLAIM', warranty.test_id = '$lastTestId' WHERE warranty.warranty_id = ( SELECT warranty_id FROM ( SELECT warranty.warranty_id FROM warranty INNER JOIN lab_result ON warranty.serial_num = lab_result.serial_num WHERE warranty.serial_num = '$serial_num' ORDER BY lab_result.receive_date DESC, warranty.warranty_id DESC LIMIT 1 ) AS subquery );";           
        }
        mysqli_query($connection, $sqlUpdateWarranty);
    } 
}

if ($testResult == 'FAIL' && $defect != '0') {
    $sqlLab = "INSERT INTO lab_result (serial_num, test_date, result, defect_id) VALUES ('$serial_num',  CURDATE(), '$testResult', '$defect')";
} else {
    $sqlLab = "INSERT INTO lab_result (serial_num, test_date, result) VALUES ('$serial_num', CURDATE(), '$testResult')";
}

$sqlMeterUpdate = "UPDATE meter SET install_date = NULL, meter_status = 'TESTED' WHERE serial_num = '$serial_num'";

if (mysqli_query($connection, $sqlLab)) {
    // Retrieve the last inserted ID
    $lastTestId = mysqli_insert_id($connection);
    updateWarrantyStatus($serial_num, $testResult, $defect, $lastTestId);
    mysqli_query($connection, $sqlMeterUpdate);
    echo "<script>alert('Meter test result submitted successfully!');
    window.location.href='meterTest.php';
    </script>";
} else {
    echo "<script>alert('Meter test result failed to submit, try again.');
    window.location.href='meterTest.php';
    </script>";
}
?>