<?php include 'secure_TestLab.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Test Result</title>
</head>
<body>
    <h1>Meter Test Result Form</h1>
    <p>Please scan the QR code on the water meter to enter the test result.</p>
    <canvas id="qr-canvas" width="300" height="300" style="border:1px solid #000000;"></canvas>
    <!--is there a way to set the size without it expanding-->
    <button id="btn-scan-qr">Scan QR</button>
    <button id="btn-cancel-scan">Cancel Scan</button>

    <form id="meterForm" action="meterTestForm.php" method="post" style="display:none;">
        <label for="serial_num">Meter Serial Number:</label>
        <input type="text" id="outputData" name="serial_num" readonly>
        <p>Is this the right serial number meter?</p>
        <input type="submit" value="Yes">
        <button id="btn-cancel">No</button>
    </form>

    <script>
        //redirect to the meter install page if cancelled after scanning
        document.getElementById("btn-cancel").addEventListener("click", function(event) {
            event.preventDefault();
            window.location.href = 'meterTest.php';
        });
    </script>

    <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
    <script src="qrReader.js"></script>
</body>
</html>