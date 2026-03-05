@extends('layouts.admin')

@section('title', 'Manajemen Dokter - Admin Panel')
@section('header_title', 'Manajemen Dokter')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between bg-white py-3">
            <h6 class="fw-bold mb-0">Daftar Dokter</h6>
            @can('create.doctor')
            <a href="{{ route('admin.doctors.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Baru
            </a>    
            @endcan
        </div>
        <div class="card-body p-0">

            <div class="table-responsive">
                <table id="doctorsTable" class="table-striped table-hover nowrap mb-0 table align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 ps-4" style="width: 50px;" data-priority="1">No</th>
                            <th class="border-0 py-3" data-priority="4">Foto</th>
                            <th class="border-0 py-3" data-priority="2">Nama Dokter</th>
                            <th class="border-0 py-3">Spesialisasi</th>
                            <th class="border-0 py-3 pe-4 text-end" data-priority="3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctors as $doctor)
                            <tr>
                                <td class="ps-4">
                                    {{ $loop->iteration + ($doctors->currentPage() - 1) * $doctors->perPage() }}</td>
                                <td>
                                    @if ($doctor->photo)
                                        <img src="{{ asset('storage/' . $doctor->photo) }}" alt="Photo"
                                            class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-muted"
                                            style="width: 40px; height: 40px;">
                                            <i class="fas fa-user-md"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $doctor->name }}</div>
                                    <div class="small text-muted">{{ $doctor->phone ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info text-dark">
                                        {{ $doctor->specialty ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    @can('update.doctor')
                                        <a href="{{ route('admin.doctors.edit', $doctor->id) }}"
                                            class="btn btn-sm btn-light text-primary me-1"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('delete.doctor')
                                        <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST"
                                            class="d-inline">
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
                                    <i class="fas fa-user-md fs-1 d-block mb-3"></i>
                                    Belum ada data dokter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('#doctorsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthChange: true,
                autoWidth: false,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    zeroRecords: "Tidak ada data ditemukan",
                    paginate: {
                        previous: "←",
                        next: "→"
                    }
                }
            });
        });
    </script>

@endsection
