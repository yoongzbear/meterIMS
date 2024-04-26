<?php 
include 'secure_Inv.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTTO Aqua</title>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <li class="breadcrumb-item active" aria-current="page">QRcode</li>
  </ol>
</nav>

<div class="container-sm text-center mb-4 px-5">
  <div class="row mb-5">
    <h4>Generate QR</h4>
    <div class="col-6">
      <a button type="button" class="btn btn-primary btn-lg d-block" href="inventoryDep_AddBatchForm.php">Receive Meter</a>
      </div>
    <div class="col-6">
      <a button type="button" class="btn btn-primary btn-lg d-block" href="inv_ReceiveScanPassBatchQR.php">Receive Passed Batch</a>
    </div>    
  </div>

  <div class="row mb-5">
    <h4>Scan Batch QR</h4>
    <div class='col-6'>
      <a button type="button" class="btn btn-primary btn-lg d-block" href="invInitialTest.php">Initial Ship Out To Lab</a>
      </div>    
      <div class="col-6">
      <a button type="button" class="btn btn-primary btn-lg d-block" href="inventoryDep_ShipOrderForm.php">Ship Out</a>
    </div>
  </div>

  <div class="row">
    <h4>Scan Meter QR</h4>
    <div class="col-6">
      <a button type="button" class="btn btn-primary btn-lg d-block" href="InvDep_Scan_View_meter_info.php">View Meter Info</a>
      </div>    
      <div class="col-6">
      <a button type="button" class="btn btn-primary btn-lg d-block" href="invMeterResult.php">View Meter Result</a>
    </div>    
  </div>
</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>

</html>
