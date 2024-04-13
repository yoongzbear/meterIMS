<?php 
include 'secure_Con.php';
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
include 'navCon.php';
?>

</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="con_home.php" title='Home Page - Contractor'>Home</a></li>
    <li class="breadcrumb-item"><a href="con_QRmenu.php" title='Meter Installation Page'>Meter Installation</a></li>
    <li class="breadcrumb-item active" aria-current="page">Meter Install Form</li>

  </ol>
</nav>

    <?php
        include('connection.php');
        $serial_num = $_POST['serial_num'];

        $sqlMeter = "SELECT * FROM meter WHERE serial_num = '$serial_num'";
        $resultMeter = mysqli_query($connection, $sqlMeter);
        $rowMeter = mysqli_fetch_assoc($resultMeter);
        if ($rowMeter['meter_status'] == 'INSTALLED') {
            echo "<script>alert('Meter is already installed! You are not allowed to fill in the form for an installed meter.');
            window.location.href='meterInstall.php';
            </script>";
            exit();
        } else {
            echo $serial_num;
            echo "<form id='meterForm' action='submitMeterInstallation.php' method='post'>
                    <label for='serial_num'>Meter Serial Number:</label>
                    <input type='text' name='serial_num' value='$serial_num' readonly>
                    <br>
                    <label for='installDate'>Installation Date:</label>
                    <input type='date' id='installDate' name='installDate'>
                    <br>
                    <label for='installAdd'>Installation Address:</label>
                    <input type='text' id='installAdd' name='installAdd'>
                    <br>
                    <input type='submit' value='Submit'>
                </form>
            ";
        }
    ?>

</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>