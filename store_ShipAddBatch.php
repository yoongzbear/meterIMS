<?php
	include('secure.php');
	include('connection.php');
	$meter_type = $_POST["meter_type"];
	$meter_model = $_POST["meter_model"];
	$meter_size = $_POST["meter_size"];
	
	$meterQuantity = $_POST["meterQuantity"];
	$origin = $_POST["origin"];
	$destination = $_POST["destination"];
	$ship_date = $_POST["ship_date"];
	
	//Insert meter batch info
	$sqlBatch = "INSERT INTO batch (location_id, meter_type, meter_model, meter_size) 
	VALUES ('$origin', '$meter_type', '$meter_model', '$meter_size')";
	$result = mysqli_query($connection, $sqlBatch);
	
	if ($result) {
		$batch_id = mysqli_insert_id($connection);
		
		//Insert tracking details
		$sqlTracking = "INSERT INTO movement (origin, destination, ship_date, batch_id) VALUES
		('$origin', '$destination', '$ship_date', '$batch_id')";
		$resultTrack = mysqli_query($connection, $sqlTracking);
		echo "<script>window.location.href = 'store_ShipOrderScanMeterQR.php?Batch_ID=$batch_id&meterQuantity=$meterQuantity';</script>"; 
	} else {
		echo "<script>alert('Fail to add new meter.');</script>";
		echo "<script>window.history.back();</script>"; // Go back to the previous page on failure
	}
?>