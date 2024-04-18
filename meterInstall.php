<?php 
include 'secure_Con.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Installation</title>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header>
<?php 
include 'header.php';
?>

</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="con_home.php" title='Home Page - Contractor'>Home</a></li>
    <li class="breadcrumb-item"><a href="con_QRmenu.php" title='Meter Installation Page'>Meter Installation</a></li>
    <li class="breadcrumb-item active" aria-current="page">Meter Installation</li>

  </ol>
</nav>

<div class="col align-self-center">

    <h3>Meter Installation Form</h3>
    <p class="fst-italic">Please scan the QR code on the water meter after installation.</p>
    <canvas id="qr-canvas" width="300" height="300" style="border:1px solid #000000;"></canvas> <br>
    <!--is there a way to set the size without it expanding-->
    <button type="button" id="btn-scan-qr" class="btn btn-light text-dark">Scan QR</button>
    <button type="button" id="btn-cancel-scan" class="btn btn-light text-dark">Cancel Scan</button>
    
    <form id="meterForm" action="meterInstallForm.php" method="post" style="display:none;">
        <label for="serial_num">Meter Serial Number:</label>
        <input type="text" id="outputData" name="serial_num" readonly>
        <p>is this the right serial number meter?</p>
        <input type="submit" value="Yes">
        <button id="btn-cancel">No</button>
    </form>

    <script>
        //redirect to the meter install page if cancelled after scanning
        document.getElementById("btn-cancel").addEventListener("click", function(event) {
            event.preventDefault();
            window.location.href = 'meterInstall.php';
        });
    </script>

    <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
    <script src="qrReader.js"></script>

</div>
</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>
