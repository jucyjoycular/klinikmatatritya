@extends('layouts.admin')

@section('title', 'Make Instagram Feed Settings')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan Instagram Feed</h1>
    </div>

    <div class="card mb-4 shadow">
        <div class="card-header py-3">
            <h6 class="font-weight-bold text-primary m-0">Konfigurasi Widget Instagram</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.instagram-settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="sort" class="form-label">Urutan Tampilan</label>
                    <select class="form-control" id="sort" name="sort">
                        <option value="date" {{ $setting->sort == 'date' ? 'selected' : '' }}>Terbaru (Date)</option>
                        <option value="random" {{ $setting->sort == 'random' ? 'selected' : '' }}>Acak (Random)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="limit" class="form-label">Jumlah Data Ditampilkan</label>
                    <input type="number" class="form-control" id="limit" name="limit" value="{{ $setting->limit }}"
                        min="1" max="100">
                    <div class="form-text">Maksimal 100 data.</div>
                </div>
                @can('update.instagram')
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                @endcan
            </form>
        </div>
    </div>
@endsection
