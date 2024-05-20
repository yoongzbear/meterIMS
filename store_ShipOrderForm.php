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
include 'navReg.php';
?>
</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
	<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="reg_home.php" title='Home Page - Region Store'>Home</a></li>
	<li class="breadcrumb-item"><a href="reg_QRmenu.php" title='Scan QRcode Page'>Scan QRcode</a></li>
	<li class="breadcrumb-item active" aria-current="page">Ship Out - Ship Meter Batch</li>
	</ol>
</nav>

<?php
	include ('connection.php');
	$location_id = $_SESSION['locationID'];
	
	//Get location name from locationID
	$sqlLocation = "SELECT * FROM location WHERE location_id = '$location_id'";
	$resultLocation = mysqli_query($connection, $sqlLocation);
	if ($resultLocation){
		$rowLocation = mysqli_fetch_assoc($resultLocation);
		$storeName = $rowLocation['location_name'];
	}
	$current_date = date('Y-m-d');
?>

<script>
	function validateForm() {
		//Get the value of meter details field
		var meterDetails = document.forms["shipOrderForm"]["meter_details"].value;
		
		//Split the selected value into separate variables
		var meterDetailsArray = meterDetails.split("|");
		var meterType = meterDetailsArray[0];
		var meterModel = meterDetailsArray[1];
		var meterSize = meterDetailsArray[2];
		
		//Get the values of shipping details fields
		var meterQuantity = document.forms["shipOrderForm"]["meterQuantity"].value;
		var inbound_id = document.forms["shipOrderForm"]["inbound_id"].value;
		var shipDate = document.forms["shipOrderForm"]["ship_date"].value;
		
		//Check if all required fields are filled
		if (meterDetails == "" || meterQuantity == "" || inbound_id == "" || shipDate == "") {
			alert("Please fill in all fields.");
			return false; 
		}
			return true; 
		}
		
		function submitForm() {
			if (validateForm()) {
				var confirmProceed = confirm("Please make sure the information is correct before proceeding. You will not be able to modify the information after this.");
			if (confirmProceed) {
				document.shipOrderForm.submit(); //Submit the form if confirmed
			}
		}
	}
</script>

<div class='container col-xl-6 mb-4'>
	<h3 class="header">Ship Meter Batch</h3>
	<hr>
	<form class="form" action="store_ShipAddBatch.php" method="post" name="shipOrderForm">
		<div class="row g-3 align-items-center mb-4">
			<div class="col-4">
				<label>Meter Details:</label>
			</div>
			<div class="col-8">
				<!--Display combined meter details as option-->
				<select name="meter_details" class="form-select" required>
					<option value="" disabled selected>Please Select Meter Type, Model and Size</option>
					<?php
						$sqlMeter = "SELECT DISTINCT meter_type, meter_model, meter_size FROM batch WHERE location_id = $location_id";
						$resultMeter = mysqli_query($connection, $sqlMeter);
						while ($rowMeter = mysqli_fetch_assoc($resultMeter)) {
							$meterType = $rowMeter['meter_type'];
							$meterModel = $rowMeter['meter_model'];
							$meterSize = $rowMeter['meter_size'];
							echo "<option value='$meterType|$meterModel|$meterSize'>$meterType, $meterModel, $meterSize</option>";
						}
					?>
				</select>
			</div>
		</div>
			
		<!--Shipping details-->
		<input class="form-control" type="hidden" name="outbound_id" value="<?php echo $location_id; ?>" readonly>
		<div class="row g-3 align-items-center mb-4">
			<div class="col-4">
				<label>Number of Meters Needed:</label>
			</div>
			<div class="col-8">
				<input class="form-control" type="number" name="meterQuantity" required>
			</div>
		</div>
		
		<div class="row g-3 align-items-center mb-4">
			<div class="col-4">
				<label>Origin:</label>
			</div>
			<div class="col-8">
				<?php echo $storeName ;?>
			</div>
		</div>
		
		<div class="row g-3 align-items-center mb-4">
			<div class="col-4">
				<label>Destination:</label>
			</div>
			<div class="col-8">
				<select class="form-select" name="inbound_id" required>
					<option value="" disabled selected>Please Select Destination Region Store</option>
					<?php
						$sqlStore="SELECT * FROM location WHERE location_id != 1 AND location_id != 2 AND location_id != '$location_id'";
						$data = mysqli_query($connection,$sqlStore);
						while($store = mysqli_fetch_array($data)){
							echo "<option value='$store[location_id]'>$store[location_name]</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="row g-3 align-items-center mb-4">
			<div class="col-4">
				<label>Ship Out Date:</label>
			</div>
			<div class="col-8">
				<input class="form-control" type="date" name="ship_date" placeholder="<?php echo $current_date; ?>" value="<?php echo $current_date; ?>" readonly></td> <!--validate date-->
			</div>
		</div>
		
		<button class="submit btn btn-success" onclick="submitForm();" type="button">Scan Meter</button>
	</form>
</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>
</html>
