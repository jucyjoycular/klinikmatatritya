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
                        <div class="d-flex gap-2 mb-2">
                            <input type="file" 
                                   class="form-control" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*">
                            <button type="button" 
                                    class="btn btn-outline-primary" 
                                    id="browseMediaBtn"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#mediaModal">
                                <i class="fas fa-images me-1"></i>Browse Media
                            </button>
                        </div>
                        <input type="hidden" name="media_id" id="footer_media_id">
                        <small class="form-text text-muted d-block mt-1">
                            <i class="fas fa-info-circle me-1"></i>Format: JPG, JPEG, PNG. Maksimal: 2MB<br>
                            <i class="fas fa-exclamation-triangle me-1"></i>Preview gambar akan muncul, tapi tidak akan tersimpan sampai Anda klik <strong>"Simpan Perubahan"</strong>
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

<!-- Media Browser Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Media Library</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if(isset($media) && $media->count())
                <div class="row g-3">
                    @foreach($media as $item)
                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="media-card border rounded p-1"
                             data-id="{{ $item->id }}"
                             data-path="{{ asset('storage/'.$item->filepath) }}">
                            <img src="{{ asset('storage/'.$item->filepath) }}"
                                 class="img-fluid rounded"
                                 style="height:120px; width:100%; object-fit:cover;">
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                    <div class="text-center text-muted">
                        Belum ada media tersedia.
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" id="selectMediaBtn" disabled>
                    Gunakan Gambar Ini
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<style>
    .media-card {
        cursor: pointer;
        transition: 0.2s;
    }
    .media-card:hover {
        transform: scale(1.05);
    }
    .media-card.selected {
        border: 3px solid #0d6efd !important;
    }
    #mediaModal .modal-body {
        max-height: 70vh;
    }
</style>

<script>
let footerEditor;
let selectedMediaId = null;
let selectedMediaPath = null;
let isSwitchingToMediaModal = false;

