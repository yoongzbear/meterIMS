<?php
//print list of past meter tests
//maybe like summary - date tested, result
//serial number, meter info
//received date, tested date, result, if fail show defect

        include ('secure_TestLab.php');
        include('connection.php');
        //for testing purpose, serial num: AIS17BA0000001, AIS17BA0000003
        $serial_num = $_GET['serial_num'];
        $sql = "SELECT * FROM meter INNER JOIN batch ON meter.batch_id = batch.batch_id INNER JOIN manufacturer ON meter.manu_id = manufacturer.manu_id WHERE serial_num = '$serial_num'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);

        //sql to get the test results
        $sqlTest = "SELECT * FROM lab_result WHERE serial_num = '$serial_num';";
        $resultTest = mysqli_query($connection, $sqlTest);        

        $num = 1;
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
include 'navLab.php';
?>

</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <!--kena change this for test lab
    <li class="breadcrumb-item"><a href="inv_mag_home.php" title='Home Page - Inventory Management Department'>Home</a></li>
    <li class="breadcrumb-item"><a href="mov_track_view.php" title='Meter Tracking Page'>Meter Tracking</a></li>
    <li class="breadcrumb-item "><a href="batch_view.php?batch_id=<?= $batch_id; ?>" title='Batch Detail Page'>Batch Detail</a></li>
    <li class="breadcrumb-item active" aria-current="page">Meter Info</li>-->
  </ol>
</nav>

<div class="col align-self-center">

    <?php
        //type, model, size, age, mileage, manufacturer, manu year, status, install date, install address, location of store
        echo "<div class='col align-self-center'>
        <h2 class='fs-1 text-uppercase'>Meter Info</h2>
        <hr class='border border-success border-2 opacity-50'>";
        echo "<table class='table'><th colspan=2><h3>" . $row['serial_num'] . "</h3></th>
        
            <tr>
                <th>Type:</th>
                <td>" . $row['meter_type'] . "</td>
            </tr>
            <tr>
                <th>Model:</th>
                <td>" . $row['meter_model'] . "</td>
            </tr>
            <tr>
                <th>Size:</th>
                <td>" . $row['meter_size'] . "</td>
            </tr>
            <tr>
                <th>Age:</th>
                <td>" . $row['age'] . "</td>
            </tr>
            <tr>
                <th>Mileage:</th>
                <td>" . $row['mileage'] . "</td>
            </tr>
            <tr>
                <th>Manufacturer:</th>
                <td>" . $row['manu_name'] . "</td>
            </tr>
            <tr>
                <th>Manufacture Year:</th>
                <td>" . $row['manufactured_year'] . "</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>" . $row['meter_status'] . "</td>
            </tr>
            ";
        echo "</table></div>";
        ?>

        <table>
            <tr><th>No</th>
            <th>Date Tested</th>
            <th>Result</th></tr>
            <th>Result Detail</th>
        <?php
        
        while($rowTest = mysqli_fetch_array($resultTest)) {
            echo '<tr>
                <td>'.$num.'</td>
                <td>'.$rowTest['receive_date'].'</td>';
            //can color the font of the result? if not tested yet = grey, if pass = green, if fail = red
            if ($rowTest['result'] == NULL) {
                echo '<td>Not tested yet</td>';
            } else {
                echo '<td>'.$rowTest['result'].'</td>';            
            }
            echo '
            <td class="serial_num"><a href="resultDetail.php?test_id=' .$rowTest["test_id"]. '"><button class="btn btn-info btn-sm">Detail</button></a></td></tr>';
            $num++;
        }
        echo "</table>";
    ?>

    
<br>

</div>

</body>
</html>