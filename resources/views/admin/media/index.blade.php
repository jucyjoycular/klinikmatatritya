@extends('layouts.admin')

@section('title', 'Kelola Media - Admin Panel')
@section('header_title', 'Kelola Media')

@section('content')

<style>
    /* Card table modern */
    .media-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 20px;
        overflow-x: auto;
    }

    .media-card table {
        min-width: 600px;
    }

    .media-card thead th {
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        text-align: center;
        padding: 16px;
    }

    .media-card tbody td {
        padding: 14px;
        vertical-align: middle;
    }

    .media-card tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
        transition: all 0.2s;
    }

    .media-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
        transition: transform 0.2s;
    }

    .media-thumb:hover {
        transform: scale(1.1);
    }

    .filename-cell {
        font-size: 0.95rem;
        color: #343a40;
        word-break: break-word;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid #dee2e6;
        background: #fff;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        color: #495057;
        font-size: 18px;
    }

    .action-btn:hover {
        border-color: #0d6efd;
        color: #0d6efd;
        background-color: #e7f1ff;
    }

    .action-btn.delete:hover {
        border-color: #dc3545;
        color: #dc3545;
        background-color: #fcebea;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 60px;
        margin-bottom: 20px;
        opacity: 0.4;
    }

    /* Modal styling */
    .modal-content img {
        border-radius: 12px;
        max-height: 70vh;
        object-fit: contain;
    }

    /* Warning styles */
    .warning-box {
        background-color: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 8px;
        padding: 14px;
        margin-bottom: 16px;
    }

    .warning-title {
        font-weight: 600;
        color: #856404;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .usage-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .usage-list li {
        padding: 8px 0;
        border-bottom: 1px solid #ffeaa7;
        font-size: 0.9rem;
        color: #333;
    }

    .usage-list li:last-child {
        border-bottom: none;
    }

    .usage-type {
        font-weight: 600;
        color: #0d6efd;
    }

    .usage-name {
        color: #555;
        margin-left: 4px;
    }
</style>

@if($media->count() > 0)
    <div class="media-card">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">No</th>
                    <th style="width: 90px;">Gambar</th>
                    <th>Filename</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($media as $item)
                <tr>
                    <td class="text-center text-muted">
                        {{ $loop->iteration + ($media->currentPage() - 1) * $media->perPage() }}
                    </td>
                    <td class="text-center">
                        <img src="{{ Storage::url($item->filepath) }}" class="media-thumb" alt="{{ $item->filename }}">
                    </td>
                    <td>
                        <span class="filename-cell">{{ $item->filename }}</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn" onclick="previewImage('{{ Storage::url($item->filepath) }}')" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn delete" onclick="confirmDelete({{ $item->id }})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <nav class="mt-4" aria-label="Page navigation">
        {{ $media->links('pagination::bootstrap-4') }}
    </nav>

@else
    <div class="empty-state">
        <div>
            <i class="fas fa-image"></i>
            <h4>Belum ada gambar</h4>
            <p>Gambar yang diupload dari fitur lain akan muncul di sini.</p>
        </div>
    </div>
@endif

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="previewModalLabel">Pratinjau Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImg" src="" alt="Preview Gambar">
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="deleteMessageContainer"></div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="deleteBtn" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteId = null;
    const previewModalEl = document.getElementById('previewModal');
    const deleteModalEl = document.getElementById('deleteModal');
    let previewModal = null;
    let deleteModal = null;

    // Initialize modals setelah DOM ready
    document.addEventListener('DOMContentLoaded', function () {
        previewModal = new bootstrap.Modal(previewModalEl);
        deleteModal = new bootstrap.Modal(deleteModalEl);

        // Handle delete button click
        document.getElementById('deleteBtn').addEventListener('click', function () {
            if (!deleteId) return;

            // Disable button saat proses
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';

            fetch('/admin/media/' + deleteId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                     force:true 
                })
            })
            .then(response => response.json())
            .then(data => {
                // Tutup modal
                deleteModal.hide();

                if (data.status === 'success') {
                    location.reload();
                } else {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                deleteModal.hide();
                alert('Terjadi kesalahan saat menghapus media.');
            })
            .finally(() => {
                // Enable button kembali
                document.getElementById('deleteBtn').disabled = false;
                document.getElementById('deleteBtn').innerHTML = '<i class="fas fa-trash"></i> Hapus';
            });
        });
    });

    function previewImage(src) {
        if (previewModal) {
            document.getElementById('previewImg').src = src;
            previewModal.show();
        }
    }

    function confirmDelete(id) {
        if (!deleteModal) return;

        deleteId = id;
        const messageContainer = document.getElementById('deleteMessageContainer');
        
        // Show loading
        messageContainer.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memproses...</div>';
        deleteModal.show();

        // Fetch usage info
        fetch('/admin/media/' + id + '/usage', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            let html = '';

            if (data.status === 'used' && data.usage_list && data.usage_list.length > 0) {
                // Ada warning
                html = `
                    <div class="warning-box">
                        <div class="warning-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            Perhatian!
                        </div>
                        <p style="margin: 10px 0; color: #856404;">
                            Gambar ini sedang digunakan di <strong>${data.usage_count} fitur</strong>. 
                            Jika Anda menghapusnya, gambar akan dihapus di seluruh fitur berikut:
                        </p>
                        <ul class="usage-list">
                `;

                data.usage_list.forEach(usage => {
                    html += `
                        <li>
                            <span class="usage-type">${usage.type}</span>
                            <span class="usage-name">- ${usage.name}</span>
                        </li>
                    `;
                });

                html += `
                        </ul>
                        <p style="margin: 12px 0 0 0; color: #856404; font-weight: 500;">
                            <i class="fas fa-info-circle"></i> Apakah Anda yakin ingin menghapus gambar ini dari semua fitur tersebut?
                        </p>
                    </div>
                `;
            } else {
                // Tidak ada warning
                html = `<p style="margin: 0;">Apakah kamu yakin ingin menghapus gambar ini?</p>`;
            }

            messageContainer.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            messageContainer.innerHTML = '<p style="margin: 0;">Apakah kamu yakin ingin menghapus gambar ini?</p>';
        });
    }
</script>

@endsection