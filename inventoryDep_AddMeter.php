<?php
    include ('secure_Inv.php');
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
<div class="col align-self-center">
    <div id="success" style="display:none;">
        <h3>Meter Added Successfully</h3>
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

		<table class="table table-borderless">
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
				<th scope="row">Meter Serial Number</th>
				<td><?php echo $serial_num; ?></td>
			</tr>
			
			<tr>
				<th scope="row">Age</th>
				<td><?php echo $age; ?></td>
			</tr>
			
			<tr>
				<th scope="row">Mileage</th>
				<td><?php echo $mileage; ?></td>
			</tr>
			
			<tr>
				<th scope="row">Manufacturer Name</th>
				<td><?php echo $manu_name; ?></td>
			</tr>
			
			<tr>
				<th scope="row">Manufactured Year</th>
				<td><?php echo $manufactured_year; ?></td>
			</tr>
		</table>
    </div>
    
    <div id="fail" style="display:none;">
        <h3>Message</h3>
        <h2>Failed To Add</h2>
    </div>

    <div id="buttons" style="display:none;">
        <button id="addAnother" class="btn btn-success">Add More Meter</button>
        <button id="complete" class="btn btn-outline-success">Complete</button>
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


</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>
