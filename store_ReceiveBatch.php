<?php include ('secure_Reg.php'); ?>

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
<?php include 'header.php'; ?>
</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="reg_home.php" title='Home Page - Region Store'>Home</a></li>
		<li class="breadcrumb-item"><a href="reg_QRmenu.php" title='Scan QRcode Page - Region Store'>Scan QRcode</a></li>
		<li class="breadcrumb-item"><a href="store_ReceiveOrderScanBatchQR.php" title='Scan QRcode Page - Region Store'>Scan QR (Store Arrival) - Meter Receiving Form</a></li>
		<li class="breadcrumb-item active" aria-current="page">Meter Receiving Form</li>
	</ol>
</nav>

<?php
	include('connection.php');
	$location_id = $_SESSION['locationID'];
	
	if(isset($_GET['Batch_ID'])){
		$batch_id = $_GET['Batch_ID'];
		
		//To check if the QR scanned is Batch QR
		$sqlBatchInfo = "SELECT * FROM batch WHERE batch_id = '$batch_id'";
		$result = mysqli_query($connection, $sqlBatchInfo);
		
		if(mysqli_num_rows($result)>0){
			//Check if the batch is exists
			$sqlBatchExist = "SELECT batch.*, movement.* FROM batch 
   					JOIN movement ON batch.batch_id = movement.batch_id 
					WHERE batch.batch_id = '$batch_id' AND movement.arrival_date IS NULL AND movement.inbound_id = '$location_id'";
			$resultBatchExist = mysqli_query($connection, $sqlBatchExist);
			if(mysqli_num_rows($resultBatchExist)>0){
				$current_date = date('Y-m-d');

				//Update Meter Location
				$sqlMeterLocation = "UPDATE meter SET location_id = '$location_id', meter_status = 'IN STORE' WHERE batch_id = '$batch_id'";
				$resultMovement = mysqli_query($connection, $sqlMeterLocation);
				
				//Update Tracking Info
				$sqlTrack = "UPDATE movement SET arrival_date = '$current_date' WHERE batch_id = '$batch_id'";
				$resultTrack = mysqli_query($connection, $sqlTrack);
				
				//To get info for batch, meter and Tracking
				$sqlInfo = "SELECT batch.*, meter.*, movement.* FROM batch
					INNER JOIN meter ON batch.batch_id = meter.batch_id 
					INNER JOIN movement ON batch.batch_id = movement.batch_id 
					WHERE batch.batch_id = '$batch_id'";
				$resultInfo = mysqli_query($connection, $sqlInfo);			
				
				//To get Batch Info
				if ($resultInfo) {
					$row = mysqli_fetch_assoc($resultInfo);

					// Fetch data from the database
					$meter_type = $row["meter_type"];
					$meter_model = $row["meter_model"];
					$meter_size = $row["meter_size"];
					$quantity = $row["quantity"];
					$tracking_id = $row["tracking_id"];
					$outbound_id = $row["outbound_id"];
					$inbound_id = $row["inbound_id"];
					$ship_date = $row["ship_date"];
				}
				
				//Select origin location name
				$sqlOriginName = "SELECT location.location_name FROM location 
						INNER JOIN outbound ON location.location_id = outbound.location_id 
						WHERE outbound.outbound_id = '$outbound_id'";
				$resultOrigin = mysqli_query($connection, $sqlOriginName);
				
				if ($resultOrigin) {
					$row = mysqli_fetch_assoc($resultOrigin);

					//Fetch data from the database
					$origin_name = $row["location_name"];
				}
				
				//Select destination location name
				$sqlDestinationName = "SELECT location.location_name FROM location 
							INNER JOIN inbound ON location.location_id = inbound.location_id 
							WHERE inbound.inbound_id = '$inbound_id'";
				$resultDestination = mysqli_query($connection, $sqlDestinationName);
				
				if ($resultDestination) {
					$row = mysqli_fetch_assoc($resultDestination);

					//Fetch data from the database
					$destination_name = $row["location_name"];
				}
				echo "<script>alert('Meter Batch Receive Successfully.');</script>";
			}else{
				echo "<script>alert('Batch is received or does associated to this store. Please try again.');</script>";
				echo "<script>window.location.href='store_ReceiveOrderScanBatchQR.php';</script>";
			}
		}else{
			echo "<script>alert('Invalid Batch QR. Please try again.');</script>";
			echo "<script>window.location.href='store_ReceiveOrderScanBatchQR.php';</script>";
			exit();
		}
	}
?>

<div class='container col-xl-5'>
	<!--Show Current Batch Info-->
	<h2 class='fs-1 text-uppercase'>Batch Meter Information</h2>
	<hr class='border border-success border-2 opacity-50'>
	
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
	
	<hr>
	
	<!--Show Shipping Info-->
	<h3>Shipping Information</h3>
	<table class="table mb-4">
		<tr>
			<th>Tracking ID:</th>
			<td><?php echo $tracking_id; ?></td>
		</tr>
		<tr>
			<th>Origin:</th>
			<td><?php echo $origin_name; ?></td>
		</tr>
		<tr>
			<th>Destination:</th>
			<td><?php echo $destination_name; ?></td>
		</tr>
		<tr>
			<th>Ship Date:</th>
			<td><?php echo $ship_date; ?></td>
		</tr>
		<tr>
			<th>Arrival Date:</th>
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
			mysqli_data_seek($resultInfo, 0);
			while($rowMeter = mysqli_fetch_assoc($resultInfo)){
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

<div class="d-grid col-6 mx-auto mb-4">
	<button class="back btn btn-dark" type="button" onclick="window.location.href='store_ReceiveOrderScanBatchQR.php'" title='Back To Scan QR'>Back</button>
</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>
</html>
