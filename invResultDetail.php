<?php
include 'secure_Inv.php';
include 'connection.php';

$test_id = $_GET['test_id'];
$sql = "SELECT * FROM lab_result LEFT JOIN warranty_defect on lab_result.defect_id = warranty_defect.defect_id WHERE lab_result.test_id = '$test_id';";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

echo "<div class='col align-self-center'>
        <h2 class='fs-1 text-uppercase'>Meter Info</h2>
        <hr class='border border-success border-2 opacity-50'>";
        echo "<table class='table'><th colspan=2><h3>" . $row['serial_num'] . "</h3></th>
        
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