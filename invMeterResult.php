<?php include 'secure_Inv.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Result</title>
</head>
<body>
    <h1>View Meter Result</h1>
    <p>Please scan the QR code on the meter.</p>
    <canvas id="qr-canvas" width="300" height="300" style="border:1px solid #000000;"></canvas>
    <button id="btn-scan-qr">Scan QR</button>
    <button id="btn-cancel-scan">Cancel Scan</button>

    <form id="meterForm" action="invViewMeterResult.php" method="get" style="display:none;">
        <label for="serial_num">Meter Serial Number:</label>
        <input type="text" id="outputData" name="serial_num" readonly>
        <p>Is this the right meter serial number?</p>
        <input type="submit" value="Yes">
        <button id="btn-cancel">No</button>
    </form>

    <script>
        //redirect to the meter install page if cancelled after scanning
        document.getElementById("btn-cancel").addEventListener("click", function(event) {
            event.preventDefault();
            window.location.href = 'meterResult.php';
        });
    </script>

    <script src="qrPacked.js"></script>
    <script src="qrReader.js"></script>
</body>
</html>