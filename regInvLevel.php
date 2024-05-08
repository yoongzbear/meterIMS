<?php
    include 'secure_Reg.php';
    include 'connection.php';
    //get region store location of the user
    $locationquery = "SELECT location.location_id, location.location_name FROM location RIGHT JOIN useraccount ON useraccount.location_id = location.location_id WHERE username = '$_SESSION[username]'";
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
        <li class="breadcrumb-item"><a href="reg_home.php" title='Home Page - Region Store'>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Inventory Level</li>
    </ol>
    </nav>

    <section id="InvTable" class="mb-4">
        <div id="container" style="width:50%; margin:auto;">
        <div class="col-lg-12 mt-4 text-center">
            <h2 class="display-6">Regional Store Inventory Level</h2>
            <h3 class="mt-4">Location: <?php echo $location; ?></h3>
        </div>
        <div class="col-lg-12 mt-4 text-center">
            <table class="table table-bordered">
                <tr>
                    <th>Meter Size (mm)</th>
                    <th>Minimum Stock</th>
                    <th>Current Quantity</th>
                </tr>
                <?php
                    $batchmetersizes = [15,20,25,40,50,80,100,150]; //predefined meter sizes
                    $minstock = [38066,72,75,36,50,27,52,35]; //predefined minimum stock level for each size
                    $int = 0;
                    //calculate usable meters for each size, then print in table
                    foreach($batchmetersizes as $size) {
                        $meterquery =  "SELECT COUNT(meter.serial_num) AS totalmeters FROM meter JOIN batch ON meter.batch_id = batch.batch_id WHERE batch.meter_size = '$size' AND meter.location_id = '$locationid' AND meter.meter_status = 'IN STORE';";
                        $meterassoc = mysqli_fetch_assoc(mysqli_query($connection, $meterquery));
                        echo "<tr>
                                <td>$size</td>
                                <td>$minstock[$int]</td>
                                <td id='$size'>$meterassoc[totalmeters]</td>
                            </tr>";
                        $int++;
                    } ?>
            </table>
            <details>
            <summary><strong>Legend</strong></summary>
            <p class="mt-1">Quantities marked in red needs replenishing.</p>
            </details>
        </div>
        </div>
    </section>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
    <script>
        //highlight low stock meters
        const minStock = [38066,72,75,36,50,27,52,35];
        const size = [15,20,25,40,50,80,100,150];
        for(let i=0; i<size.length; i++){
            if(document.getElementById(size[i]).innerText < (minStock[i]*0.8)){
                document.getElementById(size[i]).style.backgroundColor = "lightcoral";
                document.getElementById(size[i]).style.color = "white";
            }
        }
    </script>
</body>
</html>