<?php
include ('secure_Inv.php');
include ('connection.php');

$batchid = $_GET["batch_id"];
$sql = "SELECT batch.*, region_store.* FROM batch
        JOIN region_store ON batch.store_id = region_store.store_id
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

<label>The information about the batch ID :</label> <?php echo $batchid; ?><br><br>
<button class="back" onclick="window.location='mov_track_view.php'">Back</button>
<table>
    <tr>
        <th>Infomation</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>Store</td>
        <td><?php echo $row["region"]; ?></td>
    </tr>
    <tr>
        <td>Meter Type</td>
        <td><?php echo $row["meter_type"]; ?></td>
    </tr>
    <tr>
        <td>Meter Model</td>
        <td><?php echo $row["meter_model"]; ?></td>
    </tr>
    <tr>
        <td>Meter Size</td>
        <td><?php echo $row["meter_size"]; ?></td>
    </tr>
    <tr>
        <td>Quantity</td>
        <td><?php echo $row["quantity"]; ?></td>
    </tr>
</table>

<table>
    <tr>
    <th>No</th>
    <th>Serial Number</th>
    <th>Meter Status</th>
    <th>Meter Detail</th>
    </tr>

<?php
$sql2 = "SELECT serial_num, meter_status FROM meter WHERE batch_id=$batchid";
$result2 = mysqli_query($connection, $sql2);
$num=1;  
while ($row2 = mysqli_fetch_array($result2)) {
    echo '
    <tr>
        <td>' . $num . '</td>
        <td>' . $row2["serial_num"] . '</td>
        <td>' . $row2["meter_status"] . '</td>
        <td class="serial_num"><a href="meterInfo.php?serial_num=' .$row2["serial_num"]. '"><button>Meter Detail</button></a></td>
    </tr>';
    $num++;
}
?>
</table>

</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>