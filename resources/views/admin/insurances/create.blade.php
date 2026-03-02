@extends('layouts.admin')

@section('title', 'Tambah Asuransi')

@section('content')

<style>
    .media-card{
        cursor:pointer;
        transition:0.2s;
    }
    .media-card:hover{
        transform:scale(1.05);
    }
    .media-card.selected{
        border:3px solid #0d6efd !important;
    }
    .modal-body{
        max-height:70vh;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Asuransi</h1>
    <a href="{{ route('admin.insurances.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
<div class="card-body">

<form action="{{ route('admin.insurances.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-3">
    <label class="form-label">Nama (Optional)</label>
    <input type="text"
           name="name"
           value="{{ old('name') }}"
           class="form-control @error('name') is-invalid @enderror">

    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Logo</label>

    {{-- Preview --}}
    <div class="mb-2">
        <img src="https://via.placeholder.com/200x120?text=No+Image"
             id="currentPreview"
             class="rounded border"
             style="width:200px; height:120px; object-fit:cover;">
    </div>

    <div class="d-flex gap-2">
        <input type="file"
               name="logo"
               id="uploadInput"
               class="form-control @error('logo') is-invalid @enderror"
               accept="image/*">

        <button type="button"
                class="btn btn-outline-primary"
                id="browseInput"
                data-bs-toggle="modal"
                data-bs-target="#mediaModal">
            Browse Media
        </button>
    </div>

    <input type="hidden" name="media_id" id="selectedMediaId">

    <div class="form-text small">
        Upload logo baru atau pilih dari Media Library.
    </div>

    @error('logo')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">Simpan</button>

</form>
</div>
</div>


{{-- ================= MEDIA MODAL ================= --}}
<div class="modal fade" id="mediaModal" tabindex="-1">
<div class="modal-dialog modal-xl modal-dialog-scrollable">
<div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title">Media Library</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        @if($media->count())
        <div class="row g-3">
            @foreach($media as $item)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="media-card border rounded p-1"
                     data-id="{{ $item->id }}"
                     data-path="{{ asset('storage/'.$item->filepath) }}">

                    <img src="{{ asset('storage/'.$item->filepath) }}"
                         class="img-fluid rounded"
                         style="height:120px; width:100%; object-fit:cover;">
                </div>
            </div>
            @endforeach
        </div>
        @else
            <div class="text-center text-muted">
                Belum ada media tersedia.
            </div>
        @endif

    </div>

    <div class="modal-footer">
        <button type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal">
            Cancel
        </button>

        <button type="button"
                class="btn btn-primary"
                id="selectMediaBtn"
                disabled>
            Gunakan Gambar Ini
        </button>
    </div>

</div>
</div>
</div>

@endsection


@section('scripts')
<script>
let selectedId = null;
let selectedPath = null;

document.querySelectorAll('.media-card').forEach(card => {

    card.addEventListener('click', function(){

        document.querySelectorAll('.media-card')
            .forEach(c => c.classList.remove('selected'));

        this.classList.add('selected');

        selectedId = this.dataset.id;
        selectedPath = this.dataset.path;

        document.getElementById('selectMediaBtn').disabled = false;
    });
});

document.getElementById('selectMediaBtn')
.addEventListener('click', function(){

    document.getElementById('selectedMediaId').value = selectedId;

    if(selectedPath){
        document.getElementById('currentPreview').src = selectedPath;
    }

    // Reset file upload karena pakai media library
    document.getElementById('uploadInput').value = '';

    let modal = bootstrap.Modal.getInstance(
        document.getElementById('mediaModal')
    );
    modal.hide();
});

document.getElementById('browseInput')
.addEventListener('click', function(){
    // Reset file input saat buka modal, bukan reset media_id
    document.getElementById('uploadInput').value = '';
});

// Preview upload manual
document.getElementById('uploadInput')
.addEventListener('change', function(e){

    if(e.target.files[0]){
        let reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('currentPreview').src = e.target.result;
        }
        reader.readAsDataURL(e.target.files[0]);

        // Reset media_id karena pakai upload manual
        document.getElementById('selectedMediaId').value = '';
    }
});
</script>
@endsection