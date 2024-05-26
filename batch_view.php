<?php
    include ('secure_Inv.php');
    include ('connection.php');

    $batchid = $_GET["Batch_ID"];
    $tracking_id =$_GET["tracking_id"];
    //get batch information
    $sql_In = "SELECT batch.*, movement.*, inbound.*, location.* FROM batch JOIN movement ON batch.batch_id = movement.batch_id JOIN inbound ON movement.inbound_id = inbound.inbound_id JOIN location ON inbound.location_id = location.location_id WHERE batch.batch_id = '$batchid' AND movement.tracking_id ='$tracking_id'";
    $result_In = mysqli_query($connection, $sql_In);
    $row_In = mysqli_fetch_array($result_In);

    $current_location = '';
    if ($row_In) {
        // Check if arrival_date is null
        if (is_null($row_In['arrival_date'])) {
            // Get the location name for the outbound_id
            $outbound_id = $row_In['outbound_id'];
            $sql_outbound_location = "SELECT location.location_name 
                                    FROM location 
                                    JOIN outbound ON outbound.location_id = location.location_id 
                                    WHERE outbound.outbound_id = $outbound_id";
            $result_outbound_location = mysqli_query($connection, $sql_outbound_location);
            
            if ($result_outbound_location && mysqli_num_rows($result_outbound_location) > 0) {
                $row_outbound_location = mysqli_fetch_assoc($result_outbound_location);
                $current_location = $row_outbound_location['location_name'];
            } else {
                $current_location = 'Location not found';
            }
        } else {
            // Use the location name for the inbound_id
            $current_location = $row_In['location_name'];
        }
    }
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
    <center>
    <label class="fs-2 font-monospace mb-4"><b>The Information About The Batch ID : </b><?php echo $batchid; ?></label>
    <div id='qrcode'>
        <script src = 'qrcode.js'></script>
        <script src = 'qrGeneratorBatch.js'></script>
        <script>makeCode(); </script>
    </div>
    </center>
    <br>
    <table class='table table-dark table-striped'>
        <tr>
            <th scope="col">Infomation</th>
            <th scope="col">Description</th>
        </tr>
        <tr>
            <th scope="row">Location</th>
            <td><?php echo $current_location; ?></td>
        </tr>
        <tr>
            <th scope="row">Meter Type</th>
            <td><?php echo $row_In["meter_type"]; ?></td>
        </tr>
        <tr>
            <th scope="row">Meter Model</th>
            <td><?php echo $row_In["meter_model"]; ?></td>
        </tr>
        <tr>
            <th scope="row">Meter Size</th>
            <td><?php echo $row_In["meter_size"]; ?></td>
        </tr>
        <tr>
            <th scope="row">Quantity</th>
            <td><?php echo $row_In["quantity"]; ?></td>
        </tr>
    </table>
    <hr class="border border-danger border-2 opacity-50">

    <?php
        //get meter information
        $sql2 = "SELECT serial_num, meter_status FROM meter JOIN batch ON meter.batch_id = batch.batch_id WHERE batch.batch_id = $batchid AND batch.quantity != 0";
        $result2 = mysqli_query($connection, $sql2);

        //Check if there are any records returned
        if (mysqli_num_rows($result2) > 0) {
    ?>
            <table class="table table-dark table-striped-columns">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Meter Status</th>
                        <th scope="col">Meter Detail</th>
                    </tr>
                </thead>

                <?php
                $num = 1;
                while ($row2 = mysqli_fetch_array($result2)) {
                    echo '<tbody>
                        <tr>
                            <th scope="row">' . $num . '</th>
                            <td>' . $row2["serial_num"] . '</td>
                            <td>' . $row2["meter_status"] . '</td>
                            <td class="serial_num"> <a href="meterInfo.php?Meter_ID=' . $row2["serial_num"] . '&tracking_id=' . $tracking_id . '"><button class="btn btn-info btn-sm">Meter Detail</button></a></td>
                        </tr>
                    </tbody>';
                    $num++;
                }
            echo '</table>';
        } ?>

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
