//searching url for get id
const url = window.location.search;
const params = new URLSearchParams(url);
const id = params.get("Batch_ID");

//QR code generation
var qrcode = new QRCode(document.getElementById("qrcode"));
function makeCode(){
    if(!id){
        console.log("No id found");
    }
    else{
        qrcode.makeCode(id);
    }
}
// call makeCode(); to create the QR code