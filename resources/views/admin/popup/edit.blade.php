@extends('layouts.admin')

@section('title', 'Edit Popup Home Banner - Admin Panel')
@section('header_title', 'Edit Popup Home Banner')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.popup.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Popup Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    @if($popup->image)
        <img src="{{ asset('storage/'.$popup->image) }}" width="300">
    @endif

    <div class="form-check mt-3">
        <input type="checkbox" name="is_active" value="1"
            {{ $popup->is_active ? 'checked' : '' }}>
        <label>Aktifkan Popup</label>
    </div>

                    
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                    </div>
                </form>
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
</script>
@endsection
