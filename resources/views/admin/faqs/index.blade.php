@extends('layouts.admin')

@section('title', 'Manajemen FAQ - Admin Panel')
@section('header_title', 'Manajemen FAQ')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between bg-white py-3">
            <h6 class="fw-bold mb-0">Daftar FAQ</h6>
            <div>
                @can('create.kategori-faq')
                <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Kategori
                </a>
                @endcan
                @can('create.faq')
                <a href="{{ route('admin.faqs.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Baru
                </a>
                @endcan
            </div>
        </div>
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table-hover mb-0 table align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 ps-4" style="width: 50px;">No</th>
                            <th class="border-0 py-3">Kategori</th>
                            <th class="border-0 py-3">Pertanyaan</th>
                            <th class="border-0 py-3">Jawaban</th>
                            <th class="border-0 py-3">Status</th>
                            <th class="border-0 py-3 pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $faq)
                            <tr>
                                <td class="ps-4">{{ $loop->iteration + ($faqs->currentPage() - 1) * $faqs->perPage() }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary text-light">
                                        {{ $faq->faqCategory->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $faq->question }}</div>
                                </td>
                                <td>
                                    <div class="text-muted small text-truncate" style="max-width: 300px;">
                                        {{ $faq->answer }}
                                    </div>
                                </td>
                                <td>
                                    @if ($faq->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    @can('update.faq')
                                        <a href="{{ route('admin.faqs.edit', $faq->id) }}"
                                            class="btn btn-sm btn-light text-primary me-1"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('delete.faq')
                                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
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
                                <td colspan="6" class="text-muted py-5 text-center">
                                    <i class="fas fa-question-circle fs-1 d-block mb-3"></i>
                                    Belum ada data FAQ.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
