@extends('layouts.app')

@section('title', 'Monitoring Kamera')

@push('style')
<style>
.camera-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    margin-top:20px;
}

.camera-frame{
    width:100%;
    max-width:1000px;
    height:75vh;
    background:black;
    border-radius:15px;
    overflow:hidden;
    position:relative;
    box-shadow:0 4px 20px rgba(0,0,0,0.2);
}

.camera-frame video{
    width:100%;
    height:100%;
    object-fit:cover;
}

.reload-btn{
    position:absolute;
    bottom:15px;
    right:15px;
}

#overlay{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    z-index:2;
    pointer-events:none;
}

</style>
@endpush


@section('main')
<div class="main-content">
<section class="section">

<div class="section-header">
    <h1>Monitoring Kamera</h1>
</div>

<!-- 🔥 CSRF -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="camera-wrapper">

    <div class="camera-frame">

        <!-- 🎥 VIDEO -->
        <video id="camera" autoplay playsinline></video>

        <canvas id="overlay"></canvas>

        <!-- hidden canvas -->
        <canvas id="canvas" style="display:none;"></canvas>

        <button onclick="startCamera()" class="btn btn-primary reload-btn">
            Reload Kamera
        </button>

    </div>

</div>

</section>
</div>
@endsection



@push('scripts')
<script>

let video = document.getElementById("camera");
let canvas = document.getElementById("canvas");
let overlay = document.getElementById("overlay");
let ctxOverlay = overlay.getContext("2d");

let stream = null;
let lastCaptureTime = 0;

// =======================
// START CAMERA
// =======================
async function startCamera(){
    try{
        if(stream){
            stream.getTracks().forEach(track=>track.stop());
        }

        stream = await navigator.mediaDevices.getUserMedia({
            video: { width: 640, height: 480 },
            audio:false
        });

        video.srcObject = stream;
        await video.play();

    }catch(err){
        console.error("Kamera error:", err);
    }
}

// =======================
// DRAW BOUNDING BOX
// =======================
function drawBoxes(detections){

    overlay.width = video.videoWidth;
    overlay.height = video.videoHeight;

    ctxOverlay.clearRect(0, 0, overlay.width, overlay.height);

    detections.forEach(det => {

        let x = det.x;
        let y = det.y;
        let w = det.width;
        let h = det.height;

        // BOX
        ctxOverlay.strokeStyle = "red";
        ctxOverlay.lineWidth = 2;
        ctxOverlay.strokeRect(x, y, w, h);

        // LABEL + CONF
        ctxOverlay.fillStyle = "red";
        ctxOverlay.font = "14px Arial";
        ctxOverlay.fillText(
            `${det.class} (${det.confidence})`,
            x,
            y > 10 ? y - 5 : 10
        );
    });
}

// =======================
// CAPTURE FINAL (VIDEO + BOX)
// =======================
function captureWithOverlay(){

    let finalCanvas = document.createElement("canvas");
    let ctx = finalCanvas.getContext("2d");

    finalCanvas.width = video.videoWidth;
    finalCanvas.height = video.videoHeight;

    // 🔥 video
    ctx.drawImage(video, 0, 0, finalCanvas.width, finalCanvas.height);

    // 🔥 overlay (box + text)
    ctx.drawImage(overlay, 0, 0, finalCanvas.width, finalCanvas.height);

    return new Promise(resolve => {
        finalCanvas.toBlob(blob => resolve(blob), "image/jpeg");
    });
}

// =======================
// CAPTURE & DETECT
// =======================
function captureAndSend(){
    if(!stream) return;
    if(video.videoWidth === 0) return;

    const ctx = canvas.getContext('2d');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    canvas.toBlob(async function(blob){

        let formData = new FormData();
        formData.append("image", blob, "frame.jpg");

        try{
            let response = await fetch("http://127.0.0.1:5000/detect", {
                method: "POST",
                body: formData
            });

            let result = await response.json();
            console.log("YOLO:", result);

            // 🔥 tampilkan bounding box
            drawBoxes(result.detections);

            let now = Date.now();

            let adaRokok = result.detections.some(d => 
                d.class.toLowerCase() === 'cigarette'
            );

            // =======================
            // SNAPSHOT (ADA BOX)
            // =======================
            if(adaRokok && (now - lastCaptureTime > 5000)){

                lastCaptureTime = now;

                // 🔥 ambil gambar + overlay
                let finalBlob = await captureWithOverlay();

                let snapshot = new FormData();
                snapshot.append("image", finalBlob, "snapshot.jpg");
                snapshot.append("keterangan", "Perokok terdeteksi");

                let res = await fetch("/save-detection", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: snapshot
                });

                if(res.ok){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Terdeteksi!',
                        text: 'Pelanggaran tersimpan',
                        timer: 1200,
                        showConfirmButton: false
                    });
                }else{
                    console.error("❌ Gagal simpan");
                }
            }

        }catch(err){
            console.error("ERROR:", err);
        }

    }, "image/jpeg");
}

// =======================
// LOOP DETEKSI
// =======================
setTimeout(() => {
    setInterval(captureAndSend, 2000);
}, 2000);

// =======================
// AUTO START
// =======================
document.addEventListener("DOMContentLoaded", startCamera);

</script>
@endpush