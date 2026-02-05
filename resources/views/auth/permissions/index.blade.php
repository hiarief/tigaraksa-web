@extends('admin.layout.main')
@section('title', 'Permissions')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline">
                <div class="card-header">
                    <h3 class="card-title">Daftar Permissions</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-danger mr-1" id="btn-delete-selected"
                            style="display: none;">
                            <i class="fas fa-trash"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                        </button>
                        <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Permission
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

                    <div class="table-responsive">
                        <table class="table-bordered table-hover table" id="permissions-table">
                            <thead>
                                <tr>
                                    <th style="width: 3%">
                                        <input type="checkbox" id="check-all">
                                    </th>
                                    <th style="width: 1%">No</th>
                                    <th>Nama</th>
                                    <th>Guard</th>
                                    <th>Digunakan di Role</th>
                                    <th>Dibuat</th>
                                    <th style="width: 1%">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            let selectedIds = [];

            // DataTable
            var table = $('#permissions-table').DataTable({
                responsive: false,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ordering: true,
                paging: true,
                searching: true,
                info: true,
                ajax: "{{ route('admin.permissions.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        class: 'text-center nowrap',
                        render: function(data, type, row) {
                            return '<input type="checkbox" class="permission-checkbox" value="' +
                                data + '">';
                        }
                    },
                    {
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
                        data: 'roles_count',
                        name: 'roles_count',
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

            // Check All
            $('#check-all').on('click', function() {
                let isChecked = $(this).prop('checked');
                $('.permission-checkbox').prop('checked', isChecked);
                updateSelectedIds();
            });

            // Individual Checkbox
            $('#permissions-table').on('change', '.permission-checkbox', function() {
                updateSelectedIds();

                // Update check-all status
                let totalCheckboxes = $('.permission-checkbox').length;
                let checkedCheckboxes = $('.permission-checkbox:checked').length;
                $('#check-all').prop('checked', totalCheckboxes === checkedCheckboxes);
            });

            // Update Selected IDs
            function updateSelectedIds() {
                selectedIds = [];
                $('.permission-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                $('#selected-count').text(selectedIds.length);

                if (selectedIds.length > 0) {
                    $('#btn-delete-selected').show();
                } else {
                    $('#btn-delete-selected').hide();
                }
            }

            // Delete Selected
            $('#btn-delete-selected').on('click', function() {
                if (selectedIds.length === 0) {
                    return;
                }

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Anda akan menghapus " + selectedIds.length + " permission sekaligus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.permissions.bulk-delete') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: selectedIds
                            },
                            success: function(response) {
                                if (response.success) {
                                    table.ajax.reload();
                                    selectedIds = [];
                                    $('#check-all').prop('checked', false);
                                    $('#btn-delete-selected').hide();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            },
                            error: function(xhr) {
                                let errorMessage =
                                    'Terjadi kesalahan saat menghapus data';

                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: errorMessage
                                });
                            }
                        });
                    }
                });
            });

            // Delete Single
            $('#permissions-table').on('click', '.btn-delete', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data permission akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = "{{ route('admin.permissions.destroy', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    table.ajax.reload();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message,
                                        timer: 2000,
                                        showConfirmButton: false
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

            // Reset checkboxes on page change
            table.on('draw', function() {
                $('#check-all').prop('checked', false);
                updateSelectedIds();
            });
        });
    </script>
@endpush
