@extends('layouts.admin')

@section('title', 'Manajemen Layanan - Admin Panel')
@section('header_title', 'Manajemen Layanan')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between bg-white py-3">
            <h6 class="fw-bold mb-0">Daftar Layanan</h6>
            @can('create.layanan')
            <a href="{{ route('admin.services.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Baru
            </a>
            @endcan
           
        </div>
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table-hover mb-0 table align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 ps-4" style="width: 50px;">No</th>
                            <th class="border-0 py-3">Gambar</th>
                            <th class="border-0 py-3">Judul Layanan</th>
                            <th class="border-0 py-3">Kutipan</th>
                            <th class="border-0 py-3 pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td class="ps-4">
                                    {{ $loop->iteration + ($services->currentPage() - 1) * $services->perPage() }}</td>
                                <td>
                                    @if ($service->image)
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="Image" class="rounded"
                                            width="60" height="40" style="object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center text-muted rounded"
                                            style="width: 60px; height: 40px;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $service->title }}</div>
                                </td>
                                <td>
                                    <div class="text-muted small text-truncate" style="max-width: 200px;">
                                        {{ $service->excerpt ?? '-' }}
                                    </div>
                                </td>
                                <td class="pe-4 text-end">
                                    @can('update.layanan')
                                    <a href="{{ route('admin.services.edit', $service->id) }}"
                                        class="btn btn-sm btn-light text-primary me-1"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('delete.layanan')
                                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted py-5 text-center">
                                    <i class="fas fa-concierge-bell fs-1 d-block mb-3"></i>
                                    Belum ada data layanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer border-0 bg-white py-3">
            {{ $services->links() }}
        </div>
    </div>
@endsection
