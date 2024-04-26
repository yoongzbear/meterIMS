<?php 
include ('secure_Inv.php'); 
$meterQuantity = $_GET['meterQuantity'];
$batch_id = $_GET['Batch_ID'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Shipping</title>
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
    <li class="breadcrumb-item active" aria-current="page">Home</li>
    <li class="breadcrumb-item active" aria-current="page">QR Code</li>
	<li class="breadcrumb-item active" aria-current="page">Ship Out Form</li>
	<li class="breadcrumb-item active" aria-current="page">Scan QR - Meter Shipping Form</li>

  </ol>
</nav>

<div class="my-4 text-center">

    <h3>Meter Shipping Form</h3>
    <p class="fst-italic">Please scan the QR code on the water meter</p>
    <canvas id="qr-canvas" width="300" height="300" style="border:1px solid #000000;"></canvas><br>
    <button type="button" id="btn-scan-qr" class="btn btn-light text-dark">Scan QR</button>
    <button type="button" id="btn-cancel-scan" class="btn btn-light text-dark" hidden="">Cancel Scan</button>

    <div class="col mt-4 text-center">
    <div class="modal-dialog" role="document">
    <div class="modal-content rounded-3 shadow" id="meterForm" action="inv_ShipMeterCheckQR.php" method="get" style="display:none;">
        <form id="meterForm" action="inv_ShipMeterCheckQR.php" method="get">
                <div class="modal-body p-4 text-center">
                    <h5 class="modal-title mb-0" id="meterFormLabel">Is this the right Serial Number Meter?</h5>
                    <p class="mb-0">Meter Serial Number : </p>
                    <input type="text" id="outputData" name="Meter_ID" readonly>
                    <!--Send shipping info-->
                    <input type="hidden" name="meterQuantity" value="<?php echo $meterQuantity;?>" readonly>
                    <input type="hidden" name="batch_id" value="<?php echo $batch_id;?>" readonly>

                </div>
                <div class="modal-footer flex-nowrap p-0">
                    <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end"><strong>Yes</strong></button>
                    <button type="button" id="btn-cancel" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal">No</button>
                </div>
            </form>
    </div>
    </div>
    </div>
</div>

    <script>

        //redirect to the meter install page if cancelled after scanning
        document.getElementById("btn-cancel").addEventListener("click", function(event) {
            event.preventDefault();
            window.location.href = 'inventoryDep_ShipOrderScanMeterQR.php?Batch_ID=<?php echo $batch_id; ?>&meterQuantity=<?php echo $meterQuantity; ?>';
        });
    </script>

    <script src="qrPacked.js"></script>
    <script src="qrReader.js"></script>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>

</html>
