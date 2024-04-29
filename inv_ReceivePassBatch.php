<?php include ('secure_Inv.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Receiving</title>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<header>
<?php 
include 'header.php';
include 'navInv.php';
?>
</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="inv_mag_home.php" title='Home Page - Inventory Management Department'>Home</a></li>
    <li class="breadcrumb-item"><a href="inv_QRmenu.php" title='QRcode Page'>QRcode</a></li>
	<li class="breadcrumb-item"><a href="inv_ReceiveScanPassMeterQR.php" title='Scan QR Page'>Scan QR - Batch Receiving Form</a></li>
	<li class="breadcrumb-item active" aria-current="page">Batch Receiving Form</li>
  </ol>
</nav>

<?php
	include('connection.php');
	
	if(isset($_GET['Batch_ID'])){
		$batch_id = $_GET['Batch_ID'];
		
		//To check if the QR scanned is Batch QR
		$sqlBatchInfo = "SELECT batch.*, meter.*, movement.* FROM batch INNER JOIN meter ON batch.batch_id = meter.batch_id INNER JOIN movement ON batch.batch_id = movement.batch_id INNER JOIN lab_result ON meter.serial_num = lab_result.serial_num WHERE batch.batch_id = '$batch_id' AND lab_result.result != 'FAILED' AND movement.destination = 1";
		$result = mysqli_query($connection, $sqlBatchInfo);
		
		if(mysqli_num_rows($result)>0){
			//Check if the batch is already received
			$sqlBatchExist = "SELECT * FROM batch WHERE batch_id = '$batch_id' AND location_id != 1";
			$resultBatchExist = mysqli_query($connection, $sqlBatchExist);
			if(mysqli_num_rows($resultBatchExist)>0){
				$current_date = date('Y-m-d');
		
				//Update Batch Location
				$sqlBatchLocation = "UPDATE batch SET location_id = 1 WHERE batch_id = '$batch_id'";
				$resultMovement1 = mysqli_query($connection, $sqlBatchLocation);
				
				//Update Meter Location
				$sqlMeterLocation = "UPDATE meter 
									JOIN lab_result ON meter.serial_num = lab_result.serial_num
									SET meter.meter_status = 'IN STOCK' 
									WHERE meter.batch_id = '$batch_id' AND lab_result.result != 'FAILED'";
				$resultMovement2 = mysqli_query($connection, $sqlMeterLocation);
				
				//Update Tracking Info
				$sqlTrack = "UPDATE movement SET arrival_date = '$current_date' WHERE batch_id = '$batch_id'";
				$resultTrack = mysqli_query($connection, $sqlTrack);
				
				if ($result) {
					$row = mysqli_fetch_assoc($result);

					// Fetch data from the database
					$meter_type = $row["meter_type"];
					$meter_model = $row["meter_model"];
					$meter_size = $row["meter_size"];
					$quantity = $row["quantity"];
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
				echo "<script>alert('Meter Batch Received Successfully!');</script>";
			}else{
				echo "<script>alert('Batch is received. Please try again.');</script>";
				echo "<script>window.location.href='inv_ReceiveScanPassBatchQR.php';</script>";
			}
		}else{
			echo "<script>alert('Invalid Batch QR. Please try again.');</script>";
			echo "<script>window.location.href='inv_ReceiveScanPassBatchQR.php';</script>";
		}
	}
?>

	<!--Show Current Batch Info-->
	<div class="col align-self-center">

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
			<td>Air Selangor Lab</td>
		</tr>
		<tr>
			<th>Destination</th>
			<td>Air Selangor Inventory Department</td>
		</tr>
		<tr>
			<th>Ship Date</th>
			<td><?php echo $ship_date; ?></td>
		</tr>
		<tr>
			<th>Arrival Date</th>
			<td><?php echo $current_date; ?></td>
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

<div class="d-grid gap-2 col-6 mx-auto mb-4">
<button class="back btn btn-dark" type="button" onclick="window.location.href='inv_ReceiveScanPassBatchQR.php'" title='Back To Scan QR'>Back</button>
</div>

</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>
</html>