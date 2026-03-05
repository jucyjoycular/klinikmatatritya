@extends('layouts.admin')

@section('title', 'Lamaran Masuk - Admin Panel')
@section('header_title', 'Lamaran Masuk')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h6 class="fw-bold mb-0">Daftar Pelamar</h6>

                <form action="{{ route('admin.job-applications.index') }}" method="GET"
                    class="d-flex flex-column flex-md-row gap-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0"
                            placeholder="Cari pelamar..." value="{{ request('search') }}">
                    </div>

                    <select name="sort" class="form-select form-select-sm" style="min-width: 120px;">
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
                    </select>

                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>

                    @if (request()->has('search') || request()->has('sort'))
                        <a href="{{ route('admin.job-applications.index') }}" class="btn btn-sm btn-light border">
                            <i class="fas fa-undo me-1"></i> Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table-hover mb-0 table align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 ps-4" style="width: 50px;">No</th>
                            <th class="border-0 py-3">Nama Pelamar</th>
                            <th class="border-0 py-3">Posisi</th>
                            <th class="border-0 py-3">Kontak</th>
                            <th class="border-0 py-3">Tanggal</th>
                            <th class="border-0 py-3">Status</th>
                            <th class="border-0 py-3 pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                            <tr>
                                <td class="ps-4">
                                    {{ $loop->iteration + ($applications->currentPage() - 1) * $applications->perPage() }}
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $app->name }}</div>
                                    <div class="small text-muted">{{ $app->location }}</div>
                                </td>
                                <td>
                                    @if ($app->career)
                                        <span class="badge bg-primary-subtle text-primary">{{ $app->career->title }}</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Posisi Dihapus</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small text-dark">{{ $app->email }}</div>
                                    <div class="small text-muted">{{ $app->phone }}</div>
                                </td>
                                <td>
                                    <div class="text-muted small">{{ $app->created_at->format('d M Y, H:i') }}</div>
                                </td>
                                <td>
                                    @if ($app->status == 'pending')
                                        <span class="badge bg-warning-subtle text-warning">Pending</span>
                                    @elseif($app->status == 'reviewed')
                                        <span class="badge bg-info-subtle text-info">Reviewed</span>
                                    @elseif($app->status == 'rejected')
                                        <span class="badge bg-danger-subtle text-danger">Rejected</span>
                                    @elseif($app->status == 'accepted')
                                        <span class="badge bg-success-subtle text-success">Accepted</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('admin.job-applications.show', $app->id) }}"
                                        class="btn btn-sm btn-light text-primary me-1" title="Lihat Detail"><i
                                            class="fas fa-eye"></i></a>
                                    @can('delete.lamaran')
                                    <form action="{{ route('admin.job-applications.destroy', $app->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus lamaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger" title="Hapus"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted py-5 text-center">
                                    <i class="fas fa-inbox fs-1 d-block mb-3"></i>
                                    Belum ada lamaran masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer border-0 bg-white py-3">
            {{ $applications->links() }}
        </div>
    </div>
@endsection