$(document).ready(function() {
    ClassicEditor.create(document.querySelector('#content'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'link',
            'bulletedList', 'numberedList',
            'blockQuote', '|',
            'undo', 'redo'
        ]
    })
    .then(editor => {
        footerEditor = editor;
    })
    .catch(error => {
        console.error(error);
    });

    // === Media Browser Handlers ===
    $(document).on('click', '.media-card', function() {
        $('.media-card').removeClass('selected');
        $(this).addClass('selected');
        
        selectedMediaId = $(this).data('id');
        selectedMediaPath = $(this).data('path');
        
        $('#selectMediaBtn').prop('disabled', false);
    });

    $('#selectMediaBtn').on('click', function() {
        $('#footer_media_id').val(selectedMediaId);
        
        if (selectedMediaPath) {
            $('#current-image').html(`
                <div class="card bg-light border">
                    <div class="card-body p-3">
                        <p class="mb-2 fw-semibold text-dark">
                            <i class="fas fa-image me-1"></i>Gambar dari Media Library (Belum Tersimpan):
                        </p>
                        <img src="${selectedMediaPath}" alt="Selected Media" 
                            class="img-fluid rounded shadow-sm" 
                            style="max-width: 100%; max-height: 250px; object-fit: contain;">
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>Klik "Simpan Perubahan" untuk menyimpan gambar ini
                        </small>
                    </div>
                </div>
            `);
        }
        
        // Reset file input karena pakai media library
        $('#image').val('');
        
        // Close media modal and return to footer modal
        const mediaModal = bootstrap.Modal.getInstance(document.getElementById('mediaModal'));
        if (mediaModal) {
            mediaModal.hide();
        }
        
        // Ensure footer modal stays open
        setTimeout(function() {
            const footerModal = bootstrap.Modal.getInstance(document.getElementById('footerModal'));
            if (!footerModal) {
                const footerModalElement = document.getElementById('footerModal');
                const newFooterModal = new bootstrap.Modal(footerModalElement);
                newFooterModal.show();
            } else {
                footerModal.show();
            }
            // Remove extra backdrop if any
            const backdrops = document.querySelectorAll('.modal-backdrop');
            if (backdrops.length > 1) {
                backdrops[backdrops.length - 1].remove();
            }
        }, 300);
    });

    $('#browseMediaBtn').on('click', function() {
        isSwitchingToMediaModal = true;
        // Reset file input saat buka modal
        $('#image').val('');
    });

    // Preview upload manual
    $('#image').on('change', function(e) {
        if (e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                $('#current-image').html(`
                    <div class="card bg-light border">
                        <div class="card-body p-3">
                            <p class="mb-2 fw-semibold text-dark">
                                <i class="fas fa-image me-1"></i>Preview Gambar Upload (Belum Tersimpan):
                            </p>
                            <img src="${evt.target.result}" alt="Preview" 
                                class="img-fluid rounded shadow-sm" 
                                style="max-width: 100%; max-height: 250px; object-fit: contain;">
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>Klik "Simpan Perubahan" untuk menyimpan gambar ini
                            </small>
                        </div>
                    </div>
                `);
            };
            reader.readAsDataURL(e.target.files[0]);
            
            // Reset media_id karena pakai upload manual
            $('#footer_media_id').val('');
        }
    });

    $(document).on('click', '.btn-view', function() {
        
        const id = $(this).data('id');
        const slug = $(this).data('slug');
        const title = $(this).data('title');
        const content = $(this).data('content');
        const image = $(this).data('image');

        $('#footerForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty().hide();
        
        // Reset media selection
        $('#footer_media_id').val('');
        selectedMediaId = null;
        selectedMediaPath = null;

        $('#section_id').val(id);
        $('#section_slug').val(slug);
        $('#section_name').val(slug ? slug.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : '');
        $('#title').val(title || '');
        $('#content').val(content || '');

        if (footerEditor) {
            footerEditor.setData(content || '');
        }

        if (image && image !== '') {
            $('#current-image').html(`
                <div class="card bg-light border">
                    <div class="card-body p-3">
                        <p class="mb-2 fw-semibold text-dark">
                            <i class="fas fa-image me-1 text-success"></i>Gambar Tersimpan:
                        </p>
                        <img src="/storage/${image}" alt="Current Image" 
                            class="img-fluid rounded shadow-sm" 
                            style="max-width: 100%; max-height: 250px; object-fit: contain;">
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-check-circle me-1 text-success"></i>Gambar ini sudah tersimpan di database
                        </small>
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
        
        // console.log('Modal shown'); // Debug log
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
        formData.append('content', footerEditor ? footerEditor.getData() : '');
        
        // Add image if selected
        const imageFile = $('#image')[0].files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }
        
        // Add media_id if selected from media library
        const mediaId = $('#footer_media_id').val();
        if (mediaId) {
            formData.append('media_id', mediaId);
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
        if (isSwitchingToMediaModal) {
            return;
        }

        $('#footerForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty().hide();
        $('#current-image').empty();
        $('#footer_media_id').val('');
        selectedMediaId = null;
        selectedMediaPath = null;
    });
    
    // Reset media selection when media modal is closed
    $('#mediaModal').on('hidden.bs.modal', function() {
        $('.media-card').removeClass('selected');
        $('#selectMediaBtn').prop('disabled', true);
        
        // Ensure footer modal stays open after media modal closes
        if (!$('#footerModal').hasClass('show')) {
            const footerModal = bootstrap.Modal.getInstance(document.getElementById('footerModal'));
            if (footerModal) {
                footerModal.show();
            }
        }
        
        // Clean up any extra backdrops
        setTimeout(function() {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            if (backdrops.length > 1) {
                for (let i = 1; i < backdrops.length; i++) {
                    backdrops[i].remove();
                }
            }
            // Ensure body has modal-open class if footer modal is open
            if ($('#footerModal').hasClass('show')) {
                $('body').addClass('modal-open');
            }
            isSwitchingToMediaModal = false;
        }, 100);
    });
    
    // When media modal is shown, don't hide footer modal
    $('#mediaModal').on('show.bs.modal', function() {
        // Keep body modal-open class
        $('body').addClass('modal-open');
    });
});
</script>
@endpush