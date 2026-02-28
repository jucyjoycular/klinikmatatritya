@extends('layouts.admin')

@section('title', 'Edit Popup Home Banner - Admin Panel')
@section('header_title', 'Edit Popup Home Banner')

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

                <form action="{{ route('popup.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Popup Image</label>

                        {{-- Preview --}}
                        <div class="mb-2">
                            @if($popup->image)
                                <img src="{{ asset('storage/'.$popup->image) }}" id="currentPreview" class="rounded border" style="width:250px; height:150px; object-fit:cover;">
                            @else
                                <img src="https://via.placeholder.com/250x150?text=No+Image" id="currentPreview" class="rounded border">
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <input type="file" name="image" id="uploadInput" class="form-control" accept="image/*">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                Browse Media
                            </button>
                        </div>

                        <input type="hidden" name="media_id" id="selectedMediaId">

                        <div class="form-text small">
                            Upload gambar baru atau pilih dari Media Library.
                        </div>
                    </div>

                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input"
                               {{ $popup->is_active ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Aktifkan Popup
                        </label>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('popup.edit') }}" class="btn btn-light">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            Simpan Perubahan
                        </button>
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