<?php
	include('secure.php');
	include('connection.php');
	$batch_id = $_GET['Batch_ID'];
	
	//To get Batch Info
	$sqlBatchInfo = "SELECT * FROM batch WHERE batch_id = '$batch_id'";
	$result = mysqli_query($connection, $sqlBatchInfo);
	
	if ($result) {
		$row = mysqli_fetch_assoc($result);

		// Fetch data from the database
		$meter_type = $row["meter_type"];
		$meter_model = $row["meter_model"];
		$meter_size = $row["meter_size"];
		$quantity = $row["quantity"];
	}
	
	//To get Meter in Batch
	$sqlMeterList = "SELECT * FROM meter WHERE batch_id = '$batch_id'";
	$resultMeter = mysqli_query($connection, $sqlMeterList);
	
	if ($resultMeter) {
		$rowMeter = mysqli_fetch_assoc($resultMeter);

		// Fetch data from the database
		$manu_id = $rowMeter["manu_id"];
	}
	
	// To show the manufacturer name
    $sqlShowManuName = "SELECT * FROM manufacturer WHERE manu_id = '$manu_id'";
    $resultSelectManu = mysqli_query($connection, $sqlShowManuName);
    if ($resultSelectManu) {
        $rowManu = mysqli_fetch_assoc($resultSelectManu);

        // Fetch data from the database
        $manu_name = $rowManu["manu_name"];
    }
?>

<html>
	<!--Show Current Batch Info-->
	<h3>Current Batch Information</h3>
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
		<tr>
			<td>Manufacturer</td>
			<td><?php echo $manu_name; ?></td>
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
			mysqli_data_seek($resultMeter, 0);
			while($rowMeter = mysqli_fetch_assoc($resultMeter)){
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