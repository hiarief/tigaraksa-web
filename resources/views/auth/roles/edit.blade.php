@extends('admin.layout.main')
@section('title', 'Edit Role')

@push('styles')
    <style>
        .permission-group {
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #f8f9fa;
        }

        .permission-group-header {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
            color: #495057;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }

        .permission-item {
            padding: 5px 0;
        }

        .select-all-btn {
            margin-top: 5px;
        }

        .stats-box {
            background: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .badge-counter {
            font-size: 14px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-shield"></i> Edit Role: {{ $role->name }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" id="roleForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            {{-- Kolom Kiri: Form Role --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Nama Role <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $role->name) }}"
                                        placeholder="admin, manager, user" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> Gunakan huruf kecil tanpa spasi
                                    </small>
                                </div>

                                {{-- Statistics Box --}}
                                <div class="stats-box">
                                    <h6 class="mb-2">
                                        <i class="fas fa-chart-pie"></i> Statistik Permission
                                    </h6>
                                    <div class="d-flex justify-content-between">
                                        <span>Dipilih:</span>
                                        <span class="badge badge-primary badge-counter" id="selected-count">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Total:</span>
                                        <span class="badge badge-secondary badge-counter" id="total-count">
                                            {{ $permissions->flatten()->count() }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Quick Actions --}}
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-bolt"></i> Quick Actions
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <button type="button" class="btn btn-sm btn-success btn-block" id="selectAll">
                                            <i class="fas fa-check-double"></i> Pilih Semua
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning btn-block" id="deselectAll">
                                            <i class="fas fa-times"></i> Hapus Semua
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Kolom Kanan: Permissions Grouped --}}
                            <div class="col-md-8">
                                <h5 class="mb-3">
                                    <i class="fas fa-key"></i> Pilih Permissions
                                </h5>

                                {{-- Search Box --}}
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="searchPermission"
                                            placeholder="Cari permission...">
                                    </div>
                                </div>

                                {{-- Permissions by Group --}}
                                <div id="permissionsContainer">
                                    @foreach ($permissions as $group => $perms)
                                        <div class="permission-group" data-group="{{ $group }}">
                                            <div class="permission-group-header">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <i class="fas fa-folder-open text-primary"></i>
                                                        {{ ucfirst($group) }}
                                                    </span>
                                                    <div>
                                                        <span class="badge badge-info">{{ $perms->count() }} items</span>
                                                        <button type="button"
                                                            class="btn btn-xs btn-outline-primary select-group"
                                                            data-group="{{ $group }}">
                                                            <i class="fas fa-check"></i> Pilih Semua
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach ($perms as $permission)
                                                    <div class="col-md-6 permission-item"
                                                        data-permission="{{ strtolower($permission->name) }}">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input permission-checkbox"
                                                                type="checkbox" name="permissions[]"
                                                                value="{{ $permission->name }}"
                                                                id="perm{{ $permission->id }}"
                                                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                                            <label class="custom-control-label"
                                                                for="perm{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($permissions->isEmpty())
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Belum ada permission yang tersedia.
                                        <a href="{{ route('admin.permissions.create') }}">Tambah permission</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Role
                        </button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Update counter
            function updateCounter() {
                var selectedCount = $('.permission-checkbox:checked').length;
                $('#selected-count').text(selectedCount);
            }

            // Initial count saat halaman load
            updateCounter();

            // Update button text untuk setiap group
            function updateGroupButtons() {
                $('.permission-group').each(function() {
                    var group = $(this).data('group');
                    var groupCheckboxes = $(this).find('.permission-checkbox');
                    var checkedCount = groupCheckboxes.filter(':checked').length;
                    var totalCount = groupCheckboxes.length;
                    var groupButton = $('.select-group[data-group="' + group + '"]');

                    if (checkedCount === totalCount && totalCount > 0) {
                        groupButton.html('<i class="fas fa-times"></i> Hapus Semua');
                        groupButton.removeClass('btn-outline-primary').addClass('btn-outline-danger');
                    } else {
                        groupButton.html('<i class="fas fa-check"></i> Pilih Semua');
                        groupButton.removeClass('btn-outline-danger').addClass('btn-outline-primary');
                    }
                });
            }

            // Initial update button state
            updateGroupButtons();

            // Select all permissions
            $('#selectAll').click(function() {
                $('.permission-checkbox').prop('checked', true);
                updateCounter();
                updateGroupButtons();
            });

            // Deselect all permissions
            $('#deselectAll').click(function() {
                $('.permission-checkbox').prop('checked', false);
                updateCounter();
                updateGroupButtons();
            });

            // Select all in group
            $('.select-group').click(function() {
                var group = $(this).data('group');
                var groupCheckboxes = $('.permission-group[data-group="' + group +
                    '"] .permission-checkbox');
                var allChecked = groupCheckboxes.length === groupCheckboxes.filter(':checked').length;

                if (allChecked) {
                    groupCheckboxes.prop('checked', false);
                    $(this).html('<i class="fas fa-check"></i> Pilih Semua');
                    $(this).removeClass('btn-outline-danger').addClass('btn-outline-primary');
                } else {
                    groupCheckboxes.prop('checked', true);
                    $(this).html('<i class="fas fa-times"></i> Hapus Semua');
                    $(this).removeClass('btn-outline-primary').addClass('btn-outline-danger');
                }
                updateCounter();
            });

            // Update counter on checkbox change
            $('.permission-checkbox').on('change', function() {
                updateCounter();
                updateGroupButtons();
            });

            // Search functionality
            $('#searchPermission').on('keyup', function() {
                var searchText = $(this).val().toLowerCase();

                if (searchText === '') {
                    $('.permission-group').show();
                    $('.permission-item').show();
                } else {
                    $('.permission-item').each(function() {
                        var permissionName = $(this).data('permission');
                        if (permissionName.indexOf(searchText) > -1) {
                            $(this).show();
                            $(this).closest('.permission-group').show();
                        } else {
                            $(this).hide();
                        }
                    });

                    // Hide groups with no visible items
                    $('.permission-group').each(function() {
                        if ($(this).find('.permission-item:visible').length === 0) {
                            $(this).hide();
                        }
                    });
                }
            });

            // Form validation
            $('#roleForm').submit(function(e) {
                var roleName = $('#name').val().trim();

                if (roleName === '') {
                    e.preventDefault();
                    alert('Nama role harus diisi!');
                    $('#name').focus();
                    return false;
                }

                // Check if name contains spaces
                if (roleName.indexOf(' ') >= 0) {
                    e.preventDefault();
                    alert('Nama role tidak boleh mengandung spasi!');
                    $('#name').focus();
                    return false;
                }
            });
        });
    </script>
@endpush
