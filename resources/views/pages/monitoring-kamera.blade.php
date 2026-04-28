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

            let now = Date.now();

            let adaRokok = result.detections.some(d => 
                d.class.toLowerCase() === 'cigarette'
            );

            if(adaRokok && (now - lastCaptureTime > 5000)){

                lastCaptureTime = now;

                let snapshot = new FormData();
                snapshot.append("image", blob, "snapshot.jpg");

                let res = await fetch("/save-detection", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: snapshot
                });

                if(res.ok){
                    Swal.fire({
                        icon: 'success',
                        title: 'Terdeteksi!',
                        text: 'Pelanggaran berhasil disimpan',
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