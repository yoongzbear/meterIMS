<?php
//include ('secure.php');
include ('connection.php');
?>

<!--the search bar-->
<form action="mov_track.php">
  <input type="search" onkeyup="search_trac()" id="searchbar" name="search" placeholder="Search...">
  <input type="submit" value="Search">

<div>
    <table id="list">
        <tr>
            <th>No</th>
            <th>Batch ID</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>Date Ship Out</th>
            <th>Date Arrived</th>
        </tr>

        <?php
        $sql = "SELECT * FROM movement";
        $result = mysqli_query($connection, $sql);
        $num = 1;

        while ($row = mysqli_fetch_array($result)) {
            $batch_id = $row["batch_id"];
            $origin = $row["origin"];
            $destination = $row["destination"];

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
                <td class="batchID"><a href="batch_view.php?batch_id=' . $batch_id . '">' . $batch_id . '</a></td>
                <td>' . $origin_region . '</td>
                <td>' . $destination_region . '</td>
                <td>' . $row["ship_date"] . '</td>
                <td>' . $row["arrival_date"] . '</td>
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

</form>
