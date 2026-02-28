@extends('layouts.admin')

@section('title', 'Tambah Layanan - Admin Panel')
@section('header_title', 'Tambah Layanan Baru')

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
                <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Layanan <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: Operasi Katarak" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Layanan</label>

                        <div class="d-flex gap-2 mb-2">
                            <input type="file" name="image" id="photo-file" class="form-control @error('image') is-invalid @enderror" 
                            accept="image/*" placeholder="Upload gambar">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                Browse Media
                            </button>
                        </div>

                        <input type="hidden" name="media_id" id="media_id" value="">

                        <div class="form-text small">Format: JPG, PNG. Maks: 2MB.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- <div id="photo-preview" class="mt-3"> --}}
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kutipan Singkat (Excerpt)</label>
                        <textarea name="excerpt" class="form-control" rows="3" placeholder="Deskripsi singkat yang muncul di accordion...">{{ old('excerpt') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Konten Lengkap</label>
                        <textarea name="content" id="editor" class="form-control">{{ old('content') }}</textarea>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Layanan</button>
                    </div>
                </form>
            </div>
        </div>
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
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
        })
        .catch(error => {
            console.error(error);
        });

        document.addEventListener('DOMContentLoaded', function () {
            let selectedId = null;
            let selectedPath = null;

            document.querySelectorAll('.media-card').forEach(card => {
                card.addEventListener('click', function () {
                    
                    document.querySelectorAll('.media-card').forEach(c => c.classList.remove('border-primary'));
                    this.classList.add('border-primary');

                    selectedId = this.getAttribute('data-id');
                    selectedPath = this.getAttribute('data-path');

                    document.getElementById('selectMediaBtn').disabled = false;
                });
            });

            document.getElementById('selectMediaBtn').addEventListener('click', function () {
                if (selectedId && selectedPath) {
                   
                    document.querySelector('input[name="media_id"]').value = selectedId;

                    if (selectedPath) {
                    const previewContainer = document.getElementById('photo-preview');
                    previewContainer.innerHTML = `<img src="${selectedPath}" class="img-fluid rounded" style="max-height:200px;">`;
                    }

                    let mediaModal = bootstrap.Modal.getInstance(document.getElementById('mediaModal'));
                    mediaModal.hide();
                }
            });

            document.getElementById('photo-file')
            .addEventListener('change', function(e){

                if(e.target.files[0]){
                    let reader = new FileReader();
                    reader.onload = function(e){
                        const previewWrapper = document.getElementById('photo-preview');
                        previewWrapper.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded mt-2" style="max-height:200px;">`;
                    }
                    reader.readAsDataURL(e.target.files[0]);

                    document.getElementById('media_id').value = '';
                }
            });
        });
</script>
@endsection