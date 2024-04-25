<?php 
include 'secure_Reg.php';
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
include 'navReg.php';
?>

</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="reg_home.php" title='Home Page - Region Store'>Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Scan QRcode</li>

  </ol>
</nav>

<div class="container text-center">
<h4>Scan Batch QR</h4>
  <div class="row mb-4">
    <div class="col">
      <a button type="button" class="btn btn-primary btn-lg" href=".php">Store Arrival</a>
    </div>
    </div>
    <div class="row mb-4">
    <div class="col">
      <a button type="button" class="btn btn-primary btn-lg" href=".php">Ship Out</a>
    </div>
    </div>

  <h4>Scan Meter QR</h4>
  <div class="row mb-4">
    <div class="col">
      <a button type="button" class="btn btn-primary btn-lg mb-3" href=".php">Installation Departure</a>
    </div>
  </div>  
  <div class="row mb-4">
    <div class="col">
      <a button type="button" class="btn btn-primary btn-lg" href="RegDep_Scan_View_meter_info.php">View Meter Info</a>
    </div>
    </div>
    <div class="row mb-4">
    <div class="col">
      <a button type="button" class="btn btn-primary btn-lg" href="regWarrantyUpdate.php">Warranty Testing</a>
    </div>
    </div>    
  </div>

</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>

</html>