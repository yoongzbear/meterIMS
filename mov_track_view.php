<?php
//include ('secure.php');
include ('connection.php');
?>

<!--the search bar-->
<label>Search for the any keyword:</lable>
<input type="search" onkeyup="search_trac()" id="searchbar" name="search" placeholder="Search...">

<div>
    <table id="list">
        <tr>
            <th>No</th>
            <th>Batch ID</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>Date Ship Out</th>
            <th>Date Arrived</th>
            <th>Status</th>
            <th>Batch Detail</th>
        </tr>

        <?php
        $sql = "SELECT * FROM movement";
        $result = mysqli_query($connection, $sql);
        $num = 1;

        

        while ($row = mysqli_fetch_array($result)) {

            $batch_id = $row["batch_id"];
            $origin = $row["origin"];
            $destination = $row["destination"];
            $arrival_date = $row["arrival_date"];

            // Fetch region for origin
            $sql2 = "SELECT * FROM region_store WHERE store_id = '$origin'";
            $result2 = mysqli_query($connection, $sql2);
            $row2 = mysqli_fetch_array($result2);
            $origin_region = $row2 ? $row2["region"] : "";

            // Fetch region for destination
            $sql3 = "SELECT * FROM region_store WHERE store_id = '$destination'";
            $result3 = mysqli_query($connection, $sql3);
            $row3 = mysqli_fetch_array($result3);
            $destination_region = $row3 ? $row3["region"] : "";

            echo '
            <tr class="track">
                <td>' . $num . '</td>
                <td>' . $row["batch_id"] . '</td>
                <td>' . $origin_region . '</td>
                <td>' . $destination_region . '</td>
                <td>' . $row["ship_date"] . '</td>
                <td>' . $row["arrival_date"] . '</td>
                <td>';
                if ($arrival_date != '0000-00-00' && !is_null($arrival_date)) {
                    echo 'Arrived';
                } else {
                    echo 'In transit';
                }
                
                echo '</td>
            
                <td class="batchID"><a href="batch_view.php?batch_id=' . $batch_id . '"><button>Batch Detail</button></a></td>
            </tr>';
            $num++;
        }
        ?>

    </table>
</div>

<script>

    function search_trac() {
        let input = document.getElementById('searchbar').value.toLowerCase();
        let rows = document.querySelectorAll('.track');

        rows.forEach(row => {
            let display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
            row.style.display = display;
        });
    }
</script>


