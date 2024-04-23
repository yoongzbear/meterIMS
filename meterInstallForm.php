<?php 
include 'secure_Con.php';
include 'connection.php';
if(ISSET($_POST['serial_num'])){
    $serial_num = $_POST['serial_num'];
    try{
        $sqlMeter = "SELECT * FROM meter INNER JOIN batch ON meter.batch_id = batch.batch_id INNER JOIN location ON batch.location_id = location.location_id WHERE serial_num = '$serial_num';";
        $resultMeter = mysqli_query($connection, $sqlMeter);
        $rowMeter = mysqli_fetch_assoc($resultMeter);
        if (mysqli_num_rows($resultMeter) == 0) {
            throw new Exception();
        }
        if ($rowMeter['meter_status'] == 'INSTALLED') {
            echo "<script>alert('Meter is already installed! You are not allowed to fill in the form for an installed meter.');
            window.location.href='meterInstall.php';
            </script>";
            exit();
        }
}
    catch(Exception $e){
        echo "<script>alert('Error: Invalid Serial Number. Please try again.');
        window.location.href='meterInstall.php';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Installation Form</title>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<header>
<?php 
include 'header.php';
?>

</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="con_home.php" title='Home Page - Contractor'>Home</a></li>
    <li class="breadcrumb-item"><a href="con_QRmenu.php" title='Meter Installation Page'>Meter Installation</a></li>
    <li class="breadcrumb-item"><a href="meterInstall.php" title='Scan QR Page'>Scan QR - Meter Installation</a></li>
    <li class="breadcrumb-item active" aria-current="page">Meter Install Form</li>

  </ol>
</nav>

<div class='col align-self-center'>

<h2 class='fs-1 text-uppercase'>Meter Info</h2>
<hr class='border border-success border-2 opacity-50'>
<table class='table mb-4'><th colspan=2><h3><?php echo $rowMeter['serial_num'];?></h3></th>
    <tr>
        <th>Type:</th>
        <td><?php echo $rowMeter['meter_type'];?></td>
    </tr>
    <tr>
        <th>Model:</th>
        <td><?php echo $rowMeter['meter_model'];?></td>
    </tr>
    <tr>
        <th>Size:</th>
        <td><?php echo $rowMeter['meter_size'];?></td>
        </tr>
        <tr>
            <th>Age:</th>
            <td><?php echo $rowMeter['age'];?></td>
        </tr>
        <tr>
            <th>Mileage:</th>
            <td><?php echo $rowMeter['mileage'];?></td>
        </tr>                
        <tr>
            <th>Manufacture Year:</th>
            <td><?php echo $rowMeter['manufactured_year'];?></td>
        </tr>
        <tr>
            <th>Region Store:</th>
            <td><?php echo $rowMeter['location_name'];?></td>
        </tr></table>
        <form id='meterForm' action='submitMeterInstallation.php' method='post'>    
            <input type='hidden' id='serial_num' name='serial_num' value='$serial_num'>                
            <label for='installDate'>Installation Date : </label>
            <input type='date' class='form-control mb-4'id='installDate' name='installDate' required>
            <label for='installAdd'>Installation Address : </label>
            <input type='text' class='form-control mb-4' id='installAdd' name='installAdd' required>
            <input type='submit' style='width:20%;' class='btn btn-primary mb-4' value='Submit'>
        </form>
</div>

<footer>
	<?php include 'footer.php';?>
</footer>

</body>

</html>