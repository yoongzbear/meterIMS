<?php
include 'secure_TestLab.php';
?>

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
?>

</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="lab_home.php" title='Home Page - Test Lab'>Home</a></li>
    <li class="breadcrumb-item"><a href="TestLab_QRmenu.php" title='Meter Test Page'>Meter Test</a></li>
    <li class="breadcrumb-item"><a href="labMeterResult.php" title='Scan QR Page'>Scan QR - View Meter Result</a></li>
    <li class="breadcrumb-item"><a href="labViewMeterResult.php" title='View Meter Result Page'>View Meter Result</a></li>
    <li class="breadcrumb-item active" aria-current="page">Meter Result Detail</li>
  </ol>
</nav>

<?php
include 'connection.php';

$test_id = $_GET['test_id'];
$sql = "SELECT * FROM lab_result LEFT JOIN warranty_defect on lab_result.defect_id = warranty_defect.defect_id WHERE lab_result.test_id = '$test_id';";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

echo "<div class='container col-xl-5'>
        <h2 class='fs-1 text-uppercase'>Meter Info</h2>
        <hr class='border border-success border-2 opacity-50'>";
        echo "<table class='table mb-4'><th colspan=2><h3>" . $row['serial_num'] . "</h3></th>
        
            <tr>
                <th>Receive Date:</th>
                <td>" . $row['receive_date'] . "</td>
            </tr>
            <tr>
                <th>Test Date:</th>";
                if ($row['test_date'] == NULL) {
                    echo "<td>N/A</td>";
                } else {
                    echo "<td>" . $row['test_date'] . "</td>";
                }
            echo "</tr>
            <tr>
                <th>Result:</th>";
                if ($row['result'] == 'PASS') {
                    echo "<td style='color: green;'>" . $row['result'] . "</td>";
                } else if ($row['result'] == 'FAIL') {
                    echo "<td style='color: red;'>" . $row['result'] . "</td>";
                } else {
                    echo "<td>NOT TESTED</td>";
                }
            echo "</tr>
            ";
        if ($row['result'] == 'FAIL') {
            echo "<tr>
                <th>Defect: </th>";
            if ($row['defect_id'] != NULL) {
                echo "<td>" . $row['defect'] . "</td></tr>";
            } else {
                echo "<td>NOT LISTED</td></tr>";
            }
        }
        echo "</table></div>";
?>

<div class="d-grid col-6 mx-auto mb-4">
<button class="back btn btn-dark" type="button" onclick="window.location.href='invViewMeterResult.php?serial_num=<?php echo $row['serial_num'];?>'" title='Back To View Meter Result'>Back</button>
</div>

<footer>
	<?php include 'footer.php';?>
</footer>

</body>
</html>