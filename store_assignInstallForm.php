<?php
	//include('secure_Inv.php');
	include('connection.php');
	if(isset($_GET['Meter_ID'])){
		$serial_num = $_GET['Meter_ID'];
	
		//To check if the QR scanned is Meter QR
		$sqlMeterInfo = "SELECT * FROM meter WHERE serial_num = '$serial_num'";
		$result = mysqli_query($connection, $sqlMeterInfo);
		
		if(mysqli_num_rows($result)>0){
			
			//To get Meter in Batch
			$sql = "SELECT batch.*, meter.*, manufacturer.* FROM meter 
							INNER JOIN batch ON meter.batch_id = batch.batch_id 
							INNER JOIN manufacturer ON meter.manu_id = manufacturer.manu_id
							WHERE serial_num = '$serial_num'";
			$result = mysqli_query($connection, $sql);
			
			if ($result) {
				$row = mysqli_fetch_assoc($result);

				// Fetch data from the database
				$meter_type = $row["meter_type"];
				$meter_model = $row["meter_model"];
				$meter_size = $row["meter_size"];
				$age = $row["age"];
				$mileage = $row["mileage"];
				$manu_name = $row["manu_name"];
				echo "<script>alert('Meter assigned successfully!');</script>";
			}
		}else{
			echo "<script>alert('Invalid Meter QR. Please try again.');</script>";
			echo "<script>window.location.href='store_assignInstallForm.php';</script>";
			exit();
		}
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

	<!--Meter Info-->
	<h3>Meter Information</h3>
	<hr>
	<table class="table table-secondary">
		<tr class="table" colspan = "2">
			<td>
				<div id="qrcode">
					<script src = "qrcode.js"></script>
					<script src = "qrGeneratorMeter.js"></script>
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
			<th scope="row">Age</th>
			<td><?php echo $age; ?></td>
		</tr>
		</thread>
		<thread>
		<tr>
			<th scope="row">Mileage</th>
			<td><?php echo $mileage; ?></td>
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
