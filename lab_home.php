<?php 
include 'secure_TestLab.php';
include 'connection.php';
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTTO Aqua</title>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
    <li class="breadcrumb-item active" aria-current="page">Home</li>
    <li class="breadcrumb-item active" aria-current="page"></li>
  </ol>
</nav>

<div class="container text-center mb-4">
  <h2 class="display-2">Welcome <?php echo $name ;?>!</h2>
</div>

<div class="container-fluid mb-2">
  <div class="d-flex align-items-center ">
    <div class='d-flex align-items-center'>
      <i class="bi bi-chevron-double-left" style="font-size: 40px;margin-left:20px;"></i>
    </div>
    <div class='d-flex align-items-center'>  
      <h3 style="font-size: 38px;">Air Selangor Test Lab<large class="text-warning"> Features</large></h3>
    </div>
    <div class='d-flex align-items-center'>  
      <i class="bi bi-chevron-double-right" style="font-size: 40px;"></i>
    </div>
  </div>
</div>

<div class="container-fluid">
<!--START THE FEATURETTES-->
  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading fw-normal lh-1">Register meters received for testing</h2>
      <p class="lead">Scan the batch's QR code received from Inventory Department or Region Store to register the meters for testing.</p>
      <p>Quick access to receive meters for testing <a href="receiveBatchTest.php">here</a>.</p>
    </div>
      <div class="col-md-5">
        <img src="imgs/create-a-qr-code.png" width="100%" height="100%">
      </div>
  </div>

<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7 order-md-2">
      <h2 class="featurette-heading fw-normal lh-1">Ship out meter batches</h2>
        <p class="lead">Scan the batch's QR code to record the batch movement to Inventory Department with passed meters only.</p>
        <p>Quick access to ship out meters to Inventory Department <a href="">here</a>.</p>
    </div>
    <div class="col-md-5 order-md-1">
      <img src="imgs/scan-delivery-box.jpg" width="100%" height="100%">
    </div>
  </div>

<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading fw-normal lh-1">Insert meter's test result</h2>
        <p class="lead">Scan meter's QR code to enter its lab test result.</p>
        <p>Quick access to meter's test result form <a href="">here</a>.</p>
    </div>
    <div class="col-md-5">
      <img src="imgs/testing-meters.jpg" width="100%" height="100%">
    </div>
  </div>

<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7 order-md-2">
      <h2 class="featurette-heading fw-normal lh-1">View meter's past test lab results</h2>
        <p class="lead">Scan meter's QR code to view the details of meter's test lab results.</p>
        <p>Quick access to meter's test results <a href="">here</a>.</p>
    </div>
    <div class="col-md-5 order-md-1">
      <img src="imgs/scan-qr.jpg" width="100%" height="100%">
    </div>
  </div>
<!--END THE FEATURETTES-->
</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>
</html>