<?php
    include ('secure.php');
    include ('connection.php');
    $newBatch_id = $_GET['Batch_ID'];
    $serial_num = $_GET['Meter_ID'];
    $meterQuantity = $_GET['meterQuantity'];
	
	//Update Old Batch meter quantity
	$sqlUpdateBatch = "UPDATE batch SET quantity = quantity - 1 WHERE batch_id = 
	(SELECT batch_id FROM meter WHERE serial_num = '$serial_num')";
	$resultUpdateBatch = mysqli_query($connection, $sqlUpdateBatch);
	
	//Update new Batch_ID of the meter
	$sqlUpdateMeter = "UPDATE meter SET batch_id = $newBatch_id, meter_status = 'SHIPPING' WHERE serial_num = '$serial_num'";
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
		
		//Update New Batch Info with meter quantity
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

<html>
<head><title>Meter Shipping</title></head>

<!--To show if the meter is added succesfully-->
<div class="content">
    <div id="success" style="display:none;">
        <h2>Meter Added Successfully</h2>
		<?php
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
		<table>
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
				<td>Meter Serial Number</td>
				<td><?php echo $serial_num; ?></td>
			</tr>
			
			<tr>
				<td>Age</td>
				<td><?php echo $age; ?></td>
			</tr>
			
			<tr>
				<td>Mileage</td>
				<td><?php echo $mileage; ?></td>
			</tr>
			
			<tr>
				<td>Manufacturer Name</td>
				<td><?php echo $manu_name; ?></td>
			</tr>
			
			<tr>
				<td>Manufactured Year</td>
				<td><?php echo $manufactured_year; ?></td>
			</tr>
		</table>
    </div>
    
    <div id="fail" style="display:none;">
        <h3>Message</h3>
        <h2>Failed To Add</h2>
    </div>

    <div id="buttons" style="display:none;">
        <button id="addAnother">Add Next Meter</button>
        <button id="complete">Complete</button>
    </div>
</div>
</html>


<?php
    if($resultUpdateBatch == true && $resultUpdateMeter == true) {
		echo "<script>document.getElementById('success').style.display = 'block';</script>";
        echo "<script>document.getElementById('buttons').style.display = 'block';</script>";
    } else {
        echo "<script>document.getElementById('fail').style.display = 'block';</script>";
    }
?>
