<?php 
	include 'secure_Inv.php';
	include ('connection.php');
	$current_date = date('Y-m-d');
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
include 'navInv.php';
?>
</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="inv_mag_home.php" title='Home Page - Inventory Management Department'>Home</a></li>
		<li class="breadcrumb-item"><a href="Inv_QRmenu.php" title='QRcode Page'>QR Code</a></li>
		<li class="breadcrumb-item active" aria-current="page">Ship Out Form</li>
	</ol>
</nav>

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
		var destination = document.forms["shipOrderForm"]["destination"].value;
		var shipDate = document.forms["shipOrderForm"]["ship_date"].value;

		//Check if all required fields are filled
		if (meterDetails == "" || meterQuantity == "" || destination == "" || shipDate == "") {
			alert("Please fill in all fields.");
			return false; 
		}
		return true; 
	}

	function submitForm() {
		if (validateForm()) {
			var confirmProceed = confirm("Please make sure the information is correct before proceeding. You will not be able to modify the information after this.");
			if (confirmProceed) {
				document.shipOrderForm.submit(); // Submit the form if confirmed
			}
		}
	}
</script>

<div class='container col-xl-6 mb-4'>
	<h3>Ship Meter Batch</h3>
	<hr>
	<form class="form" action="invDep_ShipAddBatch.php" method="post" name="shipOrderForm">
		<div class="row g-3 align-items-center">
			<div class="col-6 mb-4">
				<label>Meter Details :</label>
			</div>
			<div class="col-6 mb-4">
				<select class="form-select" name="meter_details" required>
					<option value="" disabled selected>Please Select Meter Type, Model and Size</option>
						<?php
							$sqlMeter = "SELECT DISTINCT meter_type, meter_model, meter_size FROM batch WHERE location_id = 1";
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
		
		<div class="row g-3 align-items-center">
			<div class="col-6 mb-4">
				<!--Shipping details-->
				<input type="hidden" name="origin" value="1" readonly>
				<label>Number of Meters Needed :</label>
			</div>
			<div class="col-6 mb-4">
				<input class="form-control" type="number" name="meterQuantity" required>
			</div>
		</div>
		<div class="row g-3 align-items-center">
			<div class="col-6 mb-4">
				<label>Origin :</label>
			</div>
			<div class="col-6 mb-4">
				<label>Air Selangor</label>
			</div>
		</div>
		
		<div class="row g-3 align-items-center">
			<div class="col-6 mb-4">
				<label>Destination :</label>
			</div>
			<div class="col-6 mb-4">
				<select class="form-select" name="destination" required>
					<option class="form-select" value="" disabled selected>Please Select Destination Region Store</option>
						<?php
							$sqlStore="SELECT * FROM location WHERE location_id != 1 AND location_id != 2";
							$data = mysqli_query($connection,$sqlStore);
							while($store = mysqli_fetch_array($data)){
								echo "<option value='$store[location_id]'>$store[location_name]</option>";
							}
						?>
				</select>
			</div>
		</div>
		
		<div class="row g-3 align-items-center">
			<div class="col-6 mb-4">
				<label>Ship Out Date :</label>
			</div>
			<div class="col-6 mb-4">
				<input class="form-control" type="date" name="ship_date" value="<?php echo $current_date; ?>" readonly>
			</div>
		</div>
		<button class="submit btn btn-outline-success mb-4" onclick="submitForm();" type="button">Scan Meter</button>
	</form>
</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>
</html>
