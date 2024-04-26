<?php
/* 
Enter meter info (after they receive the meter) (paola)

get id from qr

IF action = generateQr: //from vendors
	GENERATE qrBatch; //generate during shipping
	SET numMeter = 0;

	//assume 1 box/batch can only hv 50 meters	//button (continue?)
	WHILE button completed not clicked: 
		GENERATE qrMeter;
		form to insert meter info
		//assign in database
		SET qrBatch = qrBatch; 
	END WHILE
	
	SHOW summary of the meter for this batch - not sure
ENDIF

quantity use count from batch id
*/

	include ('connection.php');
	include 'secure_Inv.php';
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
include 'navInv.php';
?>

</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="inv_mag_home.php" title='Home Page - Inventory Management Department'>Home</a></li>
		<li class="breadcrumb-item"><a href="Inv_QRmenu.php" title='QRcode Page'>QR Code</a></li>
		<li class="breadcrumb-item active" aria-current="page">Receive Meter</li>

	</ol>
</nav>

<script>
	function confirmation() {
		var confirmProceed = confirm("Please make sure the information are correct before proceed to add meter. You are not allowed to modify the information after this.");
		if (confirmProceed) {
			window.location.href = 'inventoryDep_AddBatch.php';
		} else {
			return false;
		}
	}
</script>

<html>
<!--Form to insert details of the meters in batch-->
<div class='container col-xl-5 mb-4'>
<h3>Create New Batch</h3>
	<hr>

<form action="inventoryDep_AddBatch.php" method="post">

<div class="row g-3 align-items-center mb-4">
	<div class="col-auto">
		<label class="col-form-label">Meter Type : </label>
	</div>
	<div class="col-auto">
		<input class="form-control form-control-sm" type="text" name="meter_type" required>
	</div>
</div>

<div class="row g-3 align-items-center mb-4">
	<div class="col-auto">
		<label class="col-form-label">Meter Model : </label>
	</div>
	<div class="col-auto">
		<input class="form-control form-control-sm" type="text" name="meter_model" required>
	</div>
</div>

<div class="row g-3 align-items-center mb-4">
	<div class="col-auto">
		<label class="col-form-label">Meter Size : </label>
	</div>
	<div class="col-auto">
		<select class="form-select" name="meter_size" required>
			<option value="" disabled selected>Please Select Meter Size</option>
			<option value="15">15</option>
			<option value="20">20</option>
			<option value="25">25</option>
			<option value="40">40</option>
			<option value="50">50</option>
			<option value="80">80</option>
			<option value="100">100</option>
			<option value="150">150</option>
		</select>
	</div>
</div>
		
<div class="row g-3 align-items-center mb-4">
	<div class="col-auto">
		<label class="col-form-label">Manufacturer Name : </label>
	</div>
	<div class="col-auto">
		<select class="form-select" name="manu_id">
		<option value="" disabled selected>Please Select Manufacturer</option>
			<?php
				$sqlManu="SELECT * FROM manufacturer";
				$data = mysqli_query($connection,$sqlManu);
				while($manu = mysqli_fetch_array($data)){
				echo "<option value='$manu[manu_id]'>$manu[manu_name]</option>";
				}
			?>
		</select>
	</div>
</div>
				
				
					
		<button onclick="confirmation();" type="submit" class="btn btn-success">Add Meter</button>
	</form>
</div>

</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>
