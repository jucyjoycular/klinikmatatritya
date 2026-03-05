@extends('layouts.admin')

@section('title', 'Manajemen Karir - Admin Panel')
@section('header_title', 'Manajemen Karir')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-bold">Daftar Lowongan Karir</h6>
        @can('create.career')
        <a href="{{ route('admin.careers.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Karir
        </a>
        @endcan
    </div>
    <div class="card-body p-0"> 

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 py-3 ps-4" style="width: 50px;">No</th>
                        <th class="border-0 py-3">Posisi</th>
                        <th class="border-0 py-3">Tipe</th>
                        <th class="border-0 py-3">Lokasi</th>
                        <th class="border-0 py-3">Status</th>
                        <th class="border-0 py-3 pe-4 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($careers as $career)
                    <tr>
                        <td class="ps-4">{{ $loop->iteration + ($careers->currentPage() - 1) * $careers->perPage() }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $career->title }}</div>
                            <div class="small text-muted">Max: {{ $career->deadline ? \Carbon\Carbon::parse($career->deadline)->format('d M Y') : '-' }}</div>
                        </td>
                        <td>{{ $career->type }}</td>
                        <td>{{ $career->location }}</td>
                        <td>
                            @if($career->is_active)
                                <span class="badge bg-success-subtle text-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            @can('update.career')
                                <a href="{{ route('admin.careers.edit', $career->id) }}" class="btn btn-sm btn-light text-primary me-1"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('delete.career')
                                <form action="{{ route('admin.careers.destroy', $career->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus karir ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-briefcase fs-1 mb-3 d-block"></i>
                            Belum ada data karir.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $careers->links() }}
    </div>
</div>
@endsection
