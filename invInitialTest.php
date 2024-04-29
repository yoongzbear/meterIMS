<?php
include 'secure_Inv.php';
include 'connection.php';
if(ISSET($_POST['batchID'])){
    $batchID = $_POST['batchID'];
    try{
        //insert batch into movement table        
        $movementquery = "INSERT INTO movement VALUES (DEFAULT, 1, 2, (CURRENT_DATE), NULL, $batchID)";
        $movementrun = mysqli_query($connection, $movementquery);
        //update meter status
        $update_status= "UPDATE meter SET meter_status = 'IN TRANSIT' WHERE batch_id =$batchID";
        $update_status_run= mysqli_query($connection,$update_status);
        if($movementrun && $update_status_run){
            echo "<script>alert('Batch sent to lab successfully!');</script>";
            header("Refresh:0");
        } else {
            echo "<script>alert('Failed to send batch to lab!');</script>";
            header("Refresh:0");
        }
    }
    catch(Exception $e){
        echo "<script>alert('Error: Invalid Batch ID. Please try again.');</script>";
        header("Refresh:0");
        exit();
    }
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ship to Lab</title>
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
            include 'navInv.php';
        ?>
    </header>

    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="inv_mag_home.php" title='Home Page - Inventory Management Department'>Home</a></li>
            <li class="breadcrumb-item"><a href="Inv_QRmenu.php" title='QRcode Page'>QR Code</a></li>
            <li class="breadcrumb-item active" aria-current="page">Scan QR - Initial Ship Out To Lab</li>
        </ol>
    </nav>

    <section id="meteruninstall">
        <div class="container col-lg-12 text-center mb-4" id="qrscanner">
            <h2 class="text-center">Send Batch to Lab</h2>
            <p class="text-center mb-4">Please scan the QR code for the batch to send it to lab for initial testing.</p>
            <canvas hidden="" id="qr-canvas"></canvas>
            <button class= "btn btn-dark" id="btn-scan-qr" type="button">Click to Scan</button>
            <button class="btn btn-dark mt-4" id="btn-cancel-scan" type="button" hidden="">Click to Cancel Scanning</button>
        </div>
        <div id="meterForm" class="col-lg-12 mt-5 border border-warning shadow mb-4 rounded" style="display: none; width: 50%; margin:auto;">
            <h3 class="text-center">Please Confirm that the Batch ID is Correct.</h3>
            <form method="POST" name="batchIDForm" class="text-center">
                <label>Batch ID : </label>
                <input type="text" id="outputData" name="batchID" placeholder="Batch ID" required readonly><br>
                <button type="submit" class="btn btn-success m-2 pt-1 pb-1 mt-4">Send to lab</button>
            </form>
        </div>
    </section>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script src="qrPacked.js"></script>
    <script src="qrReader.js"></script>
</body>
</html>