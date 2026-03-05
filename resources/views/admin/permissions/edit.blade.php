@extends('layouts.admin')

@section('title', 'Edit Permissions - Admin Panel')
@section('header_title', 'Edit Permissions')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-header mb-2">
                    <h6 class="card-title">Edit Permissions user {{ $user->name }}</h6>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form id="permissionsForm" action="{{ route('admin.permissions.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Select All --}}
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="selectAll">
                        <label class="form-check-label fw-bold" for="selectAll">Pilih Semua Akses</label>
                    </div>

                    @if($permissions->count() > 0)
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input permission-checkbox border-dark"
                                               name="permissions[]"
                                               value="{{ $permission->name }}"
                                               id="perm_{{ $permission->id }}"
                                               {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ ucfirst(str_replace(['-', '_'], ' ', $permission->name)) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle"></i> Tidak ada permission yang tersedia.
                        </div>
                    @endif

                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

    // Function to update Select All state
    function updateSelectAllState() {
        if (permissionCheckboxes.length === 0) {
            selectAllCheckbox.checked = false;
            return;
        }
        
        const checkedCount = document.querySelectorAll('.permission-checkbox:checked').length;
        const totalCount = permissionCheckboxes.length;
        
        selectAllCheckbox.checked = (checkedCount === totalCount);
        selectAllCheckbox.indeterminate = (checkedCount > 0 && checkedCount < totalCount);
    }

    // Initialize Select All state on page load
    updateSelectAllState();

    // Select All click event
    selectAllCheckbox.addEventListener('click', function() {
        const isChecked = this.checked;
        permissionCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
    });

    // Individual checkbox click event
    permissionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function() {
            updateSelectAllState();
        });
    });
});
</script>
@endsection