<?php
include 'secure_Reg.php';
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Meter Info</title>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        canvas{
            padding-left: 0;
            padding-right: 0;
            margin-left: auto;
            margin-right: auto;
            width: 350px; 
            height: 350px; 
            border: 1px #000000 solid; 
            display:block;
        }
    </style>
</head>
<body>
    <header>
        <?php 
            include 'header.php'; 
            include 'navReg.php';
        ?>
    </header>
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Home</li>
        <li class="breadcrumb-item active" aria-current="page">View Meter Info</li>
    </ol>
    </nav>
    <section>
        <div class="container col-lg-12 text-center" id="qrscanner">
            <h2 class="text-center">View Meter Infomation</h2>
            <p class="text-center mb-4">Please scan the QR code to view the meter information</p>
            <canvas hidden="" id="qr-canvas"></canvas>
            <button class= "btn btn-dark" id="btn-scan-qr" type="button">Click here to scan</button>
            <button class="btn btn-dark mt-4" id="btn-cancel-scan" type="button" hidden="">Click here to cancel scanning</button>
        </div>
        <div id="meterForm" class="col-lg-12 mt-5" style="display: none; width: 50%; margin:auto;">
            <h3 class="text-center">Is this the right serial number for the meter?</h3>
            <form method="POST" name="serial_num" class="text-center" action="RegDep_view_meter_info.php">
                <label>Meter Serial Number:</label>
                <input type="text" id="outputData" name="serial_num" required readonly>
                <button type="submit" class="btn btn-success m-2 pt-1 pb-1">Yes</button>
            </form>
        </div>
    </section>
    <footer>
        <?php 
            include 'footer.php'; 
        ?>
    </footer>
    <script src="qrPacked.js"></script>
    <script src="qrReader.js"></script>
</body>
</html>


