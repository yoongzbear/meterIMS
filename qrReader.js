const qr = window.qrcode;
const video = document.createElement("video");
const canvasElement = document.getElementById("qr-canvas");
const canvas = canvasElement.getContext("2d");
const qrResult = document.getElementById("qr-result");
const outputData = document.getElementById("outputData");
const btnScanQR = document.getElementById("btn-scan-qr");
const btnCancelScan = document.getElementById("btn-cancel-scan");
let scanning = false;


//qr code callback function (called by library when qr is detected)
qr.callback = result => {
    if (result){
        outputData.value = result; // Set the scanned Meter ID
        console.log("Read Data: "+result);
        scanning = false;

        video.srcObject.getTracks().forEach(track => {
            track.stop();
        });

        canvasElement.hidden = true; // Hide the canvas
        btnScanQR.hidden = false; // Show the scan button again if needed
        document.getElementById("meterForm").style.display = "block"; // Display the form
    }
}

//scanning cancellation button
btnCancelScan.onclick = () => {
    scanning = false;
    canvasElement.hidden = true;
    btnScanQR.hidden = false;

    video.srcObject.getTracks().forEach(track => {
        track.stop();
    });

}

//qr code scanning button onclick handler
btnScanQR.onclick = () => {
    navigator.mediaDevices
    .getUserMedia({ video: { facingMode: "environment" } })
    .then(function(stream) {
        scanning = true;
        btnScanQR.hidden = true;
        canvasElement.hidden = false;
        video.setAttribute("playsinline", true); //for safari to prevent going fullscreen
        video.srcObject = stream;
        video.play();
        draw();
        scan();
    });
}

//draw function
function draw(){
    canvasElement.height = video.videoHeight;
    canvasElement.width = video.videoWidth;
    canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);

    scanning && requestAnimationFrame(draw);
}

function scan(){
    try{
        qr.decode();
    }
    catch (e){
        setTimeout(scan, 300);
    }
}