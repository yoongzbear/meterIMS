<?php
include ('secure_Reg.php'); 
include('connection.php');

        //for testing purpose, serial num: AIS17BA0000001, AIS17BA0000003
        $serial_num = $_POST['serial_num'];
        $sql = "SELECT * FROM meter INNER JOIN batch ON meter.batch_id = batch.batch_id INNER JOIN manufacturer ON meter.manu_id = manufacturer.manu_id INNER JOIN location ON batch.location_id = location.location_id WHERE serial_num = '$serial_num'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        
        $batch_id = $row['batch_id'];

 $sql1 = "SELECT meter.location_id, location.location_name FROM meter JOIN location ON meter.location_id = location.location_id WHERE serial_num = '$serial_num'";
        $result1 = mysqli_query($connection, $sql1);
        
        // Check if any result is returned
        if ($result1) {
            $row1 = mysqli_fetch_assoc($result1);
            if ($row1 !== null) {
                // Location information is available
                $location_name = $row1['location_name'];
            } else {
                // No location information available
                $location_name = "The meter hasn't been assigned to a region store";
            }
        } else {
            // Handle query execution error
            echo "Error: " . mysqli_error($connection);
        }
        ?>



    <?php
        //type, model, size, age, mileage, manufacturer, manu year, status, install date, install address, location of store
        echo "<div class='col align-self-center'>
        <h2 class='fs-1 text-uppercase'>Meter Info</h2>
        <hr class='border border-success border-2 opacity-50'>";
        echo "<table class='table'><th colspan=2><h3>" . $row['serial_num'] . "</h3></th>
        
            <tr>
                <th>Type:</th>
                <td>" . $row['meter_type'] . "</td>
            </tr>
            <tr>
                <th>Model:</th>
                <td>" . $row['meter_model'] . "</td>
            </tr>
            <tr>
                <th>Size:</th>
                <td>" . $row['meter_size'] . "</td>
            </tr>
            <tr>
                <th>Age:</th>
                <td>" . $row['age'] . "</td>
            </tr>
            <tr>
                <th>Mileage:</th>
                <td>" . $row['mileage'] . "</td>
            </tr>
            <tr>
                <th>Manufacturer:</th>
                <td>" . $row['manu_name'] . "</td>
            </tr>
            <tr>
                <th>Manufacture Year:</th>
                <td>" . $row['manufactured_year'] . "</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>" . $row['meter_status'] . "</td>
            </tr>
            <tr>
                <th>Location:</th>
                <td>" . $row['location_name'] . "</td>
            </tr>
            <tr>
                <th>Assigned Region Store:</th>
                <td>" . $location_name. "</td>
            </tr>
            ";
        if ($row['install_date'] != NULL) {
            //if the meter is installed
            echo "<tr>
                <td>Install Date:</td>
                <td>" . $row['install_date'] . "</td>
            </tr>
            <tr>
                <td>Install Address:</td>
                <td>" . $row['install_address'] . "</td>
            </tr>";}
        echo "</table></div>";
    ?>

<button type="button" onclick="window.location.href='RegDep_Scan_View_meter_info.php'">Back</button>

