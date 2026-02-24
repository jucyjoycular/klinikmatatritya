@extends('layouts.admin')

@section('title', 'Pengaturan Footer - Klinik Mata Tritya')

@section('header_title', 'Pengaturan Footer')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold text-dark">
                    <i class="fas fa-th-list me-2"></i>Daftar Footer Section
                </h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 10%;" class="text-center">No</th>
                            <th style="width: 75%;">Nama Section</th>
                            <th style="width: 15%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $index => $section)
                        <tr>
                            <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-medium">{{ ucwords(str_replace('-', ' ', $section->slug)) }}</span>
                                @if($section->title)
                                    <br><small class="text-muted">{{ Str::limit($section->title, 50) }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" 
                                    class="btn btn-info btn-sm btn-view" 
                                    data-id="{{ $section->id }}"
                                    data-slug="{{ $section->slug }}"
                                    data-title="{{ $section->title ?? '' }}"
                                    data-content="{{ $section->content ?? '' }}"
                                    data-image="{{ $section->image ?? '' }}"
                                    title="View & Edit">
                                    <i class="fas fa-eye me-1"></i> View
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Tidak ada data footer section</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Edit Footer Section -->
<div class="modal fade" id="footerModal" tabindex="-1" aria-labelledby="footerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="footerModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Footer Section
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="footerForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="section_id" name="section_id">
                <input type="hidden" id="section_slug" name="section_slug">
                <div class="modal-body px-4 py-4" style="max-height: 70vh; overflow-y: auto;">
                    <div class="mb-4">
                        <label for="section_name" class="form-label fw-semibold">
                            <i class="fas fa-tag me-1 text-muted"></i>Nama Section
                        </label>
                        <input type="text" class="form-control bg-light" id="section_name" readonly>
                    </div>
                    
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">
                            <i class="fas fa-heading me-1 text-muted"></i>Title 
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="title" name="title" required 
                            placeholder="Masukkan judul footer section">
                        <div class="invalid-feedback" id="title-error"></div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="content" class="form-label fw-semibold">
                            <i class="fas fa-align-left me-1 text-muted"></i>Content
                        </label>
                        <textarea class="form-control" id="content" name="content" rows="3" 
                            placeholder="Masukkan konten footer section (opsional)"></textarea>
                        <div class="invalid-feedback" id="content-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold">
                            <i class="fas fa-image me-1 text-muted"></i>Image
                        </label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="form-text text-muted d-block mt-1">
                            <i class="fas fa-info-circle me-1"></i>Format: JPG, JPEG, PNG. Maksimal: 2MB
                        </small>
                        <div class="invalid-feedback" id="image-error"></div>
                        <div id="current-image" class="mt-3"></div>
                    </div>

                    <!-- Items Table Section (Promosi Only) -->
                    <div id="itemsSection" class="card bg-light border-0 mt-4" style="display: none;">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">
                                    <i class="fas fa-table me-2"></i>Data Promo
                                </h6>
                                <button type="button" class="btn btn-success btn-sm" id="addItemBtn">
                                    <i class="fas fa-plus me-1"></i>Tambah Baris
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0" id="itemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 35%;">Pemeriksaan</th>
                                            <th style="width: 20%;">Harga Normal</th>
                                            <th style="width: 20%;">Harga Promo</th>
                                            <th style="width: 15%;">Keterangan</th>
                                            <th style="width: 10%;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batalkan
                    </button>
                    <button type="submit" class="btn btn-primary px-4" id="saveBtn">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    console.log('Footer script loaded'); // Debug log
    
    // Handle click event untuk button view
    $(document).on('click', '.btn-view', function() {
        console.log('Button clicked'); // Debug log
        
        const id = $(this).data('id');
        const slug = $(this).data('slug');
        const title = $(this).data('title');
        const content = $(this).data('content');
        const image = $(this).data('image');
        
        console.log('Data:', { id, slug, title, content, image }); // Debug log

        // Reset form
        $('#footerForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty().hide();

        // Set data ke modal
        $('#section_id').val(id);
        $('#section_slug').val(slug);
        $('#section_name').val(slug ? slug.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : '');
        $('#title').val(title || '');
        $('#content').val(content || '');

        // Show current image if exists
        if (image && image !== '') {
            $('#current-image').html(`
                <div class="card bg-light border">
                    <div class="card-body p-3">
                        <p class="mb-2 fw-semibold text-dark">
                            <i class="fas fa-image me-1"></i>Gambar saat ini:
                        </p>
                        <img src="/storage/${image}" alt="Current Image" 
                            class="img-fluid rounded shadow-sm" 
                            style="max-width: 100%; max-height: 250px; object-fit: contain;">
                    </div>
                </div>
            `);
        } else {
            $('#current-image').empty();
        }
        
        // Load items only for promosi section
        if (slug === 'promo') {
            $('#itemsSection').show();
            loadItems(id);
        } else {
            $('#itemsSection').hide();
        }
        const modalElement = document.getElementById('footerModal');
        const footerModal = new bootstrap.Modal(modalElement);
        footerModal.show();
        
        console.log('Modal shown'); // Debug log
    });

    // Function to load items
    function loadItems(sectionId) {
        $.ajax({
            url: `/admin/settings/footer/${sectionId}/items`,
            type: 'GET',
            success: function(data) {
                const tbody = $('#itemsBody');
                tbody.empty();
                
                if (data.items && data.items.length > 0) {
                    data.items.forEach((item, index) => {
                        addItemRow(item.pemeriksaan, item.harga_normal, item.harga_promo, item.keterangan);
                    });
                } else {
                    addItemRow('', '', '', '');
                }
            }
        });
    }

    // Function to add item row
    function addItemRow(pemeriksaan = '', harga_normal = '', harga_promo = '', keterangan = '') {
        const tbody = $('#itemsBody');
        const rowHtml = `
            <tr>
                <td><input type="text" class="form-control form-control-sm" name="items[][pemeriksaan]" value="${pemeriksaan}" placeholder="Nama pemeriksaan"></td>
                <td><input type="number" class="form-control form-control-sm" name="items[][harga_normal]" value="${harga_normal}" placeholder="0" step="0.01" min="0"></td>
                <td><input type="number" class="form-control form-control-sm" name="items[][harga_promo]" value="${harga_promo}" placeholder="0" step="0.01" min="0"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[][keterangan]" value="${keterangan}" placeholder="Opsional"></td>
                <td class="text-center"><button type="button" class="btn btn-danger btn-sm deleteItemBtn"><i class="fas fa-trash"></i></button></td>
            </tr>
        `;
        tbody.append(rowHtml);
    }

    // Add item button click
    $(document).on('click', '#addItemBtn', function() {
        addItemRow();
    });

    // Delete item button click
    $(document).on('click', '.deleteItemBtn', function() {
        $(this).closest('tr').remove();
    });

    // Handle form submit dengan AJAX
    $('#footerForm').on('submit', function(e) {
        e.preventDefault();

        const id = $('#section_id').val();
        const form = this;
        const formData = new FormData();
        
        // Add CSRF token
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        
        // Add basic fields
        formData.append('title', $('#title').val());
        formData.append('content', $('#content').val());
        
        // Add image if selected
        const imageFile = $('#image')[0].files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }
        
        // Rebuild items array with sequential index
        let itemIndex = 0;
        $('#itemsBody tr').each(function() {
            const pemeriksaan = $(this).find('input[name="items[][pemeriksaan]"]').val();
            const harga_normal = $(this).find('input[name="items[][harga_normal]"]').val();
            const harga_promo = $(this).find('input[name="items[][harga_promo]"]').val();
            const keterangan = $(this).find('input[name="items[][keterangan]"]').val();
            
            if (pemeriksaan.trim() !== '') {
                formData.append(`items[${itemIndex}][pemeriksaan]`, pemeriksaan);
                formData.append(`items[${itemIndex}][harga_normal]`, harga_normal || 0);
                formData.append(`items[${itemIndex}][harga_promo]`, harga_promo || '');
                formData.append(`items[${itemIndex}][keterangan]`, keterangan || '');
                itemIndex++;
            }
        });
        
        // Disable button dan show loading
        $('#saveBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');
        
        // Reset validation errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty().hide();

        $.ajax({
            url: `/admin/settings/footer/${id}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Close modal
                        const modalElement = document.getElementById('footerModal');
                        const footerModal = bootstrap.Modal.getInstance(modalElement);
                        footerModal.hide();
                        
                        // Reload page to update data
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $(`#${key}`).addClass('is-invalid');
                        $(`#${key}-error`).text(value[0]).show();
                    });
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Gagal',
                        text: 'Mohon periksa kembali form Anda',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan!',
                    });
                }
            },
            complete: function() {
                // Enable button
                $('#saveBtn').prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan Perubahan');
            }
        });
    });

    // Reset form ketika modal ditutup
    $('#footerModal').on('hidden.bs.modal', function() {
        $('#footerForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty().hide();
        $('#current-image').empty();
    });
});
</script>
@endpush