<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Batch Receiving</title>
</head>
<body>
    <h1>Meter Receiving Form</h1>
    <p>Please scan the QR code on the box</p>
    <canvas id="qr-canvas" width="300" height="300" style="border:1px solid #000000;"></canvas>
    <button id="btn-scan-qr">Scan QR</button>
    <button id="btn-cancel-scan" hidden="">Cancel Scan</button>

    <form id="meterForm" action="store_ReceiveBatch.php" method="get" style="display:none;">
        <label for="batch_id">Batch ID:</label>
        <input type="text" id="outputData" name="Batch_ID" readonly>
        <p>is this the right batch ID?</p>
		
        <input type="submit" value="Yes">
        <button id="btn-cancel">No</button>
    </form>

    <script>
        //redirect to the meter install page if cancelled after scanning
        document.getElementById("btn-cancel").addEventListener("click", function(event) {
            event.preventDefault();
            window.location.href = 'store_ReceiveOrderScanMeterQR.php'; //chg to home
        });
    </script>

    <script src="qrPacked.js"></script>
    <script src="qrReader.js"></script>
</body>
</html>