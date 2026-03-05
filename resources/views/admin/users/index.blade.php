@extends('layouts.admin')

@section('title', 'Manajemen Users - Admin Panel')
@section('header_title', 'Manajemen Users')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title">Daftar Users</h6>

                @can('create.user')
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah User
                    </a>
                @endcan
            </div>

            <div class="card-body">
                @if($users->count() > 0)
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:5%; text-align:center;">No</th>
                                <th>Nama Users</th>
                                <th style="width:20%; text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                                <tr id="row-{{ $user->id }}">
                                    <td style="text-align:center">{{ $key + 1 }}</td>
                                    <td class="user-name">{{ $user->name }}</td>
                                    <td style="text-align:center;">
                                        @can('update.user')
                                            <button
                                                class="btn btn-warning btn-xs btn-edit"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endcan

                                        @can('hakAkses.user')
                                            <a href="{{ route('admin.permissions.edit', $user->id) }}" class="btn btn-info btn-xs">
                                                <i class="fas fa-lock"></i>
                                            </a>
                                        @endcan

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            @can('delete.user')
                                                <button class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">
                        Belum ada users
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<!-- ================= MODAL EDIT ================= -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm">
                @csrf
                <input type="hidden" id="edit_id">

                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div id="errorMessages" class="alert alert-danger d-none"></div>

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" id="edit_email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                    </div>

                    <div class="mb-3">
                        <label>Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('editModal'));

    // Buka modal edit
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const email = this.dataset.email;

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('errorMessages').classList.add('d-none');

            modal.show();
        });
    });

    // Submit AJAX edit
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const id = document.getElementById('edit_id').value;
        const formData = new FormData(this);
        formData.append('_method', 'PUT');

        fetch("{{ url('admin/users') }}/" + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.errors) {
                const errorBox = document.getElementById('errorMessages');
                errorBox.classList.remove('d-none');
                errorBox.innerHTML = '';
                Object.values(data.errors).forEach(err => {
                    errorBox.innerHTML += err + '<br>';
                });
            } else {
                const name = document.getElementById('edit_name').value;
                const email = document.getElementById('edit_email').value;

                // Update tabel
                document.querySelector('#row-' + id + ' .user-name').textContent = name;

                // Update data-* tombol edit
                const btn = document.querySelector('#row-' + id + ' .btn-edit');
                btn.dataset.name = name;
                btn.dataset.email = email;

                modal.hide();
                alert('User berhasil diupdate');
            }
        })
        .catch(err => console.log(err));
    });
});
</script>
@endsection