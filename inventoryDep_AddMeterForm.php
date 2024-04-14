<?php
	include('secure.php');
	include('connection.php');
	$manu_id = $_GET['manu_id'];
	$batch_id = $_GET['Batch_ID'];
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
?>

<script>
function setNumberDecimal(event) {
    this.value = parseFloat(this.value).toFixed(2);
}
</script>

<html>
	<div class = "content">
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
				<td>Current Meter Quantity</td>
				<td><?php echo $quantity; ?></td>
			</tr>
		</table>
			
		<h3>Add Meter Information</h3>
		<form action="inventoryDep_AddMeter.php" method="get">
			<table>
				<input type="hidden" name="batch_id" value="<?php echo $batch_id;?>">
				<input type="hidden" name="manu_id" value="<?php echo $manu_id;?>">
				<tr>
					<td>Meter Serial Number</td>
					<td><input type="text" name="Meter_ID" placeholder="AIS17BA00XXXXX" required></td>
				</tr>
				
				<tr>
					<td>Age</td>
					<td><input type="number" onchange="setNumberDecimal" name="age" step="0.1" min="0" placeholder="0.0" required></td>
				</tr>
				
				<tr>
					<td>Mileage</td>
					<td><input type="number" name="mileage" min="1" required></td>
				</tr>
				
				<tr>
					<td>Manufactured Year</td>
					<td><input type="number" name="manufactured_year" maxlength="4" pattern="\d{4}" required></td> 
				</tr>
			</table>
			<div class="buttons">
				<button type="submit">Add Meter</button>
				<button onclick="window.location.href='inventoryDep_AddMeterComplete.php?Batch_ID=<?php echo $batch_id; ?>';">Cancel</button>
			</div>
		</form>
	</div>
</html>
