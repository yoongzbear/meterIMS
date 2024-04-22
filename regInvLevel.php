<?php
    include 'secure_Reg.php';
    include 'connection.php';
    $locationquery = "SELECT location_id, location_name FROM location WHERE username = '$_SESSION[username]'";
    $result = mysqli_query($connection, $locationquery);
    $locationarray = mysqli_fetch_array($result);
    $location = $locationarray['location_name'];
    $locationid = $locationarray['location_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regional Store Inventory Level</title>
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
        <li class="breadcrumb-item active" aria-current="page">Home</li>
        <li class="breadcrumb-item active" aria-current="page">View Inventory Level</li>
    </ol>
    </nav>
    <section id="InvTable">
        <div id="container" style="width:50%; margin:auto;">
        <div class="col-lg-12 mt-4 text-center">
            <h2>Regional Store Inventory Level</h2>
            <h3 class="mt-4">Location: <?php echo $location; ?></h3>
        </div>
        <div class="col-lg-12 mt-4 text-center">
            <table class="table table-bordered">
                <tr>
                    <th>Meter Size (mm)</th>
                    <th>Quantity</th>
                </tr>
                <?php
                    $batchmetersizes = [15,20,25,40,50,80,100,150];
                    foreach($batchmetersizes as $size) {
                        $unusablemeter = 0;
                        $batchquery = "SELECT batch_id FROM batch WHERE location_id = '$locationid' AND meter_size = '$size'";
                        $batchresult = mysqli_query($connection, $batchquery);
                        $batch = mysqli_fetch_all($batchresult, MYSQLI_ASSOC);
                        $metersizeresult = mysqli_query($connection,"SELECT SUM(quantity) FROM batch WHERE location_id = '$locationid' AND meter_size = '$size'");
                        $metersize = mysqli_fetch_array($metersizeresult);
                        $totalmeters = $metersize['SUM(quantity)'];
                        foreach ($batch as $batchid) {
                            $batchid = $batchid['batch_id'];
                            $meterquery = "SELECT COUNT(serial_num) FROM meter WHERE batch_id = '$batchid' AND meter_status != 'IN STORE'";
                            $meterresult = mysqli_query($connection, $meterquery);
                            $meterquantity = mysqli_fetch_array($meterresult);
                            $unusablemeter += $meterquantity['COUNT(serial_num)'];
                        }
                        $usablemeters = $totalmeters - $unusablemeter;
                        echo "<tr>
                                <td>$size</td>
                                <td id='$size'>$usablemeters</td>
                            </tr>";
                    }
                ?>
            </table>
            <details>
            <summary><strong>Legend</strong></summary>
            <p class="mt-1">Quantities marked in red needs replenishing.</p>
            </details>
        </div>
        </div>
    </section>
    <footer>
        <?php 
            include 'footer.php'; 
        ?>
    </footer>
    <script>
            const minStock = [38066,72,75,36,50,27,52,35];
            const size = [15,20,25,40,50,80,100,150];
            for(let i=0; i<size.length; i++){
                if(document.getElementById(size[i]).innerText < (minStock[i]*0.2)){
                    document.getElementById(size[i]).style.backgroundColor = "lightcoral";
                    document.getElementById(size[i]).style.color = "white";
                }
            }
    </script>
</body>

</html>