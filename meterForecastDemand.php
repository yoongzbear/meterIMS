<?php
	include('secure_Inv.php');
	include('connection.php');
	$expectedHeaders = array('Month', 'Year', 'Faulty Program', 'Meter Complaint', 'Meter Leak', 'Total');
	
	function isValidCsvFormat($filePath) {
		global $expectedHeaders; //Access the global $expectedHeaders variable
		$file = fopen($filePath, 'r');
		if (!$file) {
			return false;
		}

		global $headers; //Define $headers as a global variable
		$headers = fgetcsv($file);
		$headers[0] = preg_replace('/\x{FEFF}/u', '', $headers[0]);
		if (count($headers) !== count($expectedHeaders) || array_diff($headers,$expectedHeaders)) {
			return false;
		}
				
		$numRows = 1; //Initialize the row counter
		while (($row = fgetcsv($file)) !== false) {
			if (count($row) !== count($expectedHeaders) || !is_numeric($row[0]) || !is_numeric($row[1]) || !is_numeric($row[2]) || !is_numeric($row[3]) || !is_numeric($row[4]) || !is_numeric($row[5])) {
				fclose($file);
				return false;
			}
			$numRows++; 
		}

		fclose($file);

		// Check if the number of rows is at least 12 rows
		return $numRows >= 12;
	}
	
	if (isset($_POST["upload"])) {
		$year = $_POST["year"];
		$folderDirectory = "dataset/";
		$targetFile = $folderDirectory . "meterdemand.csv";
		
		//Check if file already exists and delete it
		if (file_exists($targetFile)) {
			unlink($targetFile);
		}
		
		if (move_uploaded_file($_FILES["dataset"]["tmp_name"], $targetFile)) {
			if (!isValidCsvFormat($targetFile)) {
				echo "<script>alert('Please follow the dataset format as the sample template given.');</script>";
				echo "<script>window.location.href='meterForecastDemandForm.php';</script>";
				exit();
			}else{
				$output = exec("python demandForecasting.py $year");
				
				//Split the values to three categories
				$split = explode(",", $output);
				$faulty_program = array_slice($split, 0, 12);
				$meter_complaints = array_slice($split, 12, 23);
				$meter_leaks = array_slice($split, 24, 35);
				echo "<script>alert('File Uploaded Successfully!');</script>";
			}
		} else {
			echo "<script>alert('Sorry, there was an error uploading your file. Please try again.');</script>";
			echo "<script>window.location.href='meterForecastDemandForm.php';</script>";
			exit();
		}
	}
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
			<li class="breadcrumb-item"><a href="meterForecastDemandForm.php" title='Meter Forecast Page'>Meter Forecast</a></li>
			<li class="breadcrumb-item active" aria-current="page">Meter Forecast (Uploaded)</li>
		</ol>
	</nav>

	<div class="container-fluid mb-4">
		<h3>Meter Forecast Demand for <?php echo $year; ?></h3>
		<table class="table table-bordered border-dark">
			<thead>
			<tr>
				<th>Month</th>
				<th>Faulty Program</th>
				<th>Meter Complaint</th>
				<th>Meter Leaks</th>
				<th>Total Meter Demand</th>
			</tr>
			</thead>
			
			<tbody>
			<?php
				for($i=1;$i<=12;$i++){
					//Show Months Name
					echo "<tr>
							<td>";
									echo date('F', mktime(0,0,0,$i,1));
					echo		"</td>
					
								<td>";
									echo intval($faulty_program[$i-1]);
					echo		"</td>
								
								<td>";
									echo intval($meter_complaints[$i-1]);
					echo		"</td>
								
								<td>";
									echo intval($meter_leaks[$i-1]);
					echo		"</td>
								
								<td>";
									$total = $faulty_program[$i-1]+$meter_complaints[$i-1]+$meter_leaks[$i-1];
									echo $total;
					echo		"</td>
						</tr>";
				}
			?>
			</tbody>
		</table>
	</div>

	<div class="d-grid col-6 mx-auto mb-4">
		<button class="back btn btn-dark" type="button" onclick="window.location.href='meterForecastDemandForm.php'" title='Back To Scan QR'>Back</button>
	</div>

	<footer>
		<?php include "footer.php"?>
	</footer>

</body>
</html>