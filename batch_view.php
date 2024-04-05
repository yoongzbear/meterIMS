<?php
//include ('secure.php');
include ('connection.php');

$batchid = $_GET["batch_id"];
$sql = "SELECT batch.*, region_store.* FROM batch
        JOIN region_store ON batch.store_id = region_store.store_id
        WHERE batch.batch_id = $batchid";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);
?>


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

