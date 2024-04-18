<?php
	include('secure_Inv.php');
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

	//Check if there are meters associated with the batch
	$sqlMeterCount = "SELECT COUNT(*) AS meter_count FROM meter WHERE batch_id = '$batch_id'";
	$resultMeterCount = mysqli_query($connection, $sqlMeterCount);
	if ($resultMeterCount) {
		$rowMeterCount = mysqli_fetch_assoc($resultMeterCount);
		$meterCount = $rowMeterCount['meter_count'];
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

<script>
	function setNumberDecimal(event) {
		this.value = parseFloat(this.value).toFixed(2);
	}

	function confirmCancel() {
		var inputs = document.getElementsByTagName("input");
		var hasValue = false;
		for (var i = 0; i < inputs.length; i++) {
			if (inputs[i].value.trim() !== "") {
				hasValue = true;
				break;
			}
		}
		if (hasValue) {
			var confirmation = confirm("You have entered data. Are you sure you want to cancel?");
			if (confirmation) {
				clearInputs();
				window.location.href = 'inventoryDep_AddMeterComplete.php?Batch_ID=<?php echo $batch_id; ?>';
			}
		} else {
			window.location.href = 'inventoryDep_AddMeterComplete.php?Batch_ID=<?php echo $batch_id; ?>';
		}
	}

	function clearInputs() {
		var inputs = document.getElementsByTagName("input");
		for (var i = 0; i < inputs.length; i++) {
			inputs[i].value = "";
		}
	}
</script>

<html>
		<!--Show Current Batch Info-->
		
		<div class="container">
      <div class="row align-items-start">
        <div class="col">
		
		<h3>Current Batch Information</h3>
		<hr>

		<table class="table table-borderless">
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
				<th scope="row">Meter Type</th>
				<td><?php echo $meter_type; ?></td>
			</tr>
			<tr>
				<th scope="row">Meter Model</th>
				<td><?php echo $meter_model; ?></td>
			</tr>
			<tr>
				<th scope="row">Meter Size</th>
				<td><?php echo $meter_size; ?></td>
			</tr>
			<tr>
				<!--Show Current Total Meter for Current Batch-->
				<th scope="row">Current Meter Quantity</th>
				<td><?php echo $quantity; ?></td>
			</tr>
		</table>
		</div>
        
		<div class="col">
        
		<h3>Add Meter Information</h3>
		<hr>

		<form action="inventoryDep_AddMeter.php" method="get">
			<table class="table table-borderless">
				<input type="hidden" name="batch_id" value="<?php echo $batch_id;?>">
				<input type="hidden" name="manu_id" value="<?php echo $manu_id;?>">
				<tr class="table-primary">
					<td>Meter Serial Number</td>
					<td><input class="form-control form-control-sm" type="text" name="Meter_ID" placeholder="AIS17BA00XXXXX" required></td>
				</tr>
				
				<tr class="table-primary">
					<td>Age</td>
					<td><input class="form-control form-control-sm" type="number" onchange="setNumberDecimal" name="age" step="0.1" min="0" placeholder="0.0" required></td>
				</tr>
				
				<tr class="table-primary">
					<td>Mileage</td>
					<td><input class="form-control form-control-sm" type="number" name="mileage" min="1" required></td>
				</tr>
				
				<tr class="table-primary">
					<td>Manufactured Year</td>
					<td><input class="form-control form-control-sm" type="number" name="manufactured_year" maxlength="4" pattern="\d{4}" required></td> 
				</tr>
			</table>
			<br>
			<div class="buttons float-end">
				<button type="submit">Add Meter</button>
				<?php if ($meterCount > 0) { ?>
					<button type="button" onclick="confirmCancel();">Cancel</button>
				<?php } else { ?>
					<button type="button" onclick="alert('Please add at least one meter before canceling.');">Cancel</button>
				<?php } ?>
			</div>
			
		</form>

		</div>
      </div>
    </div>

</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>
