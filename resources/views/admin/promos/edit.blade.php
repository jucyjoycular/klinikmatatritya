@extends('layouts.admin')

@section('title', 'Edit Promo - Admin Panel')
@section('header_title', 'Edit Promo')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.promos.update', $promo->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Promo <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $promo->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga Promo</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $promo->price) }}" placeholder="0">
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Gambar Promo</label>
                            <div class="mb-2">
                                <img src="{{ $promo->image ? asset('storage/' . $promo->image) : 'https://via.placeholder.com/200x120?text=No+Image' }}"
                                     alt="Current Image"
                                     id="currentPreview"
                                     class="rounded border"
                                     style="width:200px; height:120px; object-fit:cover;">
                            </div>
                            <div class="d-flex gap-2">
                                <input type="file"
                                       name="image"
                                       id="uploadInput"
                                       class="form-control @error('image') is-invalid @enderror"
                                       accept="image/*">
                                <button type="button"
                                        class="btn btn-outline-primary"
                                        id="browseInput"
                                        data-bs-toggle="modal"
                                        data-bs-target="#mediaModal">
                                    Browse Media
                                </button>
                            </div>
                            <input type="hidden" name="media_id" id="selectedMediaId" value="{{ old('media_id') }}">
                            <div class="form-text small">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $promo->start_date ? \Carbon\Carbon::parse($promo->start_date)->format('Y-m-d') : '') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $promo->end_date ? \Carbon\Carbon::parse($promo->end_date)->format('Y-m-d') : '') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Konten Lengkap (Syarat, Ketentuan, Detail) <span class="text-danger">*</span></label>
                        <textarea name="content" id="editor" class="form-control @error('content') is-invalid @enderror">{{ old('content', $promo->content) }}</textarea>
                        <div class="form-text">Gunakan tabel, list, dan formatting lainnya untuk memperjelas info promo.</div>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.promos.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
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
                <div class="text-center text-muted">Belum ada media tersedia.</div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="selectMediaBtn" disabled>Gunakan Gambar Ini</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    let selectedId = null;
    let selectedPath = null;

    document.querySelectorAll('.media-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.media-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');

            selectedId = this.dataset.id;
            selectedPath = this.dataset.path;
            document.getElementById('selectMediaBtn').disabled = false;
        });
    });

    document.getElementById('selectMediaBtn').addEventListener('click', function() {
        document.getElementById('selectedMediaId').value = selectedId;

        if (selectedPath) {
            document.getElementById('currentPreview').src = selectedPath;
        }

        document.getElementById('uploadInput').value = '';

        let modal = bootstrap.Modal.getInstance(document.getElementById('mediaModal'));
        modal.hide();
    });

    document.getElementById('browseInput').addEventListener('click', function() {
        document.getElementById('uploadInput').value = '';
    });

    document.getElementById('uploadInput').addEventListener('change', function(e) {
        if (e.target.files[0]) {
            let reader = new FileReader();
            reader.onload = function(evt) {
                document.getElementById('currentPreview').src = evt.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);

            document.getElementById('selectedMediaId').value = '';
        }
    });

    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
        })
        .catch(error => {
            console.error(error);
        });
</script>

<style>
    .media-card {
        cursor: pointer;
        transition: 0.2s;
    }

    .media-card:hover {
        transform: scale(1.05);
    }

    .media-card.selected {
        border: 3px solid #0d6efd !important;
    }
</style>
@endsection