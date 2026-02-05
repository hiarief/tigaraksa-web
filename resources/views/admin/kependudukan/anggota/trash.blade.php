@extends('admin.layout.main')
@section('title', 'Data Anggota Keluarga - Terhapus')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            <a href="{{ route('kependudukan.anggota.keluarga.index') }}"
                                class="btn btn-sm bg-gradient-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            {{--  <button type="button" class="btn btn-sm bg-gradient-warning" id="btnRestoreAll">
                                <i class="fas fa-rotate-left"></i> Restore Semua
                            </button>
                            <button type="button" class="btn btn-sm bg-gradient-danger" id="btnDeleteAllPermanent">
                                <i class="fas fa-trash-alt"></i> Hapus Semua Permanen
                            </button>  --}}
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
                                    <th rowspan="2" style="width: 1%">AKSI</th>
                                    <th colspan="2">NOMOR</th>
                                    <th rowspan="2">NAMA</th>
                                    <th rowspan="2">TANGGAL LAHIR</th>
                                    <th rowspan="2">TEMPAT LAHIR</th>
                                    <th rowspan="2">HUBUNGAN KELUARGA</th>
                                    <th rowspan="2">ALAMAT</th>
                                    <th rowspan="2">DIHAPUS PADA</th>
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
            var table = $('#trash-table').DataTable({
                responsive: false,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ordering: true,
                paging: true,
                searching: true,
                info: true,
                order: [
                    [9, 'desc']
                ], // Urutkan berdasarkan waktu hapus

                ajax: "{{ route('kependudukan.anggota.keluarga.trash.data') }}",
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
                        class: 'text-center nowrap',
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
                        data: 'hubungan_keluarga',
                        name: 't6.nama',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'deleted_at',
                        name: 't1.updated_at',
                        class: 'text-center nowrap',
                    }
                ],
            });
        });

        // ============================================================
        // FUNCTION RESTORE DATA
        // ============================================================
        function restoreData(url) {
            Swal.fire({
                title: 'Konfirmasi Restore',
                text: "Data akan dikembalikan ke daftar aktif. Lanjutkan?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-rotate-left"></i> Ya, Restore!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return $.ajax({
                        url: url,
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
                            text: result.value.message || 'Data berhasil dikembalikan',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#trash-table').DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: (result.value && result.value.message) || 'Gagal mengembalikan data',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            }).catch((error) => {
                console.error('Error:', error);

                let errorMessage = 'Terjadi kesalahan saat mengembalikan data';

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

        // ============================================================
        // RESTORE ALL DATA
        // ============================================================
        $('#btnRestoreAll').on('click', function() {
            Swal.fire({
                title: 'Restore Semua Data?',
                text: "Semua data yang terhapus akan dikembalikan ke daftar aktif. Lanjutkan?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-rotate-left"></i> Ya, Restore Semua!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return $.ajax({
                        url: "{{ route('kependudukan.anggota.keluarga.restore.all') }}",
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
                            text: result.value.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#trash-table').DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: (result.value && result.value.message) ||
                                'Gagal restore semua data',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            }).catch((error) => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat restore data',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });

        // ============================================================
        // FUNCTION DELETE PERMANENT
        // ============================================================
        function deletePermanent(url) {
            Swal.fire({
                title: 'Hapus Permanen?',
                html: '<strong class="text-danger">PERHATIAN!</strong><br>Data akan dihapus secara permanen dan tidak dapat dikembalikan lagi.<br><br>Apakah Anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash-alt"></i> Ya, Hapus Permanen!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return $.ajax({
                        url: url,
                        type: "POST", // Ubah dari DELETE ke POST
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

        // ============================================================
        // DELETE ALL PERMANENT
        // ============================================================
        $('#btnDeleteAllPermanent').on('click', function() {
            Swal.fire({
                title: 'Hapus Semua Permanen?',
                html: '<strong class="text-danger">PERINGATAN KERAS!</strong><br>Semua data akan dihapus secara permanen dan tidak dapat dikembalikan lagi.<br><br>Ketik <strong>HAPUS PERMANEN</strong> untuk melanjutkan:',
                icon: 'warning',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off',
                    placeholder: 'Ketik: HAPUS PERMANEN'
                },
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash-alt"></i> Hapus Semua Permanen!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: (inputValue) => {
                    if (inputValue !== 'HAPUS PERMANEN') {
                        Swal.showValidationMessage('Anda harus mengetik "HAPUS PERMANEN" dengan benar');
                        return false;
                    }

                    return $.ajax({
                        url: "{{ route('kependudukan.anggota.keluarga.delete.all.permanent') }}",
                        type: "POST", // Ubah dari DELETE ke POST
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
                            text: result.value.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#trash-table').DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: (result.value && result.value.message) ||
                                'Gagal menghapus semua data',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            }).catch((error) => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menghapus data',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
@endpush
