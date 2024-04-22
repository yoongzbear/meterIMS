<?php 
include 'secure_Con.php';
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
include 'navCon.php';
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
      <h3 style="font-size: 38px;">Air Selangor Inventory Department<large class="text-warning"> Features</large></h3>
    </div>
    <div class='d-flex align-items-center'>  
      <i class="bi bi-chevron-double-right" style="font-size: 40px;"></i>
    </div>
  </div>
</div>

<div class="container-fluid">
<!-- START THE FEATURETTES -->
  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading fw-normal lh-1">Register new meters received from manufacturers.</h2>
      <p class="lead">Generate new meter QR codes and assign meters into a new batch.</p>
      <p>Quick access to register new meters <a href="inventoryDep_AddBatchForm.php">here</a>.</p>
    </div>
      <div class="col-md-5">
        <img src="imgs/create-a-qr-code.png" width="700px" height="500px">
      </div>
  </div>

<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7 order-md-2">
      <h2 class="featurette-heading fw-normal lh-1">Ship out meter batches.</h2>
        <p class="lead">Scan the batch's QR code to record the batch movement to Test Lab or Region Stores.</p>
        <p>Quick access to ship out meters to Test Lab <a href="">here</a>.</p>
        <p>Quick access to ship out meters to Region Store <a href="">here</a>.</p>
    </div>
    <div class="col-md-5 order-md-1">
      <img src="imgs/scan-delivery-box.jpg" width="700px" height="500px">
    </div>
  </div>

<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading fw-normal lh-1">View water meter information.</h2>
        <p class="lead">Scan meter's QR code to view their information or view their past lab tests' results.</p>
        <p>Quick access to view meter's information <a href="InvDep_Scan_View_meter_info.php">here</a>.</p>
        <p>Quick access to view meter's lab test result <a href="invMeterResult.php">here</a>.</p>
    </div>
    <div class="col-md-5">
      <img src="imgs/scan-qr.jpg" width="500px" height="500px">
    </div>
  </div>

<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7 order-md-2">
      <h2 class="featurette-heading fw-normal lh-1">Make forecast on water meter demand.</h2>
        <p class="lead">Enter the water meter demand history and let the system generate a forecast for future meter demand.</p>
        <p>Quick access to meter forecast <a href="">here</a>.</p>
    </div>
    <div class="col-md-5 order-md-1">
      <img src="imgs/demand-forecast.png" width="700px" height="500px">
    </div>
  </div>

<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading fw-normal lh-1">View meter's current movement.</h2>
        <p class="lead">Track the movement of all meters in their batches. The details of the batch can also be viewed along with the list of meters in the batch.</p>
        <p>Quick access to view meter movement tracking <a href="mov_track_view.php">here</a>.</p>
    </div>
    <div class="col-md-5">
      <img src="imgs/movement-track.png" width="700px" height="500px">
    </div>
  </div>
<!-- /END THE FEATURETTES -->
</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>

</html>