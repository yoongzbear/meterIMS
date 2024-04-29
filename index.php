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
<?php include 'header.php';?>
</header>

<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <div class="col-md-3 mb-2 mb-md-0">
        <!--space for navigation bar-->
      </div>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="index.php" class="nav-link">Home</a></li>
        <li><a href="inv_mag_home.php" class="nav-link">Meter Track</a></li>
        <li><a href="inv_mag_home.php" class="nav-link">Meter Forecast</a></li>
        <li><a href="lab_home.php" class="nav-link">Meter Test</a></li>
      </ul>

		<div class="col-md-3 text-end">
        	<a href="login.php" class="btn btn-outline-primary">Log In</a>
		</div>
	</header>
</div>

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="Home">Home</li>
    <li class="breadcrumb-item active" aria-current="page"></li>
  </ol>
</nav>

<div class="video-container">
        <video autoplay loop muted>
            <source src="imgs/meter.mp4" type="video/mp4">
        </video>
        <div class="index-content">
            <p>Welcome to Otto Aqua!</p>
            <p>Water Meter-Inventory Management System of Air Selangor.</p>
        </div>
    </div>

</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>