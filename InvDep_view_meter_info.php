<?php
    include ('secure_Inv.php');
    include('connection.php');
    $serial_num = $_GET['serial_num'];
    //get meter information
    $sql_info="SELECT manufacturer.*, meter.*, batch.* FROM manufacturer JOIN meter ON manufacturer.manu_id = meter.manu_id JOIN batch ON meter.batch_id =batch.batch_id WHERE serial_num = '$serial_num'";
    $result_info = mysqli_query($connection, $sql_info);
    $row_info = mysqli_fetch_assoc($result_info);

    $batch_id = $row_info['batch_id'];
    //get location information
    $sql_location = "SELECT movement.inbound_id ,movement.batch_id,movement.arrival_date, inbound.*, location.* FROM movement JOIN inbound ON movement.inbound_id = inbound.inbound_id JOIN location ON inbound.location_id = location.location_id WHERE movement.batch_id = $batch_id AND movement.arrival_date IS NOT NULL ORDER BY movement.tracking_id DESC LIMIT 1";
    $result_location = mysqli_query($connection, $sql_location);
    
    // Check if the query returns any results and meter status
    if (mysqli_num_rows($result_location) > 0) {
        $row_location = mysqli_fetch_assoc($result_location);
        if ($row_info['meter_status'] == "INSTALLED") {
            $current_location = $row_info['install_address'];
        } else {
            $current_location = $row_location['location_name']; 
        }
    } else {
        // No records found, set location_name to default value
        $current_location = "Air Selangor Inventory Department";
    }

    $sql_reg ="SELECT meter.*, location.* FROM meter JOIN location ON meter.location_id = location.location_id WHERE meter.serial_num = '$serial_num'";
    $result_reg = mysqli_query($connection, $sql_reg);
    // Check if any result is returned
    if ($result_reg) {
        $row_reg = mysqli_fetch_assoc($result_reg);
        if ($row_reg !== null) {
            // Location information is available
            $location_name = $row_reg['location_name'];
        } else {
            // No location information available
            $location_name = "The meter hasn't been assigned to a region store";
        }
    } else {
        // Handle query execution error
        echo "Error: " . mysqli_error($connection);
    } ?>

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
        include 'navInv.php';
    ?>
</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="inv_mag_home.php" title='Home Page - Inventory Management Department'>Home</a></li>
    <li class="breadcrumb-item"><a href="Inv_QRmenu.php" title='QRcode Page'>QR Code</a></li>
	<li class="breadcrumb-item active" aria-current="page">Scan QR - View Meter Info</li>
  </ol>
</nav>

<div class="col align-self-center">
    <?php
        echo "<h2 class='fs-1 text-uppercase'>Meter Info</h2>
        <hr class='border border-success border-2 opacity-50'>
        <table class='table'><th colspan=2><h3>" . $row_info['serial_num'] . "</h3></th>        
            <tr>
                <th>Type:</th>
                <td>" . $row_info['meter_type'] . "</td>
            </tr>
            <tr>
                <th>Model:</th>
                <td>" . $row_info['meter_model'] . "</td>
            </tr>
            <tr>
                <th>Size:</th>
                <td>" . $row_info['meter_size'] . "</td>
            </tr>
            <tr>
                <th>Age:</th>
                <td>" . $row_info['age'] . "</td>
            </tr>
            <tr>
                <th>Mileage:</th>
                <td>" . $row_info['mileage'] . "</td>
            </tr>
            <tr>
                <th>Manufacturer:</th>
                <td>" . $row_info['manu_name'] . "</td>
            </tr>
            <tr>
                <th>Manufacture Year:</th>
                <td>" . $row_info['manufactured_year'] . "</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>" . $row_info['meter_status'] . "</td>
            </tr>
            <tr>
                <th>Location:</th>
                <td>" . $current_location . "</td>
            </tr>
            <tr>
                <th>Assigned Region Store:</th>
                <td>" . $location_name. "</td>
            </tr>";
        if ($row_info['install_date'] != NULL) {
            //if the meter is installed
            echo "<tr>
                <th>Install Date:</th>
                <td>" . $row_info['install_date'] . "</td>
            </tr>
            <tr>
                <th>Install Address:</th>
                <td>" . $row_info['install_address'] . "</td>
            </tr>";}
        echo "</table>";
    ?>

    <div class="d-grid gap-2 col-6 mx-auto mb-4">
        <button class="back btn btn-dark" type="button" onclick="window.location.href='InvDep_Scan_View_meter_info.php'" title='Back To Scan QR Page'>Back</button>
    </div>
</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>
</html>
