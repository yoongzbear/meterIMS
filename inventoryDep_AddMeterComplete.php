<?php
	include('secure_Inv.php');
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
?>

</header>


<div class="container">
      <div class="row align-items-start">
        <div class="col">

	<!--Show Current Batch Info-->
	<h3>Current Batch Information</h3>
	<hr>
	<table class="table table-secondary">
		<tr class="table" colspan = "2">
			<td>
				<div id="qrcode">
					<script src = "qrcode.js"></script>
					<script src = "qrGeneratorBatch.js"></script>
					<script>makeCode(); </script>
				</div>
			</td>
		</tr>

		<thread>
		<tr>
			<th scope="row">Meter Type</th>
			<td><?php echo $meter_type; ?></td>
		</tr>
		</thread>
		<thread>
		<tr>
			<th scope="row">Meter Model</th>
			<td><?php echo $meter_model; ?></td>
		</tr>
		</thread>
		<thread>
		<tr>
			<th scope="row">Meter Size</th>
			<td><?php echo $meter_size; ?></td>
		</tr>
		</thread>
		<thread>
		<tr>
			<!--Show Current Total Meter for Current Batch-->
			<th scope="row">Meter Quantity</th>
			<td><?php echo $quantity; ?></td>
		</tr>
		</thread>
		<thread>
		<tr>
			<th scope="row">Manufacturer</th>
			<td><?php echo $manu_name; ?></td>
		</tr>
		</thread>
	</table>
	</div>

	<div class='col'>
	<!--Show Meter List for the Batch-->
	<h3>List of Meters in the batch</h3>
	<hr>

	<table class="table table-secondary">
		<thread>
		<tr class="table-light">
			<th scope="col">No.</th>
			<th scope="col">Meter ID</th>
		</tr>
		</thread>
		
		<?php
			$num = 1;
			//Reset data seek pointer to the beginning
			mysqli_data_seek($resultMeter, 0);
			while($rowMeter = mysqli_fetch_assoc($resultMeter)){
				echo 
					'<thread><tr>
						<td>'.$num.'</td>
						<td>'.$rowMeter["serial_num"].'</td>
					</tr></thread>'
					;
				$num++;
			}
		?>
	</table>
	</div>
	</div>
</div>

<div class="d-grid gap-2 col-6 mx-auto">
	<button class="back btn btn-dark" type="button" onclick="window.location.href='inventoryDep_AddBatchForm.php'" title='Back To Create New Batch Page'>Back</button>
</div>
	
<br>

</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>