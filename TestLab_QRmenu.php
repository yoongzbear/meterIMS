<?php 
include 'secure_TestLab.php';
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
include 'navLab.php';
?>

</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="inv_mag_home.php" title='Home Page - Test Lab'>Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Meter Test</li>
  </ol>
</nav>

<p>Scan Batch QR</p>
<button onclick="window.location.href= 'receiveBatchTest.php';">Receive Batch for Warranty Test</button>

<p>Scan Meter QR</p>
<button onclick="window.location.href= 'meterTest.php';">Meter Test Result Form</button>
<button onclick="window.location.href= 'labMeterResult.php';">Meter Test Results</button>
</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>