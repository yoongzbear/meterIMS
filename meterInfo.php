<?php
        //include ('secure.php');
        include('connection.php');
        //for testing purpose, serial num: AIS17BA0000001, AIS17BA0000003
        $serial_num = $_GET['serial_num'];
        $sql = "SELECT * FROM meter INNER JOIN batch ON meter.batch_id = batch.batch_id INNER JOIN manufacturer ON meter.manu_id = manufacturer.manu_id INNER JOIN region_store ON batch.store_id = region_store.store_id WHERE serial_num = '$serial_num'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);

        $batch_id = $row['batch_id'];
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Info</title>
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
    <li class="breadcrumb-item"><a href="inv_mag_home.php" title='Home - Inventory Management Department'>Home</a></li>
    <li class="breadcrumb-item"><a href="mov_track_view.php" title='Meter Tracking Page'>Meter Tracking</a></li>
    <li class="breadcrumb-item "><a href="batch_view.php?batch_id=<?= $batch_id; ?>" title='Meter Tracking Page'>Batch Detail</a></li>
    <li class="breadcrumb-item active" aria-current="page">Meter Info</li>
  </ol>
</nav>


    <?php
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