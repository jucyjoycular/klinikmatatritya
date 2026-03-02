@extends('layouts.admin')

@section('title', 'Edit Hero Section - Admin Panel')
@section('header_title', 'Edit Hero Section')

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

<form method="POST" action="{{ route('admin.hero.update', $hero) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="mb-3">
    <label class="form-label">Judul Hero</label>
    <textarea name="title" class="form-control" rows="2">{{ old('title',$hero->title) }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control">{{ old('description',$hero->description) }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Background Image</label>

    {{-- Preview --}}
    @if($hero->background)
    <div class="mb-2">
        <img src="{{ asset('storage/' . $hero->background) }}" id="currentPreview" class="rounded border" style="width:200px; height:120px; object-fit:cover;">
    </div>
    @else
    <div class="mb-2">
        <img src="https://via.placeholder.com/200x120?text=No+Image" id="currentPreview" class="rounded border">
    </div>
    @endif

    <div class="d-flex gap-2">
        <input type="file" name="background" id="uploadInput" class="form-control @error('background') is-invalid @enderror" accept="image/*">

        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#mediaModal">
            Browse Media
        </button>
    </div>

    <input type="hidden" name="media_id" id="selectedMediaId">

    <div class="form-text small">
        Upload gambar baru atau pilih dari Media Library.
    </div>

    @error('background')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Teks Tombol</label>
    <input type="text" name="button_text" value="{{ old('button_text',$hero->button_text) }}" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Link Tombol</label>
    <input type="text" name="button_link" value="{{ old('button_link',$hero->button_link) }}" class="form-control">
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
</form>

{{-- Model browse media --}}
<div class="modal fade" id="mediaModal" tabindex="-1">
<div class="modal-dialog modal-xl modal-dialog-scrollable">
<div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title">Media Library</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        @if($mediaItems->count())
        <div class="row g-3">
            @foreach($mediaItems as $media)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="media-card border rounded p-1"
                     data-id="{{ $media->id }}"
                     data-path="{{ asset('storage/'.$media->filepath) }}">

                    <img src="{{ asset('storage/'.$media->filepath) }}"
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

    let modal = bootstrap.Modal.getInstance(
        document.getElementById('mediaModal')
    );
    modal.hide();
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

        document.getElementById('selectedMediaId').value = '';
    }
});
</script>
@endsection