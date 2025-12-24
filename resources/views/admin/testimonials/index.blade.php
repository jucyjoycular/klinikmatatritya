@extends('layouts.admin')

@section('title', 'Manajemen Testimonial - Admin Panel')
@section('header_title', 'Manajemen Testimonial')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-bold">Daftar Testimonial</h6>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Baru
        </a>
    </div>
    <div class="card-body p-0">
        @if(session('success'))
            <div class="alert alert-success m-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 py-3 ps-4" style="width: 50px;">No</th>
                        <th class="border-0 py-3">Gambar</th>
                        <th class="border-0 py-3">Name</th>
                        <th class="border-0 py-3">Title</th>
                        <th class="border-0 py-3">Content</th>
                        <th class="border-0 py-3 pe-4 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                    <tr>
                        <td class="ps-4">{{ $loop->iteration + ($testimonials->currentPage() - 1) * $testimonials->perPage() }}</td>
                        <td>
                            @if($testimonial->avatar)
                                <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="Thumbnail" class="rounded" width="60" height="40" style="object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 40px;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $testimonial->name }}</div>
                        </td>

                         <td>
                            <div class="fw-bold text-dark">{{ $testimonial->title }}</div>
                        </td>

                         <td>
                            <div class="fw-bold text-dark">{{ $testimonial->content }}</div>
                        </td>
                       
                        <td class="pe-4 text-end">
                            <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="btn btn-sm btn-light text-primary me-1"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus Testimonial ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-newspaper fs-1 mb-3 d-block"></i>
                            Belum ada Testimonial Testimonial.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $testimonials->links() }}
    </div>
</div>
@endsection
