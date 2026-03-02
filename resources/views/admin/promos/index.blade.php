@extends('layouts.admin')

@section('title', 'Kelola Promo - Admin Panel')
@section('header_title', 'Kelola Promo')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0 fw-bold">Daftar Promo</h5>
                    <a href="{{ route('admin.promos.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Promo
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="15%">Gambar</th>
                                <th scope="col" width="25%">Judul Promo</th>
                                <th scope="col" width="15%">Harga</th>
                                <th scope="col" width="20%">Periode</th>
                                <th scope="col" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($promos as $promo)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($promo->image)
                                        <img src="{{ asset('storage/' . $promo->image) }}" alt="Promo" class="rounded" width="80" height="50" style="object-fit: cover;">
                                    @else
                                        <span class="text-muted small">No Image</span>
                                    @endif
                                </td>
                                <td class="fw-semibold">{{ $promo->title }}</td>
                                <td>
                                    @if($promo->price)
                                        Rp {{ number_format($promo->price, 0, ',', '.') }}
                                    @else
                                        <span class="badge bg-secondary">Gratis / TBD</span>
                                    @endif
                                </td>
                                <td>
                                    @if($promo->start_date && $promo->end_date)
                                        <small class="d-block text-muted">Mulai: {{ \Carbon\Carbon::parse($promo->start_date)->format('d M Y') }}</small>
                                        <small class="d-block text-muted">Selesai: {{ \Carbon\Carbon::parse($promo->end_date)->format('d M Y') }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.promos.edit', $promo->id) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus promo ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-tags fs-1 mb-3 d-block text-light-emphasis"></i>
                                    Belum ada data promo.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $promos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
