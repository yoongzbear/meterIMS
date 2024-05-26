<?php
include ('secure_TestLab.php'); 
$batch_id = $_GET['batch_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Movement</title>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head> 

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="lab_home.php" title='Home Page - Test Lab'>Home</a></li>
        <li class="breadcrumb-item"><a href="TestLab_QRmenu.php" title='QR Code Menu'>QR Code</a></li>
        <li class="breadcrumb-item"><a href="LabDep_Scan_to_Inv.php" title='Scan QR Page'>Scan QR - Send To Inventory Department</a></li>
        <li class="breadcrumb-item active" aria-current="page">Confirmation For Send To Inventory Department</li>
    </ol>
    </nav>

<div class="col align-self-center mb-4">
    <form method="post" action="Insert_lab_to_inv_mov_process.php">
        <h2 class="font-monospace mb-4">This movement will be added for the tracking process : </h2>
        <p class="fw-bold mx-4 mb-4">Origin : Air Selangor Lab</p>
        <p class="fw-bold mx-4 mb-4">Destination : Air Selangor Inventory Department</p>
        <p class="fw-bold mx-4 mb-4">Meter Status : In Transit</p>
        <!-- Hidden input to pass batch_id -->
        <div class="text-center">
            <input type="hidden" name="batch_id" value="<?php echo htmlspecialchars($batch_id); ?>">
            <button type="submit" style="width:30%;height:30%;" class="btn btn-success" name="confirm">Confirm</button>
            <button type="button" style="width:30%;height:30%;" class="btn btn-outline-secondary" onclick="cancelForm()">Cancel</button>
        </div>
    </form>

    <script>
        function cancelForm() {
            window.location.href = "LabDep_Scan_to_Inv.php";
        }
    </script>
</div>

<footer>
    <?php include 'footer.php'; ?>
</footer>

</body>
</html>
