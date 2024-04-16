<?php
	include('secure_Inv.php');
	include('connection.php');
	$meter_type = $_POST["meter_type"];
	$meter_model = $_POST["meter_model"];
	$meter_size = $_POST["meter_size"];
	$manu_id = $_POST["manu_id"];
	
	//Insert meter batch info
	$sqlBatch = "INSERT INTO batch (store_id, meter_type, meter_model, meter_size) 
	VALUES (1, '$meter_type', '$meter_model', '$meter_size')";
	$result = mysqli_query($connection, $sqlBatch);
	
	if ($result) {
		$batch_id = mysqli_insert_id($connection);
		echo "<script>window.location.href = 'inventoryDep_AddMeterForm.php?Batch_ID=$batch_id&manu_id=$manu_id';</script>"; 
	} else {
		echo "<script>alert('Fail to add new meter.');</script>";
		echo "<script>window.history.back();</script>"; // Go back to the previous page on failure
	}
?>