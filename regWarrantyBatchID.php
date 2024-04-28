<?php
include 'secure_Reg.php';
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warranty Batch ID Printing</title>
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
        <li class="breadcrumb-item"><a href="reg_home.php" title='Home Page - Region Store'>Home</a></li>
        <li class="breadcrumb-item"><a href="reg_QRmenu.php" title='Scan QRcode Page'>Scan QRcode</a></li>
        <li class="breadcrumb-item"><a href="regWarrantyUpdate.php" title='Warranty Update Page'>Warranty Update</a></li>
        <li class="breadcrumb-item active" aria-current="page">Batch QR</li>
    </ol>
</nav>

<div class="my-4 text-center">
    <h3>Batch QR:</h3>
<div id="qrcode">
<script src="qrcode.js"></script>
<script src="qrGeneratorBatch.js"></script>
<script>
    makeCode();
    print();
</script>
</div>

</div>

<footer>
	<?php include 'footer.php';?>
</footer>	

</body>

</html>