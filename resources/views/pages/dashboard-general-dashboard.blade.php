@extends('layouts.app')

@section('title', 'Monitoring Kamera')

@push('style')
<style>
.camera-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
}
.camera-frame{
    width:100%;
    max-width:1000px;
    height:75vh;
    background:black;
    border-radius:15px;
    overflow:hidden;
    position:relative;
}
.camera-frame video{
    width:100%;
    height:100%;
    object-fit:cover;
}
.status-badge{
    position:absolute;
    top:15px;
    left:15px;
    background:#dc3545;
    color:white;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:bold;
}
.status-on{
    background:#28a745 !important;
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

<div class="camera-wrapper">

<div class="camera-frame">

<span id="camStatus" class="status-badge">OFFLINE</span>

<video id="camera" autoplay playsinline></video>

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
let statusBadge = document.getElementById("camStatus");
let stream = null;

async function startCamera(){
    try{
        if(stream){
            stream.getTracks().forEach(track=>track.stop());
        }

        stream = await navigator.mediaDevices.getUserMedia({
            video:true,
            audio:false
        });

        video.srcObject = stream;

        statusBadge.innerText="ONLINE";
        statusBadge.classList.add("status-on");

    }catch(err){
        statusBadge.innerText="KAMERA DITOLAK";
        statusBadge.classList.remove("status-on");
        console.error(err);
    }
}

// auto start saat halaman dibuka
window.onload=startCamera;

</script>
@endpush
