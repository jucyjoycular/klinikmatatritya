@extends('layouts.admin')

@section('title', 'Edit Layanan - Admin Panel')
@section('header_title', 'Edit Layanan')

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
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Layanan <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $service->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Layanan</label>
                        
                        <div class="mb-2">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" id="currentPreview" alt="Current Image" class="rounded" width="150">
                            @else
                                <img src="https://via.placeholder.com/150?text=No+Image" id="currentPreview" alt="No Image" class="rounded">
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <input type="file" name="image" id="uploadInput" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                Browse Media
                            </button>
                        </div>

                        <input type="hidden" name="media_id" id="selectedMediaId" value="{{ $service->media_id }}">

                        <div class="form-text small">
                            Upload gambar baru atau pilih dari Media Library.
                        </div>

                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kutipan Singkat (Excerpt)</label>
                        <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt', $service->excerpt) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Konten Lengkap</label>
                        <textarea name="content" id="editor" class="form-control">{{ old('content', $service->content) }}</textarea>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal browse media --}}
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
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Cancel
            </button>

            <button type="button" class="btn btn-primary" id="selectMediaBtn" disabled>
                Gunakan Gambar Ini
            </button>
        </div>

    </div>
    </div>
    </div>
@endsection

@section('scripts')
<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });

    let selectedId = null;
    let selectedPath = null;

    const mediaCards = document.querySelectorAll('.media-card');
    const selectBtn = document.getElementById('selectMediaBtn');
    const selectedMediaInput = document.getElementById('selectedMediaId');
    const previewImage = document.getElementById('currentPreview');
    const mediaModalEl = document.getElementById('mediaModal');

    mediaCards.forEach(card => {
        card.addEventListener('click', function () {

            mediaCards.forEach(c => c.classList.remove('border-primary'));

            // Tambahkan highlight ke card yang dipilih
            this.classList.add('border-primary');

            // Ambil data dari atribut
            selectedId = this.dataset.id;
            selectedPath = this.dataset.path;

            // Aktifkan tombol pilih
            selectBtn.disabled = false;
        });
    });

    selectBtn.addEventListener('click', function () {

        if (!selectedId) return;

        selectedMediaInput.value = selectedId;

        if (selectedPath) {
            previewImage.src = selectedPath;
        }

        const modalInstance = bootstrap.Modal.getInstance(mediaModalEl);
        if (modalInstance) {
            modalInstance.hide();
        }
    });

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


});
</script>
@endsection
