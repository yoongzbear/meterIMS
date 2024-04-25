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
include 'navReg.php';
?>

</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="reg_home.php" title='Home Page - Region Store'>Home</a></li>
	<li class="breadcrumb-item"><a href="reg_QRmenu.php" title='Scan QRcode Page'>Scan QRcode</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ship Out - Ship Meter Batch</li>

  </ol>
</nav>

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
	$location_id = $_SESSION['locationID'];
	
	//Get location name from locationID
	$sqlLocation = "SELECT * FROM location WHERE location_id = '$location_id'";
	$resultLocation = mysqli_query($connection, $sqlLocation);
	if ($resultLocation){
		$rowLocation = mysqli_fetch_assoc($resultLocation);
		
		$storeName = $rowLocation['location_name'];
	}
	$current_date = date('Y-m-d');
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

<div class="col align-self-center mb-4">
    <h3 class="header">Ship Meter Batch</h3>
	<hr class="border border-success border-2 opacity-50">
	<form class="form" action="store_ShipAddBatch.php" method="post" name="shipOrderForm">

        <table class="table table-borderless mb-4">
			<!--Meter Information-->
			<tr>
				<th>Meter Type:</th>
				<td><input class="form-control" type="text" name="meter_type" required></td>
			</tr>
			<tr>
				<th>Meter Model:</th>
				<td><input class="form-control" type="text" name="meter_model" required></td>
			</tr>
			<tr>
				<th>Meter Size:</th> <!--Drop Down-->
				<td><select class="form-select" name="meter_size" required>
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
			<input class="form-control" type="hidden" name="origin" value="<?php echo $location_id; ?>" readonly>
            <tr>
                <th>Number of Meters Needed:</th>
                <td><input class="form-control" type="number" name="meterQuantity" required></td>
            </tr>
			<tr>
                <th>Origin:</th>
                <td><?php echo $storeName ;?></td>
            </tr>
			<tr>
                <th>Destination:</th>
                <td>
					<select class="form-select" name="destination" required>
						<option value="" disabled selected>Please Select Destination Region Store</option>
						<?php
							$sqlStore="SELECT * FROM location WHERE location_id != 1 AND location_id != 2 AND location_id != '$location_id'";
							$data = mysqli_query($connection,$sqlStore);
							while($store = mysqli_fetch_array($data)){
								echo "<option value='$store[location_id]'>$store[location_name]</option>";
							}
						?>
					</select>
				</td>
            </tr>
			<tr>
				<th>Ship Out Date:</th>
				<td><input class="form-control" type="date" name="ship_date" placeholder="<?php echo $current_date; ?>" value="<?php echo $current_date; ?>" readonly></td> <!--validate date-->
			</tr>
        </table>
		<button class="submit btn btn-outline-success mb-4" onclick="submitForm();" type="button">Scan Meter</button>
		<!--After submit, show confirm msg, start scanning, buttons-->
    </form>
</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>
</html>