<?php
include 'secure_Con.php';
include 'connection.php';
if(ISSET($_POST['serialnum'])){
    $serialnum = $_POST['serialnum'];
    try{
        $statuscheckquery = "SELECT meter_status FROM meter WHERE serial_num = '$serialnum'";
        $statuscheckrun = mysqli_query($connection, $statuscheckquery);
        $statuscheckrow = mysqli_fetch_assoc($statuscheckrun);
        if(mysqli_num_rows($statuscheckrun) == 0){
            throw new Exception();
        }
        if($statuscheckrow['meter_status'] == 'UNINSTALLED'){
            echo "<script>alert('Error: Meter is already uninstalled!');</script>";
            header("Refresh:0");
            exit();
        }
        $meterinfoquery = "UPDATE meter SET meter_status = 'UNINSTALLED' WHERE serial_num = '$serialnum'";
        $meterinforun = mysqli_query($connection, $meterinfoquery);
        if($meterinforun){
            echo "<script>alert('Meter uninstalled successfully!');</script>";
            header("Refresh:0");
        } else {
            echo "<script>alert('Failed to uninstall meter!');</script>";
            header("Refresh:0");
        }
}
    catch(Exception $e){
        echo "<script>alert('Error: Invalid Serial Number. Please try again.');</script>";
        header("Refresh:0");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Uninstallation</title>
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
            include 'navCon.php';
        ?>
    </header>
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="con_home.php" title='Home Page - Contractor'>Home</a></li>
        <li class="breadcrumb-item"><a href="con_QRmenu.php" title='Meter Installation Page'>Meter Installation</a></li>
        <li class="breadcrumb-item active" aria-current="page">Scan QR - Meter Uninstallation</li>
    </ol>
    </nav>
    <section id="meteruninstall">
        <div class="container col-lg-12 text-center mb-4" id="qrscanner">
            <h2 class="text-center">Meter Uninstallation</h2>
            <p class="text-center mb-4">Please scan the QR code on the meter to mark it as uninstalled.</p>
            <canvas hidden="" id="qr-canvas"></canvas>
            <button class= "btn btn-dark" id="btn-scan-qr" type="button">Click here to scan</button>
            <button class="btn btn-dark mt-4" id="btn-cancel-scan" type="button" hidden="">Click here to cancel scanning</button>
        </div>

        <div id="meterForm" class="col-lg-12 mt-5 border border-warning shadow mb-4 rounded" style="display: none; width: 50%; margin:auto;">
            <h3 class="text-center">Please confirm that the Serial Number is correct.</h3>
            <form method="POST" name="serialNumForm" class="text-center">
                <label>Meter ID : </label>
                <input type="text" id="outputData" name="serialnum" placeholder="Serial Number" required readonly><br>
                <button type="submit" class="btn btn-success m-2 pt-1 pb-1 mt-4">Mark as uninstalled</button>
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