@extends('admin.layout.main')
@section('title', 'Data Kartu Keluarga yang Dihapus')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            <a href="{{ route('kependudukan.kartu.keluarga.index') }}"
                                class="btn btn-sm bg-gradient-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Data Aktif
                            </a>
                        </div>
                        <div>
                            <span class="badge badge-danger">
                                <i class="fas fa-trash"></i> Data yang Dihapus
                            </span>
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

                    {{-- Info Box --}}
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong>
                        Data yang ada di halaman ini adalah data yang sudah dihapus. Anda dapat melakukan:
                        <ul class="mb-0 mt-2">
                            <li><strong>Restore</strong>: Mengembalikan data ke tabel utama</li>
                            <li><strong>Hapus Permanen</strong>: Menghapus data secara permanen (tidak dapat dikembalikan)
                            </li>
                        </ul>
                    </div>

                    <div class="table-responsive">
                        <table id="trash-table"
                            class="table-bordered table-hover table-striped rounded-0 table-sm table py-0 text-sm">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2" style="width: 1%">NO</th>
                                    <th rowspan="2" style="width: 10%">AKSI</th>
                                    <th colspan="2">NOMOR</th>
                                    <th rowspan="2">NAMA</th>
                                    <th rowspan="2">TANGGAL LAHIR</th>
                                    <th rowspan="2">TEMPAT LAHIR</th>
                                    <th rowspan="2">ALAMAT</th>
                                    <th rowspan="2">DIHAPUS OLEH</th>
                                    <th rowspan="2">WAKTU DIHAPUS</th>
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
            $('#trash-table').DataTable({
                responsive: false,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ordering: true,
                paging: true,
                searching: true,
                info: true,
                ajax: "{{ route('kependudukan.kartu.keluarga.trash.data') }}",
                order: [
                    [9, 'desc'] // Order by deleted_at
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
                        name: 'kk.no_kk',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'no_nik',
                        name: 'anggota.no_nik',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'nama',
                        name: 'anggota.nama',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'tgl_lahir',
                        name: 'anggota.tgl_lahir',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'tmpt_lahir',
                        name: 'anggota.tmpt_lahir',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                        orderable: false,
                        searchable: false,
                        class: 'text-center',
                    },
                    {
                        data: 'deleted_by_name',
                        name: 'deleted_by_name',
                        class: 'text-center nowrap',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'deleted_at',
                        name: 'kk.deleted_at',
                        class: 'text-center nowrap',
                    }
                ],
                language: {
                    processing: "Memuat data...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    loadingRecords: "Memuat...",
                    zeroRecords: "Data tidak ditemukan",
                    emptyTable: "Tidak ada data yang tersedia",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });

        // ============================================================
        // FUNCTION RESTORE DATA
        // ============================================================
        function restoreData(id) {
            Swal.fire({
                title: 'Konfirmasi Restore',
                html: "Data Kartu Keluarga dan semua anggotanya akan dikembalikan ke tabel utama.<br><strong>Apakah Anda yakin?</strong>",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-undo"></i> Ya, Restore!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return $.ajax({
                        url: "{{ route('kependudukan.kartu.keluarga.restore', ':id') }}".replace(':id',
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
                    if (result.value && result.value.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: result.value.message || 'Data berhasil di-restore',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Reload DataTable
                        $('#trash-table').DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: (result.value && result.value.message) || 'Gagal restore data',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            }).catch((error) => {
                console.error('Error:', error);

                let errorMessage = 'Terjadi kesalahan saat restore data';

                if (error.responseJSON && error.responseJSON.message) {
                    errorMessage = error.responseJSON.message;
                }

                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }

        // ============================================================
        // FUNCTION DELETE PERMANENT
        // ============================================================
        function deletePermanent(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus Permanen',
                html: "<strong class='text-danger'>PERHATIAN!</strong><br>Data akan dihapus secara permanen dan <strong>TIDAK DAPAT DIKEMBALIKAN</strong>.<br><br>Apakah Anda yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash-alt"></i> Ya, Hapus Permanen!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return $.ajax({
                        url: "{{ route('kependudukan.kartu.keluarga.delete.permanent', ':id') }}"
                            .replace(':id', id),
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
                    if (result.value && result.value.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: result.value.message || 'Data berhasil dihapus permanen',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Reload DataTable
                        $('#trash-table').DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: (result.value && result.value.message) || 'Gagal menghapus data',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            }).catch((error) => {
                console.error('Error:', error);

                let errorMessage = 'Terjadi kesalahan saat menghapus data';

                if (error.responseJSON && error.responseJSON.message) {
                    errorMessage = error.responseJSON.message;
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
