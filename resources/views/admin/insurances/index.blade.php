@extends('layouts.admin')

@section('title', 'Pilihan Asuransi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pilihan Asuransi</h1>
        @can('create.asuransi')
        <a href="{{ route('admin.insurances.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Asuransi
        </a>    
        @endcan
    </div>

    <div class="card mb-4 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table-bordered table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Logo</th>
                            <th>Nama (Optional)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($insurances as $insurance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ Storage::url($insurance->logo) }}" alt="{{ $insurance->name }}"
                                        width="100">
                                </td>
                                <td>{{ $insurance->name ?? '-' }}</td>
                                <td>
                                    @can('update.asuransi')
                                    <a href="{{ route('admin.insurances.edit', $insurance->id) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('delete.asuransi')
                                    <form action="{{ route('admin.insurances.destroy', $insurance->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data asuransi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $insurances->links() }}
            </div>
        </div>
    </div>
@endsection
