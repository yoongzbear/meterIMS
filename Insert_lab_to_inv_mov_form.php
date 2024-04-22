<?php
//include ('secure_TestLab.php'); 
$batch_id = $_POST['batch_id'];

?>
<form method="post" action="Insert_lab_to_inv_mov_process.php">
    <p>This movement will be added for the tracking process:</p>
    <label>Origin: Air Selangor Lab</label><br>
    <label>Destination: Air Selangor Inv</label><br>
    <label>Meter Status: In Transit</label><br>
    <!-- Hidden input to pass batch_id -->
    <input type="hidden" name="batch_id" value="<?php echo htmlspecialchars($batch_id); ?>">
    <button type="submit" name="confirm">Confirm</button>
    <button type="button" onclick="cancelForm()">Cancel</button>
</form>

<script>
    function cancelForm() {
        window.location.href = "LabDep_Scan_to_Inv.php";
    }
</script>
</form>
