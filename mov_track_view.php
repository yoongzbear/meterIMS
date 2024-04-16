<?php
include 'secure_Inv.php';
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTTO Aqua</title>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<header>

<?php 
include 'header.php';
include 'navInv.php';
?>

</header>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="inv_mag_home.php" title='Home Page - Inventory Management Department'>Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Meter Tracking</li>
  </ol>
</nav>



<label for="searchbar">Search for:</label>
<!-- Dropdown list for search options -->
<select id="searchOptions" onchange="enableSearch()">
    <!-- Placeholder option -->
    <option value="" disabled selected>Please select</option>
    <!-- Options for search criteria -->
    <option value="batch">Batch</option>
    <option value="origin">Origin</option>
    <option value="destination">Destination</option>
    <option value="shipOutDate">Ship Out Date</option>
    <option value="arrivalDate">Arrival Date</option>
    <option value="status">Status</option>
</select>
<!-- Input field for user's search query -->
<input type="search" onkeyup="search_trac()" id="searchbar" name="search" placeholder="Search..." disabled>

<script>

    // Function to enable/disable search input based on dropdown selection
    function enableSearch() {
        let dropdown = document.getElementById('searchOptions');
        let input = document.getElementById('searchbar');

       
        if (dropdown.value !== "") {
            input.disabled = false;
            input.focus(); // Set focus to the input field for user convenience
        } else {
            input.disabled = true;
        }
    }

    // Function to perform search based on user input
    function search_trac() {
        let input = document.getElementById('searchbar').value.toLowerCase();
        let option = document.getElementById('searchOptions').value;

        // Get all table rows
        let rows = document.querySelectorAll('.track');

        // Loop through each table row
        rows.forEach(row => {
            let cellText = '';
            // Check if a valid option is selected from dropdown
            if(option !== '') {
                // If yes, find the text content of the cell in the corresponding column
                cellText = row.querySelector('td:nth-child(' + (getColumnIndex(option) + 1) + ')');
                if(cellText){
                    cellText = cellText.innerText.toLowerCase(); // Convert to lowercase for case-insensitive matching
                }
            }
            // Determine whether to display or hide the row based on search criteria
            let display = (option === '' || (cellText && cellText.includes(input))) ? '' : 'none';
            row.style.display = display;
        });
    }

    // Function to map dropdown option to corresponding table column index
    function getColumnIndex(option) {
        switch(option) {
            case 'batch':
                return 1;
            case 'origin':
                return 2;
            case 'destination':
                return 3;
            case 'shipOutDate':
                return 4; 
            case 'arrivalDate':
                return 5; 
            case 'status':
                return 6; 
            default:
                return 1; 
        }
    }
</script>




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

</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>

