<?php
	include('secure.php');
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

<html>
	<head><title>Meter Shipping</title></head>
	<!--Show Current Batch Info-->
	<h3>Batch Meter Information</h3>
	<table>
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
			<td>Meter Type</td>
			<td><?php echo $meter_type; ?></td>
		</tr>
		<tr>
			<td>Meter Model</td>
			<td><?php echo $meter_model; ?></td>
		</tr>
		<tr>
			<td>Meter Size</td>
			<td><?php echo $meter_size; ?></td>
		</tr>
		<tr>
			<!--Show Current Total Meter for Current Batch-->
			<td>Meter Quantity</td>
			<td><?php echo $quantity; ?></td>
		</tr>
	</table>

	<!--Show Shipping Info-->
	<h3>Shipping Information</h3>
	<table>
		<tr>
			<td>Tracking ID</td>
			<td><?php echo $tracking_id; ?></td>
		</tr>
		<tr>
			<td>Origin</td>
			<td><?php echo $origin_name; ?></td>
		</tr>
		<tr>
			<td>Destination</td>
			<td><?php echo $destination_name; ?></td>
		</tr>
		<tr>
			<td>Ship Date</td>
			<td><?php echo $ship_date; ?></td>
		</tr>
	</table>

	<!--Show Meter List for the Batch-->
	<h3>List of Meters in the batch</h3>
	<table>
		<tr>
			<td>No.</td>
			<td>Meter ID</td>
		</tr>

		<?php
			$num = 1;
			//Reset data seek pointer to the beginning
			mysqli_data_seek($result, 0);
			while($rowMeter = mysqli_fetch_assoc($result)){
				echo 
					'<tr>
						<td>'.$num.'</td>
						<td>'.$rowMeter["serial_num"].'</td>
					</tr>';
				$num++;
			}
		?>
	</table>
	<button class="back" onclick="window.location.href='index.php'">Back</button>
</html>
