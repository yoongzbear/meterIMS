<?php
    include ('secure.php');
    include ('connection.php');
    $batch_id = $_GET['batch_id'];
    $serial_num = $_GET['Meter_ID'];
    $age = $_GET['age'];
    $mileage = $_GET['mileage'];
    $manufactured_year = $_GET['manufactured_year'];
    $manu_id = $_GET['manu_id'];


    $sqlMeter = "INSERT INTO meter (serial_num, age, mileage, batch_id, meter_status, manufactured_year, manu_id)
                VALUES ('$serial_num', '$age', '$mileage', '$batch_id', 'IN STORE', '$manufactured_year', '$manu_id')";
    $result = mysqli_query($connection, $sqlMeter);
	
	// Count the number of records in the meter table with the given batch_id
    $sqlCountQuantity = "SELECT * FROM meter WHERE batch_id = $batch_id";
    $quantityResult = mysqli_query($connection, $sqlCountQuantity);
	if ($quantityResult){
		$rowCount = mysqli_num_rows($quantityResult);
		
		//Update Batch Info with meter quantity
		$sqlUpdateQuantity = "UPDATE `batch` SET `quantity` = '$rowCount' WHERE `batch_id` = '$batch_id'";
		$resultUpdate = mysqli_query($connection, $sqlUpdateQuantity);
	}
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("addAnother").addEventListener("click", function() {
			window.location.href = "inventoryDep_AddMeterForm.php?Batch_ID=<?php echo $batch_id; ?>&manu_id=<?php echo $manu_id; ?>";
		});


        document.getElementById("complete").addEventListener("click", function() {
            window.location.href = "inventoryDep_AddMeterComplete.php?Batch_ID=<?php echo $batch_id; ?>";
        });
    });
</script>


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

				// Fetch data from the database
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

				// Fetch data from the database
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
        <button id="addAnother">Add More Meter</button>
        <button id="complete">Complete</button>
    </div>
</div>


<?php
    if($result == true) {
        echo "<script>document.getElementById('success').style.display = 'block';</script>";
        echo "<script>document.getElementById('buttons').style.display = 'block';</script>";
    } else {
        echo "<script>document.getElementById('fail').style.display = 'block';</script>";
    }
?>
