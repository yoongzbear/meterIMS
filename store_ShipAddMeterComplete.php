<?php
include "secure_Reg.php";
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
  <li class="breadcrumb-item"><a href="reg_home.php" title='Home Page - Region Store'>Home</a></li>
	<li class="breadcrumb-item"><a href="reg_QRmenu.php" title='Scan QRcode Page'>Scan QRcode</a></li>
    <li class="breadcrumb-item"><a href="store_ShipOrderForm.php" title='Scan QRcode Page'>Ship Out - Ship Meter Batch</a></li>
	<li class="breadcrumb-item"><a href="store_ShipOrderScanMeter.php" title='Scan QRcode Page'>Scan QR Page - Meter Shipping Form</a></li>
	<li class="breadcrumb-item"><a href="store_ShipAddMeter.php" title='Scan QRcode Page'>Meter Shipping</a></li>
    <li class="breadcrumb-item active" aria-current="page">Meter Shipping Complete</li>

  </ol>
</nav>

<?php
	include('connection.php');
	$batch_id = $_GET['Batch_ID'];
	
	//To get Batch Info
	$sqlBatchInfo = "SELECT batch.*, meter.*, movement.* FROM batch
					INNER JOIN meter ON meter.batch_id = batch.batch_id
					INNER JOIN movement ON movement.batch_id = batch.batch_id
					WHERE batch_id = '$batch_id'";
	$result = mysqli_query($connection, $sqlBatchInfo);
	
	if ($result) {
		$row = mysqli_fetch_assoc($result);

		// Fetch data from the database
		$meter_type = $row["meter_type"];
		$meter_model = $row["meter_model"];
		$meter_size = $row["meter_size"];
		$quantity = $row["quantity"];
		$manu_id = $row["manu_id"];
		$tracking_id = $row["tracking_id"];
		$origin = $row["origin"];
		$destination = $row["destination"];
		$ship_date = $row["ship_date"];
	}
	
	//Select origin location name
	$sqlOriginName = "SELECT location_name FROM location WHERE location_id = '$origin'";
	$resultOrigin = mysqli_query($connection, $sqlOriginName);
	
	if ($resultOrigin) {
		$row = mysqli_fetch_assoc($resultOrigin);

		//Fetch data from the database
		$origin_name = $row["location_name"];
	}
	
	//Select destination location name
	$sqlDestinationName = "SELECT location_name FROM location WHERE location_id = '$destination'";
	$resultDestination = mysqli_query($connection, $sqlDestinationName);
	
	if ($resultDestination) {
		$row = mysqli_fetch_assoc($resultDestination);

		//Fetch data from the database
		$destination_name = $row["location_name"];
	}
?>

<div class="container mb-4">

<!--Show Current Batch Info-->
	<h3>Batch Meter Information</h3>
	<table class="table mb-4">
		<tr colspan = "2">
			<td>
				<div id="qrcode">
					<script src = "qrcode.js"></script>
					<script src = "qrGeneratorBatch.js"></script>
					<script>makeCode(); </script>
				</div>
			</td>
		</tr>
		<tr>
			<th>Meter Type</th>
			<td><?php echo $meter_type; ?></td>
		</tr>
		<tr>
			<th>Meter Model</th>
			<td><?php echo $meter_model; ?></td>
		</tr>
		<tr>
			<th>Meter Size</th>
			<td><?php echo $meter_size; ?></td>
		</tr>
		<tr>
			<!--Show Current Total Meter for Current Batch-->
			<th>Meter Quantity</th>
			<td><?php echo $quantity; ?></td>
		</tr>
	</table>
	<hr>

	<!--Show Shipping Info-->
	<h3>Shipping Information</h3>
	<table class="table mb-4">
		<tr>
			<th>Tracking ID</th>
			<td><?php echo $tracking_id; ?></td>
		</tr>
		<tr>
			<th>Origin</th>
			<td><?php echo $origin_name; ?></td>
		</tr>
		<tr>
			<th>Destination</th>
			<td><?php echo $destination_name; ?></td>
		</tr>
		<tr>
			<th>Ship Date</th>
			<td><?php echo $ship_date; ?></td>
		</tr>
	</table>
	<hr>

	<!--Show Meter List for the Batch-->
	<h3>List of Meters in the batch</h3>
	<table class="table mb-4">
		<tr>
			<th>No.</th>
			<th>Meter ID</th>
		</tr>
		
		<?php
			$num = 1;
			//Reset data seek pointer to the beginning
			mysqli_data_seek($result, 0);
			while($rowMeter = mysqli_fetch_assoc($result)){
				echo 
					'<tr>
						<th>'.$num.'</th>
						<td>'.$rowMeter["serial_num"].'</td>
					</tr>';
				$num++;
			}
		?>
	</table>
</div>

<div class="mb-4 d-grid gap-2 col-6 mx-auto">
	<button class="back btn btn-dark" type="button" onclick="window.location.href='store_ShipOrderForm.php'" title='Back To Ship Meter Batch Page'>Complete</button>
</div>
	

</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>