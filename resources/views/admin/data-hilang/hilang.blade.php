@extends('admin.layout.main')
@section('title', 'Data Anomali/Abnormal')
@section('content-header', 'Data Anomali/Abnormal')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filter Data Anomali</h3>
                </div>
                <div class="card-body">
                    <form id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>RT</label>
                                    <select name="rt" id="filter_rt" class="form-control">
                                        <option value="">Semua RT</option>
                                        @foreach ($rtList as $rt)
                                            <option value="{{ $rt }}">RT {{ $rt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>RW</label>
                                    <select name="rw" id="filter_rw" class="form-control">
                                        <option value="">Semua RW</option>
                                        @foreach ($rwList as $rw)
                                            <option value="{{ $rw }}">RW {{ $rw }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" id="btnFilter" class="btn btn-primary btn-block">
                                        <i class="fas fa-filter"></i> Terapkan Filter
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" id="btnReset" class="btn btn-secondary btn-block">
                                        <i class="fas fa-redo"></i> Reset Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kategori Anomali</h3>
                </div>
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="anomaliTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab"
                                data-category="all">
                                Semua Anomali
                                <span class="badge badge-danger ml-2">{{ $anomaliStats['all'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="kk-tanpa-anggota-tab" data-toggle="tab" href="#kk-tanpa-anggota"
                                role="tab" data-category="kk_tanpa_anggota">
                                KK Tanpa Anggota
                                <span class="badge badge-danger ml-2">{{ $anomaliStats['kk_tanpa_anggota'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="kk-tanpa-kepala-tab" data-toggle="tab" href="#kk-tanpa-kepala"
                                role="tab" data-category="kk_tanpa_kepala">
                                KK Tanpa Kepala
                                <span class="badge badge-danger ml-2">{{ $anomaliStats['kk_tanpa_kepala'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="kepala-ganda-tab" data-toggle="tab" href="#kepala-ganda" role="tab"
                                data-category="kepala_keluarga_ganda">
                                Kepala Keluarga Ganda
                                <span class="badge badge-danger ml-2">{{ $anomaliStats['kepala_keluarga_ganda'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="umur-tab" data-toggle="tab" href="#umur" role="tab"
                                data-category="umur_abnormal">
                                Umur Abnormal
                                <span class="badge badge-danger ml-2">{{ $anomaliStats['umur_abnormal'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="perkawinan-tab" data-toggle="tab" href="#perkawinan" role="tab"
                                data-category="perkawinan_tidak_konsisten">
                                Perkawinan
                                <span
                                    class="badge badge-danger ml-2">{{ $anomaliStats['perkawinan_tidak_konsisten'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bantuan-tab" data-toggle="tab" href="#bantuan" role="tab"
                                data-category="bantuan_tidak_konsisten">
                                Bantuan
                                <span class="badge badge-danger ml-2">{{ $anomaliStats['bantuan_tidak_konsisten'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bpjs-tab" data-toggle="tab" href="#bpjs" role="tab"
                                data-category="bpjs_tidak_konsisten">
                                BPJS
                                <span class="badge badge-danger ml-2">{{ $anomaliStats['bpjs_tidak_konsisten'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="rumah-tab" data-toggle="tab" href="#rumah" role="tab"
                                data-category="kepemilikan_rumah_kosong">
                                Kepemilikan Rumah
                                <span
                                    class="badge badge-danger ml-2">{{ $anomaliStats['kepemilikan_rumah_kosong'] }}</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active">
                            <div class="table-responsive">
                                <table id="anomaliTable" class="table-bordered table-striped table-hover table">
                                    <thead>
                                        <tr class="nowrap text-center">
                                            <th style="width: 1%">No</th>
                                            <th>NIK</th>
                                            <th>No KK</th>
                                            <th>Nama</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Umur</th>
                                            <th>JK</th>
                                            <th>Hub. Keluarga</th>
                                            <th>RT/RW</th>
                                            <th>Desa</th>
                                            <th>Kategori Anomali</th>
                                            <th width="20%">Detail Anomali</th>
                                            <th width="1%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .nav-tabs .nav-link {
            cursor: pointer;
            font-size: 0.9rem;
            padding: 0.5rem 0.8rem;
        }

        .nav-tabs .nav-link.active {
            font-weight: bold;
        }

        .nav-tabs {
            flex-wrap: wrap;
        }

        .table td {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.85em;
        }

        @media (max-width: 768px) {
            .nav-tabs .nav-link {
                font-size: 0.8rem;
                padding: 0.4rem 0.6rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            let table;
            let currentCategory = 'all';

            // Initialize DataTable
            function initDataTable() {
                if (table) {
                    table.destroy();
                }

                table = $('#anomaliTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
                    ordering: true,
                    paging: true,
                    searching: true,
                    info: true,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    order: [
                        [2, 'asc']
                    ],
                    ajax: {
                        url: '{{ route('data.hilang.index') }}',
                        data: function(d) {
                            d.category = currentCategory;
                            d.rt = $('#filter_rt').val();
                            d.rw = $('#filter_rw').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'no_nik',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'no_kk',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nama',
                            className: 'nowrap'
                        },
                        {
                            data: 'tanggal_lahir',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'umur',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'jenis_kelamin',
                            className: 'text-center nowrap',
                            render: function(data) {
                                return data == 1 ? 'L' : 'P';
                            }
                        },
                        {
                            data: 'hubungan_keluarga',
                            className: 'text-center nowrap'
                        },
                        {
                            data: null,
                            className: 'text-center nowrap',
                            render: function(data) {
                                return 'RT ' + data.rt + ' / RW ' + data.rw;
                            }
                        },
                        {
                            data: 'desa',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'anomali_badge',
                            className: 'text-center',
                            orderable: false
                        },
                        {
                            data: 'detail_anomali',
                            orderable: false
                        },
                        {
                            data: 'aksi',
                            name: 'aksi',
                            class: 'text-center nowrap',
                            orderable: false,
                            searchable: false,
                        },
                    ],
                });
            }

            // Initialize table on page load
            initDataTable();

            // Tab click handler
            $('#anomaliTabs a[data-toggle="tab"]').on('click', function(e) {
                e.preventDefault();
                currentCategory = $(this).data('category');
                $(this).tab('show');
                table.ajax.reload();
            });

            // Filter button
            $('#btnFilter').on('click', function() {
                table.ajax.reload();
            });

            // Reset button
            $('#btnReset').on('click', function() {
                $('#filter_rt').val('');
                $('#filter_rw').val('');
                table.ajax.reload();
            });

            // Enter key handler for filters
            $('#filterForm input, #filterForm select').on('keypress', function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    $('#btnFilter').click();
                }
            });
        });

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
                        url: "{{ route('kependudukan.anggota.keluarga.delete', ':id') }}".replace(
                            ':id',
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
                    } else if (result.value && result.value.is_kepala_keluarga) {
                        // Kasus khusus: Kepala Keluarga tidak bisa dihapus
                        Swal.fire({
                            title: '<i class="fas fa-user-shield text-warning"></i> ' + result.value
                                .message,
                            html: '<div class="text-left">' +
                                '<p class="mb-2"><strong>Detail:</strong></p>' +
                                '<p class="text-muted mb-3">' + result.value.details + '</p>' +
                                '<div class="alert alert-info mb-0">' +
                                '<strong><i class="fas fa-lightbulb"></i> Saran:</strong><br>' +
                                result.value.suggestion +
                                '</div>' +
                                '</div>',
                            icon: 'warning',
                            confirmButtonText: '<i class="fas fa-check"></i> Mengerti',
                            confirmButtonColor: '#3085d6',
                            width: '600px',
                            customClass: {
                                htmlContainer: 'text-left'
                            }
                        });
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
                let isKepalaKeluarga = false;

                // Cek apakah ada response error dari server
                if (error.responseJSON) {
                    if (error.responseJSON.is_kepala_keluarga) {
                        // Kasus khusus: Kepala Keluarga
                        isKepalaKeluarga = true;
                        Swal.fire({
                            title: '<i class="fas fa-user-shield text-warning"></i> ' + error.responseJSON
                                .message,
                            html: '<div class="text-left">' +
                                '<p class="mb-2"><strong>Detail:</strong></p>' +
                                '<p class="text-muted mb-3">' + error.responseJSON.details + '</p>' +
                                '<div class="alert alert-info mb-0">' +
                                '<strong><i class="fas fa-lightbulb"></i> Saran:</strong><br>' +
                                error.responseJSON.suggestion +
                                '</div>' +
                                '</div>',
                            icon: 'warning',
                            confirmButtonText: '<i class="fas fa-check"></i> Mengerti',
                            confirmButtonColor: '#3085d6',
                            width: '600px',
                            customClass: {
                                htmlContainer: 'text-left'
                            }
                        });
                    } else if (error.responseJSON.message) {
                        errorMessage = error.responseJSON.message;
                    }
                } else if (error.statusText) {
                    errorMessage = 'Error: ' + error.statusText;
                }

                // Tampilkan error biasa jika bukan kasus kepala keluarga
                if (!isKepalaKeluarga) {
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    </script>
@endpush
