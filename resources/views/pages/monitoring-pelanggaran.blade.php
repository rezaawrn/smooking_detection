@extends('layouts.app')

@section('title', 'Monitoring Pelanggaran')

@push('style')
<style>

.table-img{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:10px;
    box-shadow:0 3px 8px rgba(0,0,0,0.15);
}

/* FILTER STYLE */
.custom-filter{
    width:180px;
    height:45px;
    border-radius:12px;
    border:1px solid #ddd;
    padding:0 15px;
    font-size:14px;
    background:#eee;
    appearance:none;
    background-image:url("data:image/svg+xml;utf8,<svg fill='black' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
    background-repeat:no-repeat;
    background-position:right 12px center;
}


.custom-filter:focus{
    outline:none;
    box-shadow:0 0 0 3px rgba(0,123,255,.2);
}

.btn-reset{
    height:45px;
    padding:0 18px;
    border:none;
    border-radius:8px;
    background:#ff4d4f;
    color:white;
    font-size:14px;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:8px;
    box-shadow:0 3px 8px rgba(0,0,0,0.15);
    transition:all .2s ease;
}

.btn-reset:hover{
    background:#e04142;
    transform:translateY(-1px);
    box-shadow:0 5px 12px rgba(0,0,0,0.2);
}




.btn-reset:hover{
    background:#d60000;
    color:white;
}

</style>
@endpush

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('main')
<div class="main-content">
<section class="section">

<div class="section-header">
<h1>Monitoring Pelanggaran</h1>
</div>

<div class="section-body">

<div class="card">

<!-- HEADER -->
<div class="card-header flex-column align-items-start">

<h4 class="mb-3 font-weight-bold text-dark">
Daftar Pelanggaran
</h4>

<div class="d-flex align-items-end" style="gap:30px; flex-wrap:wrap;">


<!-- BULAN -->
<div>
<label class="mb-1 font-weight-bold">Pilih Bulan:</label>
<select id="bulan" class="custom-filter">
<option value="">Semua</option>
<option value="0">Jan</option>
<option value="1">Feb</option>
<option value="2">Mar</option>
<option value="3">Apr</option>
<option value="4">Mei</option>
<option value="5">Jun</option>
<option value="6">Jul</option>
<option value="7">Agu</option>
<option value="8">Sep</option>
<option value="9">Okt</option>
<option value="10">Nov</option>
<option value="11">Des</option>
</select>
</div>

<!-- TAHUN -->
<div>
<label class="mb-1 font-weight-bold">Pilih Tahun:</label>
<select id="tahun" class="custom-filter">
<option value="">Semua</option>
<option>2026</option>
<option>2025</option>
<option>2024</option>
</select>
</div>

<!-- RESET -->
<button onclick="resetFilter()" class="btn-reset">
<i class="fas fa-undo"></i> Reset
</button>



</div>
</div>



<!-- BODY -->
<div class="card-body">

<div class="table-responsive">
<table class="table table-striped text-center">

<thead class="thead-dark">
<tr>
<th>Tanggal</th>
<th>Tempat</th>
<th>Foto</th>
<th>Aksi</th>
</tr>
</thead>

<tbody id="tableBody">

@forelse($data as $row)
<tr data-id="{{ $row->id }}" data-date="{{ \Carbon\Carbon::parse($row->detected_at)->format('Y-m-d') }}">

<td>
    {{ \Carbon\Carbon::parse($row->detected_at)->translatedFormat('d M Y H:i') }}
</td>

<td>Area Kamera</td>

<td>
    <img src="{{ asset('storage/' . $row->image_path) }}" 
         class="table-img preview-img"
         onclick="showModal(this.src)">
</td>

<td>
    <button onclick="hapusData(this)" class="btn btn-danger btn-sm">
        <i class="fas fa-trash"></i> Hapus
    </button>
</td>

</tr>
@empty
<tr>
<td colspan="4">Tidak ada data</td>
</tr>
@endforelse

</tbody>

</table>

<!-- MODAL PREVIEW -->
<div id="imageModal" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.8);
    justify-content:center;
    align-items:center;
    z-index:9999;
">

    <img id="modalImage" style="
        max-width:90%;
        max-height:90%;
        border-radius:15px;
        box-shadow:0 10px 30px rgba(0,0,0,0.5);
    ">

</div>

</div>

</div>
</div>

</div>
</section>
</div>
@endsection




@push('scripts')
<script>

function hapusRow(btn){
    if(confirm("Yakin ingin menghapus data ini?")){
        btn.closest("tr").remove();
    }
}

document.getElementById("bulan").addEventListener("change",filterData);
document.getElementById("tahun").addEventListener("change",filterData);

function filterData(){
    let bulan = document.getElementById("bulan").value;
    let tahun = document.getElementById("tahun").value;
    let rows = document.querySelectorAll("#tableBody tr");

    rows.forEach(row=>{
        let d = new Date(row.dataset.date);

        let cocokBulan = bulan === "" || d.getMonth()==bulan;
        let cocokTahun = tahun === "" || d.getFullYear()==tahun;

        row.style.display = (cocokBulan && cocokTahun) ? "" : "none";
    });
}

function resetFilter(){
    document.getElementById("bulan").value="";
    document.getElementById("tahun").value="";
    filterData();
}

// =======================
// MODAL PREVIEW
// =======================
function showModal(src){
    document.getElementById("imageModal").style.display = "flex";
    document.getElementById("modalImage").src = src;
}

document.getElementById("imageModal").onclick = function(){
    this.style.display = "none";
}


// =======================
// HAPUS DATA
// =======================
async function hapusData(btn){

    let row = btn.closest("tr");
    let id = row.dataset.id;

    Swal.fire({
        title: 'Yakin hapus?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then(async (result) => {

        if(result.isConfirmed){

            try{
                let res = await fetch(`/pelanggaran/${id}`, {
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                let data = await res.json();

                if(data.success){

                    // animasi hilang
                    row.style.transition = "0.3s";
                    row.style.opacity = "0";

                    setTimeout(()=>{
                        row.remove();
                    }, 300);

                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: 'Data berhasil dihapus.',
                        timer: 1500,
                        showConfirmButton: false
                    });

                }else{
                    Swal.fire('Gagal!', data.message || 'Gagal menghapus.', 'error');
                }

            }catch(err){
                console.error(err);
                Swal.fire('Error!', 'Terjadi kesalahan server.', 'error');
            }

        }

    });
}
</script>
@endpush
