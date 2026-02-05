@extends('admin.layout.main')
@section('title', 'Roles')

@push('styles')
    <style>
        .details-row {
            background-color: #f8f9fa;
            padding: 15px;
        }

        .permission-badge {
            margin: 3px;
            font-size: 13px;
        }

        .expand-permissions i {
            transition: transform 0.3s;
        }

        .expand-permissions.expanded i {
            transform: rotate(180deg);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline">
                <div class="card-header">
                    <h3 class="card-title">Daftar Roles</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Role
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive">
                                <table class="table-bordered table-hover table" id="roles-table">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Nama</th>
                                            <th>Guard</th>
                                            <th>Jumlah User</th>
                                            <th>Jumlah Permissions</th>
                                            <th>Dibuat</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk menampilkan users --}}
    <div class="modal fade" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="usersModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="usersModalLabel">
                        <i class="fas fa-users"></i> User dengan Role: <span id="role-name"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table-bordered table-striped table" id="users-table-modal">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Nama</th>
                                    <th>UserName</th>
                                    <th>Desa</th>
                                    <th>Terdaftar Sejak</th>
                                </tr>
                            </thead>
                            <tbody id="users-tbody">
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <i class="fas fa-spinner fa-spin"></i> Loading...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#roles-table').DataTable({
                responsive: false,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ordering: true,
                paging: true,
                searching: true,
                info: true,
                ajax: "{{ route('admin.roles.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'guard_name',
                        name: 'guard_name',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'users_count_link',
                        name: 'users_count',
                        orderable: true,
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'permissions_count_expand',
                        name: 'permissions_count',
                        orderable: true,
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        class: 'text-center nowrap',
                    }
                ],
            });

            // Handle view users modal
            $('#roles-table').on('click', '.view-users', function() {
                var roleId = $(this).data('id');

                // Reset modal content
                $('#users-tbody').html(
                    '<tr><td colspan="4" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>'
                );
                $('#usersModal').modal('show');

                // Fetch users data
                $.ajax({
                    url: "{{ route('admin.roles.get.users', '') }}/" + roleId,
                    type: 'GET',
                    success: function(response) {
                        $('#role-name').text(response.role_name);

                        if (response.users.length > 0) {
                            var html = '';
                            $.each(response.users, function(index, user) {
                                html += '<tr>';
                                html += '<td>' + (index + 1) + '</td>';
                                html += '<td>' + user.name + '</td>';
                                html += '<td>' + user.username + '</td>';
                                html += '<td>' + user.namadesa + '</td>';
                                html += '<td>' + moment(user.created_at).format(
                                    'DD MMM YYYY') + '</td>';
                                html += '</tr>';
                            });
                            $('#users-tbody').html(html);
                        } else {
                            $('#users-tbody').html(
                                '<tr><td colspan="4" class="text-center">Tidak ada user</td></tr>'
                            );
                        }
                    },
                    error: function() {
                        $('#users-tbody').html(
                            '<tr><td colspan="4" class="text-center text-danger">Gagal memuat data</td></tr>'
                        );
                    }
                });
            });

            // Handle expand permissions
            var expandedRows = {};

            $('#roles-table').on('click', '.expand-permissions', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var roleId = $(this).data('id');

                if (row.child.isShown()) {
                    // Close this row
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).removeClass('expanded');
                    $(this).find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                    delete expandedRows[roleId];
                } else {
                    // Open this row
                    $(this).addClass('expanded');
                    $(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');

                    if (expandedRows[roleId]) {
                        // Use cached data
                        row.child(expandedRows[roleId]).show();
                        tr.addClass('shown');
                    } else {
                        // Fetch permissions data
                        row.child(
                            '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading permissions...</div>'
                        ).show();
                        tr.addClass('shown');

                        $.ajax({
                            url: "{{ route('admin.roles.get.permissions', '') }}/" + roleId,
                            type: 'GET',
                            success: function(response) {
                                var html = '<div class="details-row">';
                                html +=
                                    '<strong><i class="fas fa-key"></i> Permissions:</strong><br>';

                                if (response.permissions.length > 0) {
                                    $.each(response.permissions, function(index, permission) {
                                        html +=
                                            '<span class="badge badge-primary permission-badge">' +
                                            permission.name + '</span>';
                                    });
                                } else {
                                    html +=
                                        '<span class="text-muted">Tidak ada permission</span>';
                                }

                                html += '</div>';

                                expandedRows[roleId] = html;
                                row.child(html).show();
                            },
                            error: function() {
                                row.child(
                                    '<div class="details-row text-danger">Gagal memuat permissions</div>'
                                ).show();
                            }
                        });
                    }
                }
            });

            $('#roles-table').on('click', '.btn-delete', function() {

                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Role yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {

                    if (result.isConfirmed) {

                        let url = "{{ route('admin.roles.destroy', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function() {
                                Swal.showLoading();
                            },
                            success: function(response) {
                                if (response.success) {
                                    table.ajax.reload();
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan saat menghapus data'
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
