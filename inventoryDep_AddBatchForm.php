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
?>

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
<div class="content">
    <h3 class="header">Create New Batch</h3>
    <form action="inventoryDep_AddBatch.php" method="post">
        <table>
			<tr>
				<td>Meter Type</td>
				<td><input type="text" name="meter_type" required></td>
			</tr>
			<tr>
				<td>Meter Model</td>
				<td><input type="text" name="meter_model" required></td>
			</tr>
			<tr>
				<td>Meter Size</td>
				<td><input type="number" name="meter_size" required></td> <!--positive number validation-->
			</tr>
			<tr>
				<td>Manufacturer Name</td>
				<td>
					<select name="manu_id">
						<option value="" disabled selected>Please Select Manufacturer</option>
						<?php
							$sqlManu="SELECT * FROM manufacturer";
							$data = mysqli_query($connection,$sqlManu);
							while($manu = mysqli_fetch_array($data)){
								echo "<option value='$manu[manu_id]'>$manu[manu_name]</option>";
							}
						?>
					</select>
				</td>
			</tr>
		</table>
		<button onclick="confirmation();" type="submit">Add Meter</button>
	</form>
</div>
</html>
