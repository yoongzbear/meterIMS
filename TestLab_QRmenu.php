<?php include 'secure_TestLab.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTTO Aqua</title>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      .btn.btn-primary.btn-lg{
        height:100%;
      }
    </style>
</head>

<body>
<header>
<?php 
include 'header.php';
include 'navLab.php';
?>
</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="lab_home.php" title='Home Page - Test Lab'>Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">QR Code</li>
  </ol>
</nav>

<div class="container-sm text-center mb-4 px-5">
  <div class="row mb-5">
    <h4>Scan Batch QR</h4>
    <div class="col-6">
      <a button type="button" class="btn btn-primary btn-lg d-block" href="receiveBatchTest.php">Receive for Testing</a>
      </div>
      <div class="col-6">
      <a button type="button" class="btn btn-primary btn-lg d-block" href="LabDep_Scan_to_Inv.php">Send to Inventory Department</a>
    </div>    
  </div>

  <div class="row">
    <h4>Scan Meter QR</h4>
    <div class='col-6'>
      <a button type="button" class="btn btn-primary btn-lg d-block" href="meterTest.php">Meter Test Result Form</a>
      </div>
      <div class="col-6">
      <a button type="button" class="btn btn-primary btn-lg d-block" href="labMeterResult.php">Meter Test Result</a>
    </div>
  </div>
</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>
</html>