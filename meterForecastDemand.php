<?php
	//include('secure.php');
	//include('connection.php');
	
	if (isset($_POST["upload"])) {
		$year = $_POST["year"];
		$folderDirectory = "dataset/";
		$targetFile = $folderDirectory . "meterdemand.csv";
		
		//Check if file already exists and delete it
		if (file_exists($targetFile)) {
			unlink($targetFile);
		}
		
		if (move_uploaded_file($_FILES["dataset"]["tmp_name"], $targetFile)) {
            $output = exec("python demandForecasting.py $year");
			
			//Split the values two three categories
			$split = explode(",", $output);
			$faulty_program = array_slice($split, 0, 12);
			$meter_complaints = array_slice($split, 12, 23);
			$meter_leaks = array_slice($split, 24, 35);
		} else {
			echo "Sorry, there was an error uploading your file.";
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
		<li class="breadcrumb-item"><a href="inv_QRmenu.php" title='QRcode Page'>QRcode</a></li>
		<li class="breadcrumb-item active" aria-current="page">Receive Meter</li>

	</ol>
</nav>

<body>
	<table>
		<tr>
			<th>Month</th>
			<th>Faulty Program</th>
			<th>Meter Complaint</th>
			<th>Meter Leaks</th>
			<th>Total Meter Demand</th>
		</tr>
		
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
	</table>
</body>
</html>