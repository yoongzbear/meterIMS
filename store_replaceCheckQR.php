<?php
	include 'secure_Reg.php';
	include 'connection.php';
	
	if(isset($_GET['Meter_ID'])) {
		$serial_num = $_GET['Meter_ID'];
		$oldSerial_num = $_GET['oldSerial_num'];
		
		//Check for new meter
		$sqlNew = "SELECT batch.* FROM batch 
				INNER JOIN meter ON meter.batch_id = batch.batch_id
				WHERE meter.serial_num = '$serial_num'";
		$resultNew = mysqli_query($connection, $sqlNew);
		
		//Check for old meter
		$sqlOld = "SELECT batch.* FROM batch 
				INNER JOIN meter ON meter.batch_id = batch.batch_id
				WHERE meter.serial_num = '$oldSerial_num'";
		$resultOld = mysqli_query($connection, $sqlOld);
		
		//Check if the query returned any rows
		if(mysqli_num_rows($resultNew) > 0 && mysqli_num_rows($resultOld) > 0) {
			// serial num exists
			$rowNew = mysqli_fetch_assoc($resultNew);
			$newMeter_type = $rowNew['meter_type'];
			$newMeter_model = $rowNew['meter_model'];
			$newMeter_size = $rowNew['meter_size'];
			
			$rowOld = mysqli_fetch_assoc($resultOld);
			$oldMeter_type = $rowOld['meter_type'];
			$oldMeter_model = $rowOld['meter_model'];
			$oldMeter_size = $rowOld['meter_size'];
			
			if ($newMeter_type == $oldMeter_type && $newMeter_model == $oldMeter_model && $newMeter_size == $oldMeter_size) {
				echo '<script>alert("New meter scanned for replacement.");</script>';
				header("Location:store_replaceMeterComplete.php?Meter_ID=$serial_num&oldSerial_num=$oldSerial_num");
				exit();
			} else {
				echo '<script>alert("The meter type, model, or size do not match the old meter."); window.location.href = "store_replaceMeterScanQR.php?serial_num='.$oldSerial_num.'";</script>';
			}
		} else {
			// serial num does not exist
			echo '<script>alert("Serial number does not exist. Please try again."); window.location.href = "store_replaceMeterScanQR.php?serial_num='.$oldSerial_num.'";</script>';
		}
	}
?>
