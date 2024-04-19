<?php 
include ('secure_Inv.php'); 
include('connection.php');

?>
<h3>View Meter Info</h3>
<p>Please scan the QR code on the water meter to view the information</p>
    <canvas id="qr-canvas" width="300" height="300" style="border:1px solid #000000;"></canvas> <br>
    <!--is there a way to set the size without it expanding-->
    <button type="button" id="btn-scan-qr" >Scan QR</button>
    <button type="button" id="btn-cancel-scan">Cancel Scan</button>
    
    <form id="meterForm" action="InvDep_view_meter_info.php" method="post" style="display:none;">
        <label for="serial_num">Meter Serial Number:</label>
        <input type="text" id="outputData" name="serial_num" readonly>
        <p>Is this the right serial number meter?</p>
        <input type="submit" value="Yes">
        <button id="btn-cancel">No</button>
    </form>

    <script>

        //redirect to the meter install page if cancelled after scanning
        document.getElementById("btn-cancel").addEventListener("click", function(event) {
            event.preventDefault();
            window.location.href = 'inv_QRmenu.php';
        });
    </script>

    <script src="qrPacked.js"></script>
    <script src="qrReader.js"></script>

    <button type="button" onclick="window.location.href='Inv_QRmenu.php'">Back</button>

