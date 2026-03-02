@extends('layouts.admin')

@section('title', 'Edit Asuransi')

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

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Asuransi</h1>
        <a href="{{ route('admin.insurances.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card mb-4 shadow">
        <div class="card-body">
            <form action="{{ route('admin.insurances.update', $insurance->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama (Optional)</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $insurance->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="logo" class="form-label">Logo (Biarkan kosong jika tidak ingin mengubah)</label>
                    <div class="mb-2">
                        <img src="{{ Storage::url($insurance->logo) }}" 
                             alt="{{ $insurance->name }}" 
                             id="currentPreview"
                             width="100">
                    </div>
                    <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo"
                        name="logo" accept="image/*">
                    <div class="d-flex gap-2 mt-2">
                        <button type="button" 
                                class="btn btn-outline-primary btn-sm" 
                                id="browseBtn"
                                data-bs-toggle="modal" 
                                data-bs-target="#mediaModal">
                            Browse Media
                        </button>

                        <input type="hidden" name="media_id" id="selectedMediaId" value="{{ old('media_id') }}">
                    </div>
                    <small class="text-muted">Format: jpg, jpeg, png, gif, svg. Max: 2MB.</small>
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

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
    document.getElementById('logo').value = '';

    let modal = bootstrap.Modal.getInstance(
        document.getElementById('mediaModal')
    );
    modal.hide();
});

document.getElementById('browseBtn')
.addEventListener('click', function(){
    // Reset file input saat buka modal, bukan reset media_id
    document.getElementById('logo').value = '';
});

// Preview upload manual
document.getElementById('logo')
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
