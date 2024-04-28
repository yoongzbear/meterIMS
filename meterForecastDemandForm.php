<?php
	include('secure_Inv.php');
	include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Meter Forecasting Form</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
    <li class="breadcrumb-item active" aria-current="page">Meter Forecast</li>
  </ol>
</nav>
</head>

<div class="container-fluid mb-4">
	<h3 class="display-4 mb-4">Meter Forcasting</h3>
	<form action="meterForecastDemand.php" method="post" name="upload_excel" enctype="multipart/form-data" class="form">
		<div class="row mb-3">
			<label class="col-sm-2 col-form-label fw-bold">Forecast Year</label>
			<div class="col-sm-10">
				<select class="form-select" name="year" id="year" required>
					<option value="" disabled selected>Please Select Meter Forecast Year</option>
						<?php
						$currentYear = date('Y');

						//Loop to generate options for next 2 years
						for($i = $currentYear + 1; $i <= $currentYear + 2; $i++) {
							echo "<option value=\"$i\">$i</option>";
						}
						?>
				</select>
			</div>
		</div>
		
		<div class="row g-3 mb-4 align-items-center">
			<label class="col-sm-2 col-form-label fw-bold">Data Set</label>
		<div class="col-sm-10">
			<input type = "file" name = "dataset" id="file" accept=".csv" class="form-control" required>
		</div>
		</div>

		<table class="table mb-4 table-bordered border-dark">
			<p class="fst-italic caption-top">
				Please ensure that your CSV file follows the correct format for inserting data set. <br>
                Each row should represent a record for each month, and the columns must be organized as follows:			
			</p>
			<thead>
			<tr>
				<th>Month</th>
				<th>Year</th>
				<th>Faulty Program</th>
				<th>Meter Complaint</th>
				<th>Meter Leak</th>
				<th>Total</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>03</td>
				<td>2022</td>
				<td>8000</td>
				<td>1800</td>
				<td>18000</td>
				<td>27800</td>
			</tr>
			<tr>
				<td>04</td>
				<td>2022</td>
				<td>12000</td>
				<td>19000</td>
				<td>16000</td>
				<td>29900</td>
			</tr>
			<tr>
				<td>05</td>
				<td>2022</td>
				<td>11000</td>
				<td>1650</td>
				<td>17000</td>
				<td>29650</td>
			</tr>
			</tbody>
			<caption>
			<p class="text-danger">Note: Please include at least 12 rows of data for training.</p>		
			<a id="downloadLink" href="meterdemandsample.csv" download="SampleFile">Download our sample template for reference.</a></caption>
		</table>
		
		<button class="submit btn btn-primary" name="upload" type="submit">Upload</button>
	</form>

<script>
	function downloadSampleTemplate() {
        var downloadLink = document.createElement('a');
        downloadLink.href = 'meterdemandsample.csv';
        downloadLink.download = 'SampleFile';
        downloadLink.click();
    }

    function getExtension(filename) {
        var parts = filename.split('.');
        return parts[parts.length - 1];
    }

    function isCsv(filename) {
        var ext = getExtension(filename);
        return ext.toLowerCase() === 'csv';
    }

    $(function() {
        $('form').submit(function(event) {
            function failValidation(msg) {
                alert(msg);
                event.preventDefault(); // Prevent default form submission
                return false;
            }

            var file = $('#file').prop('files')[0];
            if (!file) {
                return failValidation('Please choose a file');
            }

            var filename = file.name;
            if (!isCsv(filename)) {
                return failValidation('Please select a valid CSV file');
            }
			
			var newFilename = 'meterdemand';
            file.name = newFilename;
			// Rename the file before submission
        });
    });
</script>

</div>

<footer>
    <?php include "footer.php"?>
</footer>

</body>
</html>
