@extends('admin.layout.main')
@section('title', 'Kartu Keluarga')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            @can('kepala-keluarga-create')
                                <a href="{{ route('kependudukan.kartu.keluarga.create') }}"
                                    class="btn btn-sm bg-gradient-primary">
                                    <i class="fa-solid fa-plus"></i> Tambah
                                </a>
                            @endcan
                            @can('kepala-keluarga-trash')
                                <a href="{{ route('kependudukan.kartu.keluarga.trash') }}" class="btn btn-sm bg-gradient-danger">
                                    <i class="fas fa-trash"></i> Data Terhapus
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Alert Success/Error --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="kartu-keluarga-table"
                            class="table-bordered table-hover table-striped rounded-0 table-sm table py-0 text-sm">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2" style="width: 1%">NO</th>
                                    <th rowspan="2" style="width: 1%">AKSI</th>
                                    <th colspan="2">NOMOR</th>
                                    <th rowspan="2">NAMA</th>
                                    <th rowspan="2">TGL LAHIR</th>
                                    <th rowspan="2">TEMPAT LAHIR</th>
                                    <th rowspan="2">ALAMAT</th>
                                </tr>
                                <tr class="text-center">
                                    <th>KK</th>
                                    <th>NIK</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // ============================================================
            // DATATABLE INITIALIZATION
            // ============================================================
            $('#kartu-keluarga-table').DataTable({
                responsive: false,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ordering: true,
                paging: true,
                searching: true,
                info: true,
                ajax: "{{ route('kependudukan.kartu.keluarga.index.data') }}",
                order: [
                    [8, 'desc'] // Order by created_at
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: '1%',
                        class: 'text-center nowrap',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        class: 'text-center nowrap',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'no_kk',
                        name: 't2.no_kk',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'no_nik',
                        name: 't1.no_nik',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'nama',
                        name: 't1.nama',
                        class: 'nowrap',
                    },
                    {
                        data: 'tgl_lahir',
                        name: 't1.tgl_lahir',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'tmpt_lahir',
                        name: 't1.tmpt_lahir',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'created_at',
                        name: 't1.created_at',
                        visible: false,
                        searchable: false
                    }
                ],
            });
        });

        // ============================================================
        // FUNCTION DELETE DATA
        // Menggunakan SweetAlert2 untuk konfirmasi yang lebih baik
        // ============================================================
        function deleteData(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Data Kartu Keluarga dan semua anggotanya akan dipindahkan ke tabel backup. Apakah Anda yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return $.ajax({
                        url: "{{ route('kependudukan.kartu.keluarga.delete', ':id') }}".replace(':id',
                            id),
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: 'json'
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    // Cek response dari server
                    if (result.value && result.value.success) {
                        // Berhasil dihapus
                        Swal.fire({
                            title: 'Berhasil!',
                            text: result.value.message || 'Data berhasil dihapus',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Reload DataTable tanpa reset pagination
                        $('#kartu-keluarga-table').DataTable().ajax.reload(null, false);
                    } else {
                        // Gagal dihapus
                        Swal.fire({
                            title: 'Gagal!',
                            text: (result.value && result.value.message) || 'Gagal menghapus data',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            }).catch((error) => {
                // Error dari AJAX
                console.error('Error:', error);

                let errorMessage = 'Terjadi kesalahan saat menghapus data';

                // Cek apakah ada response error dari server
                if (error.responseJSON && error.responseJSON.message) {
                    errorMessage = error.responseJSON.message;
                } else if (error.statusText) {
                    errorMessage = 'Error: ' + error.statusText;
                }

                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    </script>
@endpush
