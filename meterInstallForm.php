<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Installation Form</title>
</head>
<body>
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
</html>