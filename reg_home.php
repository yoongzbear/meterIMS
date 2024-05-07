<?php 
include 'secure_Reg.php';
include 'connection.php';
$name = $_SESSION['name'];
$username = $_SESSION['username'];

//sql to get region store of the user
$sql = "SELECT location_name FROM location INNER JOIN useraccount ON useraccount.location_id = location.location_id WHERE username = '$username'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
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
include 'navReg.php';
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
  <h3 class="display-6">Region Store: <?php echo $row['location_name'];?></h3>
</div>

<div class="container-fluid mb-2">
  <div class="d-flex align-items-center ">
    <div class='d-flex align-items-center'>
      <i class="bi bi-chevron-double-left" style="font-size: 40px;margin-left:20px;"></i>
    </div>
    <div class='d-flex align-items-center'>  
      <h3 style="font-size: 38px;">Air Selangor Region Store<large class="text-warning"> Features</large></h3>
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
      <h2 class="featurette-heading fw-normal lh-1">Receive meter batch after arrival</h2>
      <p class="lead">Scan the batch's QR code received to record the meters at <?php echo $row['location_name'];?> Region Store.</p>
      <p>Quick access to <a href="store_ReceiveOrderScanBatchQR.php">receive meters</a>.</p>
    </div>
      <div class="col-md-5">
        <img src="imgs/scan-delivery-box.jpg" width="100%" height="100%">
      </div>
  </div>

<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7 order-md-2">
      <h2 class="featurette-heading fw-normal lh-1">Record meter's departure from region store</h2>
        <p class="lead">Scan the meter's QR code to record the meter departure for installation at premises and for warranty testing.</p>
        <p>Quick access to <a href="store_assignInstallForm.php">send out meter for installation</a>.</p>
        <p>Quick access to <a href="regWarrantyUpdate.php">send out meter for warranty testing</a>.</p>
    </div>
    <div class="col-md-5 order-md-1">
      <img src="imgs/scan-qr2.jpg" width="100%" height="100%">
    </div>
  </div>

<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading fw-normal lh-1">Ship meters out</h2>
        <p class="lead">Insert meters' shipping information to other Region Stores or Inventory Department.</p>
        <p>Quick access to <a href="store_ShipOrderForm.php">ship out meter form</a>.</p>
    </div>
    <div class="col-md-5">
      <img src="imgs/ship-box.jpg" width="100%" height="100%">
    </div>
  </div>

<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7 order-md-2">
      <h2 class="featurette-heading fw-normal lh-1">View meter inventory level</h2>
        <p class="lead">Check the meter inventory level at <?php echo $row['location_name'];?> Region Store. Meter models that needs to be ordered urgently are flagged.</p>
        <p>Quick access to <a href="regInvLevel.php">meter inventory level list</a>.</p>
    </div>
    <div class="col-md-5 order-md-1">
      <img src="imgs/demand-forecast.png" width="100%" height="100%">
    </div>
  </div>

<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading fw-normal lh-1">View meter warranty list</h2>
        <p class="lead">View the required meter replacement for old meters with claimable warranty. Scan the new meter's QR code for replacement.</p>
        <p>Quick access to <a href="warranty_list.php">meter warranty list</a>.</p>
    </div>
    <div class="col-md-5">
      <img src="imgs/water-meter.jpg" width="100%" height="100%">
    </div>
  </div>

<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7 order-md-2">
      <h2 class="featurette-heading fw-normal lh-1">View water meter information</h2>
        <p class="lead">Scan meter's QR code to view their information.</p>
        <p>Quick access to <a href="RegDep_Scan_View_meter_info.php">view meter's information</a>.</p>
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