<?php
include 'connection.php';
include 'secure_Inv.php';
if(ISSET($_GET['serial_num'])){
    $serial_num = $_GET['serial_num'];
    try{
        $sql = "SELECT * FROM meter LEFT JOIN batch ON meter.batch_id = batch.batch_id INNER JOIN manufacturer ON meter.manu_id = manufacturer.manu_id WHERE serial_num = '$serial_num'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) == 0) {
            throw new Exception();
        }

        //sql to get the test results
        $sqlTest = "SELECT * FROM lab_result WHERE serial_num = '$serial_num';";
        $resultTest = mysqli_query($connection, $sqlTest);        
        
        $num = 1;
    }
    catch(Exception $e){
        echo "<script>alert('Error: Invalid Serial Number. Please try again.');
        window.location.href='invMeterResult.php';
        </script>";
        exit();
    }
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Result</title>
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
    <li class="breadcrumb-item"><a href="inv_QRmenu.php" title='QRcode Page'>QRcode</a></li>
    <li class="breadcrumb-item"><a href="invMeterResult.php" title='QRcode Page'>Scan QR - View Meter Result</a></li>
    <li class="breadcrumb-item active" aria-current="page">View Meter Result</li>

  </ol>
</nav>


<div class="col align-self-center" style='width:50%;'>
        <h2 class='fs-1 text-uppercase'>Meter Info</h2>
        <hr class='border border-success border-2 opacity-50'>
        <table class='table mb-4'><th colspan=2><h3><?php echo $row['serial_num'];?></h3></th>
            <tr>
                <th>Type:</th>
                <td><?php echo $row['meter_type'];?></td>
            </tr>
            <tr>
                <th>Model:</th>
                <td><?php echo $row['meter_model'];?></td>
            </tr>
            <tr>
                <th>Size:</th>
                <td><?php echo $row['meter_size'];?></td>
            </tr>
            <tr>
                <th>Age:</th>
                <td><?php echo $row['age'];?></td>
            </tr>
            <tr>
                <th>Mileage:</th>
                <td><?php echo $row['mileage'];?></td>
            </tr>
            <tr>
                <th>Manufacturer:</th>
                <td><?php echo $row['manu_name'];?></td>
            </tr>
            <tr>
                <th>Manufacture Year:</th>
                <td><?php echo $row['manufactured_year'];?></td>
            </tr>
            <tr>
                <th>Status:</th>
                <td><?php echo $row['meter_status'];?></td>
            </tr>
        </table>
<hr>
<h3>Test Results</h3>

        <table class="table mb-4">
            <tr><th>No</th>
            <th>Test Date</th>
            <th>Result</th>
            <th>Result Detail</th></tr>
        <?php
        
        while($rowTest = mysqli_fetch_array($resultTest)) {
            echo '<tr>
                <th>'.$num.'</th>';
            if ($rowTest['result'] == NULL) {
                echo '<td>N/A</td>
                <td>NOT TESTED</td>';
            } else {
                echo '<td>'.$rowTest['test_date'].'</td>';            
                if ($rowTest['result'] == 'PASS') {
                    echo "<td style='color: green;'>" . $rowTest['result'] . "</td>";
                } else if ($rowTest['result'] == 'FAIL') {
                    echo "<td style='color: red;'>" . $rowTest['result'] . "</td>";
                }
            }
            echo '<td class="serial_num"><a href="invResultDetail.php?test_id=' .$rowTest["test_id"]. '"><button class="btn btn-info btn-sm">Detail</button></a></td></tr>';
            $num++;
        }
        echo "</table>";
    ?>

<div class="d-grid gap-2 col-6 mx-auto mb-4">
<button class="back btn btn-dark" type="button" onclick="invViewMeterResult.php?serial_num=<?php echo $row['serial_num'];?>'" title='Back To Scan QR Page'>Back</button>
</div>

</div>

<footer>
	<?php include 'footer.php';?>
</footer>

</body>
</html>
