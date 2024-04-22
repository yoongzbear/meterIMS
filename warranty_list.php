<?php
include ('secure_Reg.php');
include ('connection.php');
$locationID = $_SESSION['locationID'];
$sql = "SELECT warranty.*, meter.*, batch.* FROM warranty
        JOIN meter ON warranty.serial_num = meter.serial_num
        JOIN batch ON meter.batch_id = batch.batch_id
        WHERE warranty_status = 'CAN CLAIM' AND meter.location_id= $locationID";

$result = mysqli_query($connection, $sql);

$num = 1;
?>

<table>
    <tr>
        <th>No</th>
        <th>Meter Type</th>
        <th>Meter Size</th>
        <th>Meter Model</th>
        <th>Installation Address</th>
        <th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_array($result)) : ?>
        <tr>
            <td><?php echo $num++; ?></td>
            <td><?php echo $row["meter_type"]; ?></td>
            <td><?php echo $row["meter_size"]; ?></td>
            <td><?php echo $row["meter_model"]; ?></td>
            <td><?php echo $row["install_address"]; ?></td>
            <td><button onclick="window.location.href= 'store_replaceMeterScanQR.php?serial_num=<?php echo $row['serial_num']; ?>';">Install New Meter</button></td>
        </tr>
    <?php endwhile; ?>
</table>
