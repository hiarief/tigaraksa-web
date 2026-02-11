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
                            class="table-bordered table-hover table-striped rounded-0 table-sm table text-sm">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2" style="width: 1%">NO</th>
                                    <th rowspan="2" style="width: 11%">AKSI</th>
                                    <th colspan="2">NOMOR</th>
                                    <th rowspan="2">NAMA KEPALA KELUARGA</th>
                                    <th rowspan="2" style="width: 1%">TGL LAHIR</th>
                                    <th rowspan="2">TEMPAT LAHIR</th>
                                    <th rowspan="2">DESA</th>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            // ============================================================
            // DATATABLE INITIALIZATION - OPTIMIZED
            // ============================================================
            const table = $('#kartu-keluarga-table').DataTable({
                responsive: false,
                autoWidth: false,
                processing: true,
                serverSide: true,

                // OPTIMASI 1: Defer rendering untuk performa lebih baik
                deferRender: true,

                // OPTIMASI 2: Paging yang lebih efisien
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                // OPTIMASI 3: Disable state save jika tidak perlu
                stateSave: false,

                ajax: {
                    url: "{{ route('kependudukan.kartu.keluarga.index.data') }}",
                    type: "GET",
                    error: function(xhr, error, code) {
                        console.error('DataTables Ajax Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Gagal memuat data. Silakan refresh halaman.',
                        });
                    }
                },

                order: [
                    [9, 'desc']
                ], // Order by created_at

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: '1%',
                        className: 'text-center nowrap',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        width: '1%',
                        className: 'text-center nowrap',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'no_kk',
                        name: 't2.no_kk',
                        className: 'text-center nowrap',
                    },
                    {
                        data: 'no_nik',
                        name: 't1.no_nik',
                        className: 'text-center nowrap',
                    },
                    {
                        data: 'nama',
                        name: 't1.nama',
                        className: 'nowrap',
                    },
                    {
                        data: 'tgl_lahir',
                        name: 't1.tgl_lahir',
                        className: 'text-center nowrap',
                        width: '1%'
                    },
                    {
                        data: 'tmpt_lahir',
                        name: 't1.tmpt_lahir',
                        className: 'text-center nowrap',
                    },
                    {
                        data: 'name',
                        name: 't3.name',
                        className: 'text-center nowrap',
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                        orderable: false,
                        searchable: false,
                        className: 'nowrap',
                    },
                    {
                        data: 'created_at',
                        name: 't1.created_at',
                        visible: false,
                        searchable: false
                    }
                ],

                // OPTIMASI 4: Language Indonesia
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    emptyTable: "Tidak ada data tersedia",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            // OPTIMASI 5: Debounce search untuk mengurangi request
            let searchTimeout;
            $('#kartu-keluarga-table_filter input').off().on('keyup', function() {
                clearTimeout(searchTimeout);
                const searchTerm = this.value;
                searchTimeout = setTimeout(function() {
                    table.search(searchTerm).draw();
                }, 500); // Delay 500ms sebelum search
            });
        });

        // ============================================================
        // FUNCTION DELETE DATA - OPTIMIZED
        // ============================================================
        function deleteData(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Data Kartu Keluarga dan semua anggotanya akan dipindahkan ke tabel backup. Yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch("{{ route('kependudukan.kartu.keluarga.delete', ':id') }}".replace(':id',
                            id), {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText);
                            }
                            return response.json();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Request failed: ${error}`);
                        });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed && result.value?.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: result.value.message || 'Data berhasil dihapus',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#kartu-keluarga-table').DataTable().ajax.reload(null, false);
                }
            });
        }
    </script>
@endpush
