@extends('layouts.admin')

@section('title', 'Pengaturan Review Google')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan Review Google</h1>
    </div>

    <div class="card mb-4 shadow">
        <div class="card-header py-3">
            <h6 class="font-weight-bold text-primary m-0">Konfigurasi Widget Review</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.review-settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Urutan Tampilan</label>
                    <select class="form-control" id="sort_order" name="sort_order">
                        <option value="date" {{ $setting->sort_order == 'date' ? 'selected' : '' }}>Terbaru (Date)
                        </option>
                        <option value="random" {{ $setting->sort_order == 'random' ? 'selected' : '' }}>Acak (Random)
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="limit" class="form-label">Jumlah Data Ditampilkan</label>
                    <input type="number" class="form-control" id="limit" name="limit" value="{{ $setting->limit }}"
                        min="1" max="100">
                    <div class="form-text">Maksimal 100 data.</div>
                </div>
                <div class="mb-3">
                    <label for="min_rating" class="form-label">Minimal Rating</label>
                    <select class="form-control" id="min_rating" name="min_rating">
                        <option value="5" {{ $setting->min_rating == 5 ? 'selected' : '' }}>5 Bintang Only</option>
                        <option value="4" {{ $setting->min_rating == 4 ? 'selected' : '' }}>4 Bintang ke atas</option>
                        <option value="3" {{ $setting->min_rating == 3 ? 'selected' : '' }}>3 Bintang ke atas</option>
                        <option value="2" {{ $setting->min_rating == 2 ? 'selected' : '' }}>2 Bintang ke atas</option>
                        <option value="1" {{ $setting->min_rating == 1 ? 'selected' : '' }}>Semua Rating</option>
                    </select>
                </div>
                @can('update.review')
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>    
                @endcan
            </form>
        </div>
    </div>
@endsection
