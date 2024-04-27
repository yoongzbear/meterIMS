<?php include 'secure_Con.php'; ?>

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
        width:50%;
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
    <li class="breadcrumb-item active" aria-current="page">QR Code</li>
  </ol>
</nav>

<div class="container text-center mb-4 px-6">
    <h4>Scan Meter QR</h4>
    <div class="row mb-5">
      <div class="col">
      <a button type="button" class="btn btn-primary btn-lg" href="meterInstall.php">Meter Installation</a>
    </div>    
    </div>
    <div class='row'>
    <div class="col">
      <a button type="button" class="btn btn-primary btn-lg" href="conMeterUninstall.php">Meter Uninstallation</a>
    </div>
    </div>
</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>
</html>