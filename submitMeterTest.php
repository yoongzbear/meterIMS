<?php
include('connection.php');

$serial_num = $_POST['serial_num'];
$testResult = $_POST['testResult'];
if ($testResult == 'FAIL') {
    $defect = $_POST['defect'];
} else {
    $defect = NULL;
}

$sqlMeter = "SELECT * FROM meter WHERE serial_num = '$serial_num'";
$resultMeter = mysqli_query($connection, $sqlMeter);
$rowMeter = mysqli_fetch_assoc($resultMeter);

//function to update warranty status
function updateWarrantyStatus($serial_num, $testResult, $defect, $test_id) {
    include('connection.php');
    $sqlWarranty = "SELECT *, YEAR(lab_result.receive_date) AS receive_year FROM warranty INNER JOIN lab_result ON warranty.serial_num = lab_result.serial_num INNER JOIN meter ON warranty.serial_num = meter.serial_num WHERE warranty.serial_num = '$serial_num'";
    $resultWarranty = mysqli_query($connection, $sqlWarranty);
    if ($rowWarranty = mysqli_fetch_assoc($resultWarranty)) {
        $yearDiff = $rowWarranty['receive_year'] - $rowWarranty['manufactured_year']; 
        if ($testResult == 'FAIL' && $defect != '0' && $yearDiff <= 3) {
            $sqlUpdateWarranty = "UPDATE warranty INNER JOIN lab_result ON warranty.serial_num = lab_result.serial_num SET lab_result.test_date = CURDATE(), warranty.warranty_status = 'CAN CLAIM', warranty.test_id = '$test_id' WHERE warranty.warranty_id = ( SELECT warranty_id FROM ( SELECT warranty.warranty_id FROM warranty INNER JOIN lab_result ON warranty.serial_num = lab_result.serial_num WHERE warranty.serial_num = '$serial_num' ORDER BY lab_result.receive_date DESC, warranty.warranty_id DESC LIMIT 1 ) AS subquery );";            
        } else {
            $sqlUpdateWarranty = "UPDATE warranty INNER JOIN lab_result ON warranty.serial_num = lab_result.serial_num SET lab_result.test_date = CURDATE(), warranty.warranty_status = 'CANNOT CLAIM', warranty.test_id = '$test_id' WHERE warranty.warranty_id = ( SELECT warranty_id FROM ( SELECT warranty.warranty_id FROM warranty INNER JOIN lab_result ON warranty.serial_num = lab_result.serial_num WHERE warranty.serial_num = '$serial_num' ORDER BY lab_result.receive_date DESC, warranty.warranty_id DESC LIMIT 1 ) AS subquery );";           
        }
        mysqli_query($connection, $sqlUpdateWarranty);
    } 
}
//if fail, update meter.batch id to null and minus 1 from the batch quantity
if ($testResult == 'FAIL') {
    $sqlBatch = "UPDATE batch INNER JOIN meter ON batch.batch_id = meter.batch_id SET batch.quantity = batch.quantity - 1, meter.meter_status = 'FAILED' WHERE meter.serial_num = '$serial_num'";
    if ($defect != '0') {
        $sqlLab = "UPDATE lab_result SET defect_id = '$defect', test_date = CURDATE(), result = 'FAILED' WHERE serial_num = '$serial_num' AND test_date IS NULL;";
    } else {
        $sqlLab = "UPDATE lab_result SET test_date = CURDATE(), result = 'FAILED' WHERE serial_num = '$serial_num' AND test_date IS NULL;";
    }
} else {
    $sqlBatch = "UPDATE batch INNER JOIN meter ON batch.batch_id = meter.batch_id SET meter.meter_status = 'TESTED' WHERE meter.serial_num = '$serial_num'";
    $sqlLab = "UPDATE lab_result SET test_date = CURDATE(), result = 'PASSED' WHERE serial_num = '$serial_num' AND test_date IS NULL;"; 
}

//sql to see if got warranty or not
$sqlWarrantyView = "SELECT * FROM warranty WHERE serial_num = '$serial_num'";
$resultWarrantyView = mysqli_query($connection, $sqlWarrantyView);
$rowWarrantyView = mysqli_fetch_assoc($resultWarrantyView);

if (mysqli_query($connection, $sqlLab)) {
    // Retrieve the last inserted ID
    $sqlGetTestId = "SELECT test_id FROM lab_result WHERE serial_num = '$serial_num' ORDER BY test_date DESC LIMIT 1";
    $getTest_Id = mysqli_query($connection, $sqlGetTestId);
    $rowTest_Id = mysqli_fetch_assoc($getTest_Id);
    if (mysqli_num_rows($resultWarrantyView) > 0) {
        updateWarrantyStatus($serial_num, $testResult, $defect, $rowTest_Id['test_id']);
    }
    mysqli_query($connection, $sqlBatch);
    echo "<script>alert('Meter test result submitted successfully!');
    window.location.href='meterTest.php';
    </script>";
} else {
    echo "<script>alert('Meter test result failed to submit, try again.');
    window.location.href='meterTest.php';
    </script>";
}
?>
