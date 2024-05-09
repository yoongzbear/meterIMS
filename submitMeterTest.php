<?php
include('connection.php');

$serial_num = $_GET['serial_num'];
$testResult = $_GET['testResult'];
if ($testResult == 'FAIL') {
    $defect = $_GET['defect'];
} else {
    $defect = NULL;
}

//get meter info
$sqlMeter = "SELECT * FROM meter WHERE serial_num = '$serial_num'";
$resultMeter = mysqli_query($connection, $sqlMeter);
$rowMeter = mysqli_fetch_assoc($resultMeter);

//function to update warranty status
function updateWarrantyStatus($serial_num, $testResult, $defect) {
    include('connection.php');
    //get received year, warranty and lab result information
    $sqlWarranty = "SELECT *, YEAR(lab_result.receive_date) AS receive_year FROM warranty INNER JOIN lab_result ON warranty.test_id = lab_result.test_id INNER JOIN meter ON lab_result.serial_num = meter.serial_num WHERE lab_result.serial_num = '$serial_num'";
    $resultWarranty = mysqli_query($connection, $sqlWarranty);
    if ($rowWarranty = mysqli_fetch_assoc($resultWarranty)) {
        //year difference = received year - manufactured year
        $yearDiff = $rowWarranty['receive_year'] - $rowWarranty['manufactured_year']; 
        //sql to update warranty status
        if ($testResult == 'FAIL' && $defect != '0' && $yearDiff <= 3) {
            $sqlUpdateWarranty = "UPDATE warranty INNER JOIN lab_result ON warranty.test_id = lab_result.test_id SET warranty.warranty_status = 'CAN CLAIM' WHERE warranty.warranty_id = ( SELECT warranty_id FROM ( SELECT warranty.warranty_id FROM warranty INNER JOIN lab_result ON warranty.test_id = lab_result.test_id WHERE lab_result.serial_num = '$serial_num') AS subquery );";            
        } else {
            "UPDATE warranty INNER JOIN lab_result ON warranty.test_id = lab_result.test_id SET warranty.warranty_status = 'CANNOT CLAIM' WHERE warranty.warranty_id = ( SELECT warranty_id FROM ( SELECT warranty.warranty_id FROM warranty INNER JOIN lab_result ON warranty.test_id = lab_result.test_id WHERE lab_result.serial_num = '$serial_num') AS subquery );";           
        }
        mysqli_query($connection, $sqlUpdateWarranty);
    } 
}
//if fail, minus 1 from the batch quantity
if ($testResult == 'FAIL') {
    //sql update batch
    $sqlMeter = "UPDATE batch INNER JOIN meter ON batch.batch_id = meter.batch_id SET batch.quantity = batch.quantity - 1, meter.meter_status = 'FAILED' WHERE meter.serial_num = '$serial_num'";
    //sql update lab result
    if ($defect != '0') {
        $sqlLab = "UPDATE lab_result SET defect_id = '$defect', test_date = CURDATE(), result = 'FAILED' WHERE serial_num = '$serial_num' AND test_date IS NULL;";
    } else {
        $sqlLab = "UPDATE lab_result SET test_date = CURDATE(), result = 'FAILED' WHERE serial_num = '$serial_num' AND test_date IS NULL;";
    }
} else {
    $sqlMeter = "UPDATE meter SET meter_status = 'TESTED' WHERE serial_num = '$serial_num'";
    $sqlLab = "UPDATE lab_result SET test_date = CURDATE(), result = 'PASSED' WHERE serial_num = '$serial_num' AND test_date IS NULL;"; 
}

//sql to see if got warranty or not
$sqlWarrantyView = "SELECT * FROM warranty INNER JOIN lab_result ON warranty.test_id = lab_result.test_id INNER JOIN meter ON lab_result.serial_num = meter.serial_num WHERE lab_result.serial_num = '$serial_num'";
$resultWarrantyView = mysqli_query($connection, $sqlWarrantyView);
$rowWarrantyView = mysqli_fetch_assoc($resultWarrantyView);

if (mysqli_query($connection, $sqlLab) && mysqli_query($connection, $sqlMeter)) {
    if (mysqli_num_rows($resultWarrantyView) > 0) {
        updateWarrantyStatus($serial_num, $testResult, $defect);
    }    
    echo "<script>alert('Meter test result submitted successfully!');
    window.location.href='meterTest.php';
    </script>";
} else {
    echo "<script>alert('Meter test result failed to submit, try again.');
    window.location.href='meterTest.php';
    </script>";
} ?>