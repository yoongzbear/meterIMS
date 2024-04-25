<?php
	//include('secure.php');
	include('connection.php');
?>

<head>
	<title>Meter Forecasting Form</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
<div class="content">
	<h3 class='header'>Meter Forcasting</h3>
	<form action="meterForecastDemand.php" method="post" name="upload_excel" enctype="multipart/form-data" class="form">
		<table>
			<tr>
				<td>Forecast Year</td>
				<td>
					<select name="year" id="year" required>
						<option value="" disabled selected>Select Year for Meter Forecast</option>
						<option value="2025">2025</option>
						<option value="2026">2026</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Data Set</td>
				<td><input type = "file" name = "dataset" id="file" accept=".csv" required></td>
			</tr>
			<tr>
				<td colspan="6" style="font-weight: normal;">
					Please ensure that your CSV file follows the correct format for inserting data set.
					Each row should represent a record for each month, and the columns must be organized as follows:
				</td>
			</tr>
			<tr class="example">
				<th>Month</th>
				<th>Year</th>
				<th>Faulty Program</th>
				<th>Meter Complaint</th>
				<th>Meter Leak</th>
				<th>Total</th>
			</tr>
			<tr class="example">
				<td>03</td>
				<td>2022</td>
				<td>8000</td>
				<td>1800</td>
				<td>18000</td>
				<td>27800</td>
			</tr>
			<tr class="example">
				<td>04</td>
				<td>2022</td>
				<td>12000</td>
				<td>19000</td>
				<td>16000</td>
				<td>29900</td>
			</tr>
			<tr class="example">
				<td>05</td>
				<td>2022</td>
				<td>11000</td>
				<td>1650</td>
				<td>17000</td>
				<td>29650</td>
			</tr>
			<tr>
				<td colspan="6">
					<a id="downloadLink" href="meterdemandsample.csv" download="SampleFile" onclick="downloadSampleTemplate()">Download our sample template for reference.</a>
				</td>
			</tr>
		</table>
		<button class="submit" name="upload" type="submit">Upload</button>
	</form>
</div>
<script>
    function downloadSampleTemplate() {
        var downloadLink = document.getElementById('downloadLink');
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
			alert("File Uploaded Successfully!");
        });
    });
</script>

</body>