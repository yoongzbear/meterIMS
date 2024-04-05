<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Info</title>
</head>
<body>
    <?php
        //include ('secure.php');
        include('connection.php');
        //for testing purpose, serial num: AIS17BA0000001, AIS17BA0000003
        $serial_num = $_GET['serial_num'];
        $sql = "SELECT * FROM meter INNER JOIN batch ON meter.batch_id = batch.batch_id INNER JOIN manufacturer ON meter.manu_id = manufacturer.manu_id INNER JOIN region_store ON batch.store_id = region_store.store_id WHERE serial_num = '$serial_num'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);

        //type, model, size, age, mileage, manufacturer, manu year, status, install date, install address, location of store
        echo "<h1>Meter Info</h1>";
        echo "<table><th colspan=2><h2>" . $row['serial_num'] . "</h2></th>
            <tr>
                <td>Type:</td>
                <td>" . $row['meter_type'] . "</td>
            </tr>
            <tr>
                <td>Model:</td>
                <td>" . $row['meter_model'] . "</td>
            </tr>
            <tr>
                <td>Size:</td>
                <td>" . $row['meter_size'] . "</td>
            </tr>
            <tr>
                <td>Age:</td>
                <td>" . $row['age'] . "</td>
            </tr>
            <tr>
                <td>Mileage:</td>
                <td>" . $row['mileage'] . "</td>
            </tr>
            <tr>
                <td>Manufacturer:</td>
                <td>" . $row['manu_name'] . "</td>
            </tr>
            <tr>
                <td>Manufacture Year:</td>
                <td>" . $row['manufactured_year'] . "</td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>" . $row['meter_status'] . "</td>
            </tr>
            <tr>
                <td>Region Store:</td>
                <td>" . $row['region'] . "</td>
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
        echo "</table>";
    ?>
</body>
</html>