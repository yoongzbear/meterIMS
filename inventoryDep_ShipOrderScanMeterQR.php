<?php
	$meterQuantity = $_GET['meterQuantity'];
	$batch_id = $_GET['Batch_ID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Shipping</title>
</head>
<body>
    <h1>Meter Shipping Form</h1>
    <p>Please scan the QR code on the water meter</p>
    <canvas id="qr-canvas" width="300" height="300" style="border:1px solid #000000;"></canvas>
    <button id="btn-scan-qr">Scan QR</button>
    <button id="btn-cancel-scan" style="display: none;">Cancel Scan</button>

    <form id="meterForm" action="invDep_ShipAddMeter.php" method="get" style="display:none;">
        <label for="serial_num">Meter Serial Number:</label>
        <input type="text" id="outputData" name="Meter_ID" readonly>
        <p>is this the right serial number meter?</p>
		
		<!--Send shipping info-->
		<input type="hidden" name="meterQuantity" value="<?php echo $meterQuantity;?>" readonly>
		<input type="hidden" name="batch_id" value="<?php echo $batch_id;?>" readonly>
		
        <input type="submit" value="Yes">
        <button id="btn-cancel">No</button>
    </form>

    <script>
        //redirect to the meter install page if cancelled after scanning
        document.getElementById("btn-cancel").addEventListener("click", function(event) {
            event.preventDefault();
            window.location.href = 'inventoryDep_ShipOrderScanMeterQR.php?Batch_ID=$batch_id&meterQuantity=$meterQuantity';
        });
    </script>

    <script src="qrPacked.js"></script>
    <script src="qrReader.js"></script>
</body>
</html>