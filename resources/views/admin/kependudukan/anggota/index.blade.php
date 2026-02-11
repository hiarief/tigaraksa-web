@extends('admin.layout.main')
@section('title', 'Anggota Keluarga')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            @can('anggota-keluarga-create')
                                <a href="{{ route('kependudukan.anggota.keluarga.create') }}"
                                    class="btn btn-sm bg-gradient-primary">
                                    <i class="fa-solid fa-plus"></i> Tambah
                                </a>
                            @endcan
                            @can('anggota-keluarga-trash')
                                <a href="{{ route('kependudukan.anggota.keluarga.trash') }}"
                                    class="btn btn-sm bg-gradient-danger">
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
                                    <th rowspan="2">HUB KELUARGA</th>
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
                ajax: "{{ route('kependudukan.anggota.keluarga.index.data') }}",
                order: [
                    [9, 'desc'] // Order by created_at (index 9 karena ada hidden column)
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
                        name: 'no_kk',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'no_nik',
                        name: 'no_nik',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        class: 'nowrap',
                        // FORMAT DI CLIENT SIDE - LEBIH CEPAT
                        render: function(data) {
                            return data ? data.toUpperCase() : '';
                        }
                    },
                    {
                        data: 'tgl_lahir',
                        name: 'tgl_lahir',
                        class: 'text-center nowrap',
                        // FORMAT TANGGAL DI CLIENT SIDE
                        render: function(data) {
                            if (!data) return '';
                            let date = new Date(data);
                            let day = String(date.getDate()).padStart(2, '0');
                            let month = String(date.getMonth() + 1).padStart(2, '0');
                            let year = date.getFullYear();
                            return day + '-' + month + '-' + year;
                        }
                    },
                    {
                        data: 'tmpt_lahir',
                        name: 'tmpt_lahir',
                        class: 'text-center nowrap',
                        // FORMAT DI CLIENT SIDE
                        render: function(data) {
                            return data ? data.toUpperCase() : '';
                        }
                    },
                    {
                        data: 'hubungan_keluarga',
                        name: 'hubungan_keluarga',
                        class: 'text-center nowrap',
                        // FORMAT DI CLIENT SIDE
                        render: function(data) {
                            return data ? data.toUpperCase() : '';
                        }
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                        orderable: false,
                        searchable: false,
                        // FORMAT ALAMAT DI CLIENT SIDE
                        render: function(data, type, row) {
                            let alamat = row.kp + ', RT. ' + row.rt + '/' + row.rw;
                            return alamat.toUpperCase();
                        }
                    },
                    {
                        data: 'created_at',
                        name: 't1.created_at',
                        visible: false,
                        searchable: false
                    }
                ],
                // TAMBAHAN: Optimasi performa
                deferRender: true, // Render hanya data yang terlihat
                scroller: true, // Virtual scrolling (opsional)
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                }
            });
        });

        // ============================================================
        // FUNCTION DELETE DATA
        // Menggunakan SweetAlert2 untuk konfirmasi yang lebih baik
        // ============================================================
        function deleteData(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Data akan dipindahkan ke tabel backup. Apakah Anda yakin?",
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
                        url: "{{ route('kependudukan.anggota.keluarga.delete', ':id') }}".replace(':id',
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
                            text: result.value.message || 'Data berhasil dihapus',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // Reload DataTable tanpa reset pagination
                        $('#kartu-keluarga-table').DataTable().ajax.reload(null, false);
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
    </script>
@endpush
