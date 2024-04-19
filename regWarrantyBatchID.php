<?php
include 'secure_Reg.php';
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warranty Batch ID Printing</title>
</head>
<body>
    <h3>Batch QR:</h3>
<div id="qrcode"></div>
<script src="qrcode.js"></script>
<script src="qrGeneratorBatch.js"></script>
<script>
    makeCode();
    print();
</script>
</body>
</html>