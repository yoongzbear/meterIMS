<?php
include ('secure_Reg.php');
include ('connection.php');
$locationID = $_SESSION['locationID'];
$sql = "SELECT warranty.*, lab_result.*,meter.*FROM warranty
        JOIN lab_result ON warranty.test_id = lab_result.test_id
        JOIN meter ON lab_result.serial_num= meter.serial_num
        WHERE warranty_status = 'CAN CLAIM' AND meter.location_id= $locationID";

$result = mysqli_query($connection, $sql);

$num = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Meter Warranty</title>
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
        <li class="breadcrumb-item active" aria-current="page">Meter Warranty</li>
    </ol>
</nav>

<h3 class="display-4 mb-4">Meter Warranty</h3>

<table class="table table-bordered">
    <thead class="table-light">
    <tr>
        <th>No</th>
        <th>Meter Type</th>
        <th>Meter Size</th>
        <th>Meter Model</th>
        <th>Installation Address</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody class="table-group-divider">
    <?php while ($row = mysqli_fetch_array($result)) { ?>
        <tr>
            <th><?php echo $num++; ?></th>
            <td><?php echo $row["meter_type"]; ?></td>
            <td><?php echo $row["meter_size"]; ?></td>
            <td><?php echo $row["meter_model"]; ?></td>
            <td><?php echo $row["install_address"]; ?></td>
            <td><button class="btn btn-sm btn-info" onclick="window.location.href= 'store_replaceMeterScanQR.php?serial_num=<?php echo $row['serial_num']; ?>';">Install New Meter</button></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>
</html>
