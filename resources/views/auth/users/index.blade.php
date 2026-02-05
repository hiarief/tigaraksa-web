@extends('admin.layout.main')
@section('title', 'Users')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline">
                <div class="card-header">
                    <h3 class="card-title">Daftar Users</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah User
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-bordered table-hover table" id="users-table">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Nama</th>
                                    <th>UserName</th>
                                    <th>Desa</th>
                                    <th>Roles</th>
                                    <th>Terdaftar</th>
                                    <th width="1%">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Delete Hidden --}}
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        $(function() {
            $('#users-table').DataTable({
                responsive: false,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ordering: true,
                paging: true,
                searching: true,
                info: true,
                ajax: "{{ route('admin.users.index') }}",
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
                        data: 'username',
                        name: 'username',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'namadesa',
                        name: 'namadesa',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                        orderable: false,
                        searchable: false,
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

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        });

        function deleteUser(id) {

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data user akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {

                if (result.isConfirmed) {

                    let url = "{{ route('admin.users.destroy', ':id') }}";
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

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });

                            $('#users-table').DataTable().ajax.reload();
                        },

                        error: function() {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus data.'
                            });

                        }
                    });

                }

            });
        }
    </script>
@endpush
