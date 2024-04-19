<?php include 'secure_TestLab.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receive Meter Batch</title>
</head>
<body>
    <h1>Receive Meter Batch for Testing Form</h1>
    <p>Please scan the QR code on the received meter batch.</p>
    <canvas id="qr-canvas" width="300" height="300" style="border:1px solid #000000;"></canvas>
    <button id="btn-scan-qr">Scan QR</button>
    <button id="btn-cancel-scan">Cancel Scan</button>

    <form id="meterForm" action="submitBatchTest.php" method="post" style="display:none;">
        <label for="batch_id">Meter Batch ID:</label>
        <input type="text" id="outputData" name="batch_id" readonly>
        <p>Is this the right meter batch ID?</p>
        <input type="submit" value="Yes">
        <button id="btn-cancel">No</button>
    </form>

    <script>
        //redirect to the meter install page if cancelled after scanning
        document.getElementById("btn-cancel").addEventListener("click", function(event) {
            event.preventDefault();
            window.location.href = 'receiveBatchTest.php';
        });
    </script>

    <script src="qrPacked.js"></script>
    <script src="qrReader.js"></script>
</body>
</html>