<?php
	include('secure_Inv.php');
	include('connection.php');
	$batch_id = $_GET['Batch_ID'];

	//To get Batch Info
	$sqlBatchInfo = "SELECT batch.*, meter.*, movement.* FROM batch
					INNER JOIN meter ON meter.batch_id = batch.batch_id
					INNER JOIN movement ON movement.batch_id = batch.batch_id
					WHERE batch.batch_id = '$batch_id'";
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
	echo "<script>alert('Meter Batch Shipped Successfully!');</script>";
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

<div class="container">
    <div class="row mb-4 align-items-start">
	<div class='col'>

<!--Show Current Batch Info-->
	<h3>Batch Meter Information</h3>
	<hr>
	<table class="table">
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
			<th>Meter Type:</th>
			<td><?php echo $meter_type; ?></td>
		</tr>
		<tr>
			<th>Meter Model:</th>
			<td><?php echo $meter_model; ?></td>
		</tr>
		<tr>
			<th>Meter Size:</th>
			<td><?php echo $meter_size; ?></td>
		</tr>
		<tr>
			<!--Show Current Total Meter for Current Batch-->
			<th>Meter Quantity:</th>
			<td><?php echo $quantity; ?></td>
		</tr>
	</table>
	</div>
	</div>

	<div class='row mb-4 align-items-start'>
	<div class='col'>
	<!--Show Shipping Info-->
	<h3>Shipping Information</h3>
	<hr>
	<table class="table">
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
	</div>
	</div>


	<div class='row mb-4 align-items-start'>
	<div class='col'>
	<!--Show Meter List for the Batch-->
	<h3>List of Meters in the batch</h3>
	<table>
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
	</div>

</div>

<div class="d-grid gap-2 col-6 mx-auto mb-4">
	<button class="back btn btn-dark" type="button" onclick="window.location.href='inventoryDep_ShipOrderForm.php'" title='Back To Create New Batch Page'>Complete</button>
</div>
	
</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>