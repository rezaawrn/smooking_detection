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

.camera-frame img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* OLD WEBCAM */
/*
.camera-frame video{
    width:100%;
    height:100%;
    object-fit:cover;
}
*/

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

        <img 
            id="camera"
            src="http://172.20.10.4:5000/video_feed"
            style="width:100%; height:100%; object-fit:cover;"
        >

        <button onclick="reloadCamera()" class="btn btn-primary reload-btn">
            Reload Kamera
        </button>

    </div>

</div>

</section>
</div>
@endsection

@push('scripts')
<script>

console.log("Tapo CCTV Connected");

// ========================================
// RELOAD CCTV
// ========================================

function reloadCamera(){

    const camera = document.getElementById("camera");

    camera.src = "";

    setTimeout(() => {
        camera.src =
            "http://172.20.10.4:5000/video_feed?t=" +
            new Date().getTime();
    }, 500);

}

let lastId = null;

// =========================
// CEK DETEKSI BARU
// =========================
async function checkNewDetection(){

    try{

        let response = await fetch("/api/latest-detection");

        let data = await response.json();

        // pertama kali load
        if(lastId === null){
            lastId = data.id;
            return;
        }

        // jika ada data baru
        if(data.id > lastId){

            lastId = data.id;

            Swal.fire({
                icon: 'warning',
                title: 'Rokok Terdeteksi',
                text: 'Mengambil Gambar Pelanggaran',
                timer: 2000,
                showConfirmButton: false
            });

        }

    }catch(err){

        console.log(err);

    }
}

// cek tiap 3 detik
setInterval(checkNewDetection, 3000);

</script>
@endpush