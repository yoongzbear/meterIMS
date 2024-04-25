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
?>

</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="reg_home.php" title='Home Page - Region Store'>Home</a></li>
	<li class="breadcrumb-item"><a href="reg_QRmenu.php" title='Scan QRcode Page'>Scan QRcode</a></li>
    <li class="breadcrumb-item"><a href="store_ShipOrderForm.php" title='Scan QRcode Page'>Ship Out - Ship Meter Batch</a></li>
	<li class="breadcrumb-item"><a href="store_ShipOrderScanMeter.php" title='Scan QRcode Page'>Scan QR Page - Meter Shipping Form</a></li>
    <li class="breadcrumb-item active" aria-current="page">Meter Shipping</li>

  </ol>
</nav>

<?php
    include ('connection.php');
    $newBatch_id = $_GET['Batch_ID'];
		$serial_num = $_GET['Meter_ID'];
		$meterQuantity = $_GET['meterQuantity'];
			
		//Update Batch meter quantity
		$sqlUpdateBatch = "UPDATE batch SET quantity = quantity - 1 WHERE batch_id = 
		(SELECT batch_id FROM meter WHERE serial_num = '$serial_num')";
		$resultUpdateBatch = mysqli_query($connection, $sqlUpdateBatch);
		
		//Update Batch_ID of the meter
		$sqlUpdateMeter = "UPDATE meter SET batch_id = $newBatch_id, meter_status = 'SHIPPING', location_id = NULL WHERE serial_num = '$serial_num'";
		$resultUpdateMeter = mysqli_query($connection, $sqlUpdateMeter);
		
		//Count the number of meters in the new batch
		$sqlCountNewBatch = "SELECT COUNT(*) AS meterCount FROM meter WHERE batch_id = $newBatch_id";
		$resultCountNewBatch = mysqli_query($connection, $sqlCountNewBatch);
		$row = mysqli_fetch_assoc($resultCountNewBatch);
		$meterCount = $row['meterCount'];
			
		//Update the numbers of meters in new Batch
		$sqlCountQuantity = "SELECT * FROM meter WHERE batch_id = $newBatch_id";
		$quantityResult = mysqli_query($connection, $sqlCountQuantity);
		if ($quantityResult){
			$rowCount = mysqli_num_rows($quantityResult);
			
			//Update Batch Info with meter quantity
			$sqlUpdateQuantity = "UPDATE `batch` SET `quantity` = '$rowCount' WHERE `batch_id` = '$newBatch_id'";
			$resultUpdate = mysqli_query($connection, $sqlUpdateQuantity);
		}

		//Determine which button to show based on meter count
		$showCompleteButton = ($meterCount == $meterQuantity) ? true : false;
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        //Show button based on PHP variable
        <?php if($showCompleteButton): ?>
            document.getElementById("complete").style.display = "block";
            document.getElementById("addAnother").style.display = "none";
        <?php else: ?>
            document.getElementById("addAnother").style.display = "block";
            document.getElementById("complete").style.display = "none";
        <?php endif; ?>

        document.getElementById("addAnother").addEventListener("click", function() {
            window.location.href = "store_ShipOrderScanMeterQR.php?Batch_ID=<?php echo $newBatch_id; ?>&meterQuantity=<?php echo $meterQuantity; ?>";
        });

        document.getElementById("complete").addEventListener("click", function() {
            window.location.href = "store_ShipAddMeterComplete.php?Batch_ID=<?php echo $newBatch_id; ?>";
        });
    });
</script>

<!--To show if the meter is added succesfully-->
<div class="container mb-4">
    <div id="success" style="display:none;">
        <h2>Meter Added Successfully</h2>
		<?php	
			echo "<script>alert('Meter Added Successfully!');</script>";
			//To select the meter information
			$sqlShowMeter = "SELECT * FROM meter WHERE serial_num = '$serial_num'";
			$resultSelect = mysqli_query($connection, $sqlShowMeter);
			if ($resultSelect) {
				$row = mysqli_fetch_assoc($resultSelect);

				//Fetch data from the database
				$serial_num = $row["serial_num"];
				$age = $row["age"];
				$mileage = $row["mileage"];
				$manufactured_year = $row["manufactured_year"];
				$manu_id = $row["manu_id"];
			}
			
			//To show the manufacturer name
			$sqlShowManuName = "SELECT * FROM manufacturer WHERE manu_id = '$manu_id'";
			$resultSelectManu = mysqli_query($connection, $sqlShowManuName);
			if ($resultSelect) {
				$rowManu = mysqli_fetch_assoc($resultSelectManu);

				//Fetch data from the database
				$manu_name = $rowManu["manu_name"];
			}
		?>
		<table class="table mb-4">
			<tr colspan = "2">
				<td>
					<div id="qrcode">
						<script src = "qrcode.js"></script>
						<script src = "qrGeneratorMeter.js"></script>
						<script>makeCode(); </script>
					</div>
				</td>
			</tr>
			<tr>
				<th>Meter Serial Number:</th>
				<td><?php echo $serial_num; ?></td>
			</tr>
			
			<tr>
				<th>Age:</th>
				<td><?php echo $age; ?></td>
			</tr>
			
			<tr>
				<th>Mileage</th>
				<td><?php echo $mileage; ?></td>
			</tr>
			
			<tr>
				<th>Manufacturer Name:</th>
				<td><?php echo $manu_name; ?></td>
			</tr>
			
			<tr>
				<th>Manufactured Year:</th>
				<td><?php echo $manufactured_year; ?></td>
			</tr>
		</table>
    </div>
    
    <div id="fail" style="display:none;">
        <h3>Message</h3>
        <h2>Failed To Add</h2>
    </div>

    <div id="buttons" style="display:none;">
        <button id="addAnother" class="btn btn-success">Add Next Meter</button>
        <button id="complete" class="btn btn-outline-success">Complete</button>
    </div>
</div>

<?php
    if($resultUpdateBatch == true && $resultUpdateMeter == true) {
		echo "<script>document.getElementById('success').style.display = 'block';</script>";
        echo "<script>document.getElementById('buttons').style.display = 'block';</script>";
    } else {
        echo "<script>document.getElementById('fail').style.display = 'block';</script>";
    }
?>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>
