<?php
include 'secure_Reg.php';
include 'connection.php';
if(ISSET($_POST['serialnum'])){
    $serialnum = $_POST['serialnum'];
    try{
    //get meter status and check if meter is uninstalled        
    $warrantycheckquery = "SELECT meter_status FROM meter WHERE serial_num = '$serialnum'";
    $warrantycheckrun = mysqli_query($connection, $warrantycheckquery);
    $warrantycheck = mysqli_fetch_assoc($warrantycheckrun);
    if(mysqli_num_rows($warrantycheckrun) == 0){
        throw new Exception();
    }
    if($warrantycheck['meter_status'] == 'SENT FOR WARRANTY'){
        echo "<script>alert('Error: Meter has already been sent for warranty.');</script>";
        header("Refresh:0");
        exit();
        }
    elseif($warrantycheck['meter_status'] != 'UNINSTALLED'){
        echo "<script>alert('Error: Meter has not been uninstalled yet.');</script>";
        header("Refresh:0");
        exit();
    }
    //get meter info
    $meterinfoquery = "SELECT batch.meter_type, batch.meter_model, batch.meter_size FROM batch, meter WHERE meter.batch_id = batch.batch_id AND meter.serial_num = '$serialnum'";
    $meterinforun = mysqli_query($connection, $meterinfoquery);
    $meterinfo = mysqli_fetch_assoc($meterinforun);
    }
    catch(Exception $e){
        echo "<script>alert('Error: Invalid Serial Number. Please try again.');</script>";
        header("Refresh:0");
        exit();
    }
    
    $locationquery = "SELECT location_id FROM `location` WHERE username = '$_SESSION[username]'";
    $locationrun = mysqli_query($connection, $locationquery);
    $location = mysqli_fetch_assoc($locationrun);

    $updatedmeterquantity = "UPDATE batch SET quantity = quantity - 1 WHERE batch_id = (SELECT batch_id FROM meter WHERE serial_num = '$serialnum')";
    $updatedmeterquantityrun = mysqli_query($connection, $updatedmeterquantity);

    $batchquery = "INSERT INTO batch VALUES (DEFAULT, '$location[location_id]', '$meterinfo[meter_type]', '$meterinfo[meter_model]', '$meterinfo[meter_size]', 1)";
    $batchresult = mysqli_query($connection, $batchquery);

    $batchidquery = "SELECT batch_id FROM batch ORDER BY batch_id DESC LIMIT 1";
    $batchidrun = mysqli_query($connection, $batchidquery);
    $batchid = mysqli_fetch_assoc($batchidrun);

    $meterquery = "UPDATE meter SET meter_status = 'SENT FOR WARRANTY', batch_id = $batchid[batch_id] WHERE serial_num = '$serialnum'";
    $meterresult = mysqli_query($connection, $meterquery);

    $movementquery = "INSERT INTO movement VALUES (DEFAULT, $location[location_id], 2, (CURRENT_DATE), NULL, $batchid[batch_id])";
    $warrantyquery = "INSERT INTO warranty VALUES (DEFAULT, '$serialnum', NULL, NULL)";

    $movementrun = mysqli_query($connection, $movementquery);
    $warrantyrun = mysqli_query($connection, $warrantyquery);
    
    if($batchresult && $meterresult && $movementquery){
        echo "<script>alert('Meter sent to lab successfully! You will be redirected to another window to print the new Batch QR for warranty claim.');</script>";
        echo "<script>window.open('regWarrantyBatchID.php?Batch_ID=$batchid[batch_id]')</script>";
        header("Refresh:250");
    } else {
        echo "<script>alert('Failed to send meter to lab!');</script>";
        header("Refresh:0");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regional Store Warranty Update</title>
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
<li class="breadcrumb-item"><a href="reg_home.php" title='Home Page - Region Store'>Home</a></li>
<li class="breadcrumb-item"><a href="reg_QRmenu.php" title='Scan QRcode Page'>Scan QRcode</a></li>
<li class="breadcrumb-item active" aria-current="page">Warranty Update</li>
</ol>
</nav>
<section id="warrentyupdate">
        <div class="container col-lg-12 text-center mb-4" id="qrscanner">
            <h2 class="text-center">Warranty Update</h2>
            <p class="text-center mb-4">Please scan the QR code on the meter to send it for lab testing.</p>
            <canvas hidden="" id="qr-canvas"></canvas>
            <button class= "btn btn-dark" id="btn-scan-qr" type="button">Click to Scan</button>
            <button class="btn btn-dark mt-4" id="btn-cancel-scan" type="button" hidden="">Click to Cancel Scanning</button>
        </div>
        <div id="meterForm" class="col-lg-12 mt-5 border border-warning shadow mb-4 rounded" style="display: none; width: 50%; margin:auto;">
            <h3 class="text-center">Please confirm that the Serial Number is correct.</h3>
            <form method="POST" name="serialNumForm" class="text-center">
                <label>Meter ID : </label>
                <input type="text" id="outputData" name="serialnum" placeholder="Serial Number" required readonly>
                <button type="submit" class="btn btn-success m-2 pt-1 pb-1 mt-4">Send to Lab</button>
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