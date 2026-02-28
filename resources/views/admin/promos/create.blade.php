@extends('layouts.admin')

@section('title', 'Tambah Promo - Admin Panel')
@section('header_title', 'Tambah Promo Baru')

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
                <form action="{{ route('admin.promos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Promo <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: Paket Platinum Operasi Katarak" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga Promo</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="0">
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Gambar Promo</label>

                            <div class="d-flex gap-2">
                                <input type="file" name="image" id="uploadInput" class="form-control @error('image') is-invalid @enderror" accept="image/*">

                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                    Browse Media
                                </button>
                            </div>

                            <input type="hidden" name="media_id" id="selectedMediaId">

                            <div class="form-text small">
                                Upload gambar baru atau pilih dari Media Library.
                            </div>

                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Konten Lengkap (Syarat, Ketentuan, Detail)</label>
                        <textarea name="content" id="editor" class="form-control">{{ old('content') }}</textarea>
                        <div class="form-text">Gunakan tabel, list, dan formatting lainnya untuk memperjelas info promo.</div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.promos.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Promo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
