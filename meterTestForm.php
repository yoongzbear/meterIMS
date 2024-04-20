<?php include 'secure_TestLab.php'; ?>

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

    <?php
        include('connection.php');
        $serial_num = $_POST['serial_num'];

        //sql to see if already has a failed result - cannot be tested anymore - if fail, cannot see form
        $sqlLab = "SELECT * FROM lab_result WHERE serial_num = '$serial_num' AND result = 'FAIL'";
        $resultLab = mysqli_query($connection, $sqlLab);
        if (mysqli_num_rows($resultLab) > 0) {
            echo "<script>alert('Meter has failed the test before, cannot be tested again.');
            window.location.href='meterTest.php';
            </script>";
        }

        $sqlMeter = "SELECT * FROM meter INNER JOIN batch ON meter.batch_id = batch.batch_id INNER JOIN manufacturer ON meter.manu_id = manufacturer.manu_id INNER JOIN location ON batch.location_id = location.location_id WHERE serial_num = '$serial_num'";
        $resultMeter = mysqli_query($connection, $sqlMeter);
        $rowMeter = mysqli_fetch_assoc($resultMeter);

        $sqlDefect = "SELECT * FROM warranty_defect";
        $resultDefect = mysqli_query($connection, $sqlDefect);

        echo "<div class='col align-self-center'>
        <h2 class='fs-1 text-uppercase'>Meter Info</h2>
        <hr class='border border-success border-2 opacity-50'>";
        echo "<table class='table'><th colspan=2><h3>" . $rowMeter['serial_num'] . "</h3></th>
        
            <tr>
                <th>Type:</th>
                <td>" . $rowMeter['meter_type'] . "</td>
            </tr>
            <tr>
                <th>Model:</th>
                <td>" . $rowMeter['meter_model'] . "</td>
            </tr>
            <tr>
                <th>Size:</th>
                <td>" . $rowMeter['meter_size'] . "</td>
            </tr>
            <tr>
                <th>Age:</th>
                <td>" . $rowMeter['age'] . "</td>
            </tr>
            <tr>
                <th>Mileage:</th>
                <td>" . $rowMeter['mileage'] . "</td>
            </tr>
            <tr>
                <th>Manufacture Year:</th>
                <td>" . $rowMeter['manufactured_year'] . "</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>" . $rowMeter['meter_status'] . "</td>
            </tr>
            <tr>
                <th>Region Store:</th>
                <td>" . $rowMeter['location_name'] . "</td>
            </tr></table>
            ";

        echo "<form id='meterForm' action='submitMeterTest.php' method='post'>        
        <input type='hidden' name='serial_num' value='$serial_num' readonly>
        <br>
        <label for='testResult'>Test Result:</label>
        <select id='testResult' name='testResult' required onchange='toggleDefectField()'> <!-- Added onchange event -->
            <option value=''>Select Result</option>
            <option value='PASS'>PASS</option>
            <option value='FAIL'>FAIL</option>
        </select>
        <br>
        <label for='defect' id='defectLabel' style='display:none;'>Defect:</label> <!-- Hidden by default -->
        <select id='defect' name='defect' style='display:none;'> <!-- Hidden by default -->
            <option value=''>Select Defect</option>";
                while ($rowDefect = mysqli_fetch_assoc($resultDefect)) {
                    echo "<option value='" . $rowDefect['defect_id'] . "'>" . $rowDefect['defect'] . "</option>";
                }
            echo "<option value='0'>NOT LISTED</option>
        </select>
        <br>
        <input type='submit' value='Submit'>
    </form>";
    ?>
    <script>
        function toggleDefectField() {
            var testResult = document.getElementById('testResult').value;
            var defectLabel = document.getElementById('defectLabel');
            var defectSelect = document.getElementById('defect');
            if (testResult === 'PASS') {
                defectLabel.style.display = 'none';
                defectSelect.style.display = 'none';
                defectSelect.required = false;
            } else {
                defectLabel.style.display = 'block';
                defectSelect.style.display = 'block';
                defectSelect.required = true;
            }
        }
      </script>
</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>