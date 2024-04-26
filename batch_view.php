<?php
include ('secure_Inv.php');
include ('connection.php');

$batchid = $_GET["batch_id"];
$sql = "SELECT batch.*, location.* FROM batch
        JOIN location ON batch.location_id = location.location_id
        WHERE batch.batch_id = $batchid";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);
?>

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
    <li class="breadcrumb-item"><a href="mov_track_view.php" title='Meter Tracking Page'>Meter Tracking</a></li>
    <li class="breadcrumb-item active" aria-current="page">Batch Detail</li>
  </ol>
</nav>

<label class="fs-2 font-monospace mb-4"><b>The Information About The Batch ID : </b>
<?php 
echo $batchid; 
?>
</label>

<table class='table table-dark table-striped'>
<thread>
    <tr>
        <th scope="col">Infomation</th>
        <th scope="col">Description</th>
    </tr>
</thread>
    <thread>
    <tr>
        <th scope="row">Location</th>
        <td><?php echo $row["location_name"]; ?></td>
    </tr>
    </thread>

    <thread>
    <tr>
        <th scope="row">Meter Type</th>
        <td><?php echo $row["meter_type"]; ?></td>
    </tr>
    </thread>
    <thread>
    <tr>
        <th scope="row">Meter Model</th>
        <td><?php echo $row["meter_model"]; ?></td>
    </tr>
    </thread>
    <thread>

    <tr>
        <th scope="row">Meter Size</th>
        <td><?php echo $row["meter_size"]; ?></td>
    </tr>
    </thread>
    <thread>

    <tr>
        <th scope="row">Quantity</th>
        <td><?php echo $row["quantity"]; ?></td>
    </tr>
    </thread>
</table>
<hr class="border border-danger border-2 opacity-50">

<table class="table table-dark table-striped-columns">
    <thread>
    <tr>
    <th scope="col">No</th>
    <th scope="col">Serial Number</th>
    <th scope="col">Meter Status</th>
    <th scope="col">Meter Detail</th>
    </tr>
    </thread>

<?php
$sql2 = "SELECT serial_num, meter_status FROM meter WHERE batch_id=$batchid";
$result2 = mysqli_query($connection, $sql2);
$num=1;  
while ($row2 = mysqli_fetch_array($result2)) {
    echo '
    <thread>
    <tr>
        <th scope="row">' . $num . '</th>
        <td>' . $row2["serial_num"] . '</td>
        <td>' . $row2["meter_status"] . '</td>
        <td class="serial_num"><a href="meterInfo.php?serial_num=' .$row2["serial_num"]. '"><button class="btn btn-info btn-sm">Meter Detail</button></a></td>
    </tr></thread>';
    $num++;
}
?>
</table>

<br>
<div class="d-grid gap-2 col-6 mx-auto">
<button class="back btn btn-dark" type="button" onclick="window.location.href='mov_track_view.php'" title='Back To Meter Tracking'>Back</button>
</div>
<br>

</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>
