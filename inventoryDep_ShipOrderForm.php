<?php /* 
-	Inventory department, region store: 
scan batch ship out, write which store its going to 
– once batch id is determined, generate qr code (paola)

IF action = shipOrder:
	//INPUT meter to buy/needed;
	INPUT totalOrdernumber; 
	INPUT shipping details; (date to send, origin, destination, description, ...)
	button
	GENERATE qrBatch
	
	FOR orderNum < (totalOrdernumber):
		SCAN qrMeter;
	ENDFOR
	
	SHOW receipt/summary; //maybe can have a confirmation msg/allow them edit after this
ENDIF
*/


// generate qr
	include ('connection.php');
?>

<script>
    function validateForm() {
		//Get the values of meter batch details fields
        var meter_type = document.forms["shipOrderForm"]["meter_type"].value;
        var meter_model = document.forms["shipOrderForm"]["meter_model"].value;
        var meter_size = document.forms["shipOrderForm"]["meter_size"].value;
		
        //Get the values of shipping details fields
        var meterQuantity = document.forms["shipOrderForm"]["meterQuantity"].value;
        var destination = document.forms["shipOrderForm"]["destination"].value;
        var shipDate = document.forms["shipOrderForm"]["ship_date"].value;

        //Check if all required fields are filled
        if (meter_type == "" || meter_model == "" || meter_size == "" || meterQuantity == "" || destination == "" || shipDate == "") {
            alert("Please fill in all fields.");
            return false; //Prevent form submission
        }
        return true; //Allow form submission
    }

    function submitForm() {
        if (validateForm()) {
            var confirmProceed = confirm("Please make sure the information is correct before proceeding. You will not be able to modify the information after this.");
            if (confirmProceed) {
                document.shipOrderForm.submit(); // Submit the form if confirmed
            }
        }
    }
</script>

<html>
<head><title>Meter Shipping</title></head>
<div class="content">
    <h3 class="header">Ship Meter Batch</h3>
	<form class="form" action="invDep_ShipAddBatch.php" method="post" name="shipOrderForm">

        <table>
			<!--Meter Information-->
			<tr>
				<td>Meter Type</td>
				<td><input type="text" name="meter_type" required></td>
			</tr>
			<tr>
				<td>Meter Model</td>
				<td><input type="text" name="meter_model" required></td>
			</tr>
			<tr>
				<td>Meter Size</td> <!--Drop Down-->
				<td><select name="meter_size" required>
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
				</td> <!--positive number validation-->
			</tr>
			
			<!--Shipping details-->
			<input type="hidden" name="origin" value="1" readonly>
            <tr>
                <td>Number of Meters Needed</td>
                <td><input type="number" name="meterQuantity" required></td>
            </tr>
			<tr>
                <td>Origin</td>
                <td>Air Selangor</td>
            </tr>
			<tr>
                <td>Destination</td>
                <td>
					<select name="destination" required>
						<option value="" disabled selected>Please Select Destination Region Store</option>
						<?php
							$sqlStore="SELECT * FROM location WHERE location_id != 1 AND location_id != 2";
							$data = mysqli_query($connection,$sqlStore);
							while($store = mysqli_fetch_array($data)){
								echo "<option value='$store[location_id]'>$store[location_name]</option>";
							}
						?>
					</select>
				</td>
            </tr>
			<tr>
				<td>Ship Out Date</td>
				<td><input type="date" name="ship_date" required></td> <!--validate date-->
			</tr>
        </table>
		<button class="submit" onclick="submitForm();" type="button">Scan Meter</button>
		<!--After submit, show confirm msg, start scanning, buttons-->
    </form>
</div>
</html>