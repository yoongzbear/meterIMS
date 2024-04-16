<?php 
include 'secure_TestLab.php';
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

    <?php
        include('connection.php');
        $serial_num = $_POST['serial_num'];

        $sqlMeter = "SELECT * FROM meter WHERE serial_num = '$serial_num'";
        $resultMeter = mysqli_query($connection, $sqlMeter);
        $rowMeter = mysqli_fetch_assoc($resultMeter);

        $sqlDefect = "SELECT * FROM warranty_defect";
        $resultDefect = mysqli_query($connection, $sqlDefect);

        echo "<form id='meterForm' action='submitMeterTest.php' method='post'>
        <label for='serial_num'>Meter Serial Number:</label>
        <input type='text' name='serial_num' value='$serial_num' readonly>
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
            } else {
                defectLabel.style.display = 'block';
                defectSelect.style.display = 'block';
            }
        }
      </script>
</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>