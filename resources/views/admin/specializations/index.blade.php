@extends('layouts.admin')

@section('title', 'Manajemen Spesialisasi')

@section('header_title', 'Manajemen Spesialisasi')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between bg-white py-3">
            <h6 class="fw-bold mb-0">Daftar Spesialisasi</h6>
            @can('create.spesialisasi')
            <a href="{{ route('admin.specializations.create') }}" class="btn btn-sm btn-primary">
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
                            <th class="border-0 py-3">Icon</th>
                            <th class="border-0 py-3">Judul</th>
                            <th class="border-0 py-3">Deskripsi</th>
                            <th class="border-0 py-3 pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($specializations as $specialization)
                            <tr>
                                <td class="ps-4">
                                    {{ $loop->iteration + ($specializations->currentPage() - 1) * $specializations->perPage() }}
                                </td>
                                <td>
                                    @if ($specialization->icon)
                                        <div class="bg-light d-flex align-items-center justify-content-center text-primary rounded"
                                            style="width: 40px; height: 40px;">
                                            <i class="{{ $specialization->icon }} fs-5"></i>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $specialization->title }}</div>
                                </td>
                                <td>
                                    <div class="text-muted small text-truncate" style="max-width: 300px;">
                                        {{ $specialization->description }}</div>
                                </td>
                                <td class="pe-4 text-end">
                                    @can('update.spesialisasi')
                                        <a href="{{ route('admin.specializations.edit', $specialization->id) }}"
                                            class="btn btn-sm btn-light text-primary me-1"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('delete.spesialisasi')
                                    <form action="{{ route('admin.specializations.destroy', $specialization->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus spesialisasi ini?')">
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
                                    <i class="fas fa-stethoscope fs-1 d-block mb-3"></i>
                                    Belum ada data spesialisasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer border-0 bg-white py-3">
            {{ $specializations->links() }}
        </div>
    </div>
@endsection
