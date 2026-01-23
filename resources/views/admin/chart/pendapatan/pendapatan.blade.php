@extends('admin.layout.main')
@section('title', 'Statistik Pendapatan')
@section('content-header', 'Statistik Pendapatan')

@section('content')
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total-penduduk">-</h3>
                    <p>Total Penduduk</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="total-kk">-</h3>
                    <p>Total KK</p>
                </div>
                <div class="icon">
                    <i class="fas fa-home"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="rata-anggota">-</h3>
                    <p>Rata-rata Anggota/KK</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="lansia-rentan-count">-</h3>
                    <p>Lansia Rentan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 1: Distribusi Pendapatan & Jenis Kelamin -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distribusi Pendapatan</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartDistribusiPendapatan" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distribusi Jenis Kelamin</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartJenisKelamin" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Pendapatan per Umur & Jenis Kelamin -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pendapatan Berdasarkan Kelompok Umur</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartPendapatanUmur" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pendapatan Berdasarkan Jenis Kelamin</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartPendapatanJenkel" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Top 10 RT Termiskin -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top 10 RT dengan Pendapatan Rendah Tertinggi</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartPendapatanRT" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs untuk DataTables -->
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="dataTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-semua" data-toggle="tab" href="#semua-penduduk" role="tab">
                        Semua Penduduk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-lansia" data-toggle="tab" href="#tab-lansia-rentan" role="tab">
                        Lansia Rentan
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <!-- Tab Semua Penduduk -->
                <div class="tab-pane fade show active" id="semua-penduduk" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>Filter Pendapatan</label>
                            <select class="form-control form-control-sm" id="filter-pendapatan">
                                <option value="">Semua Pendapatan</option>
                                <option value="0-1 Juta">0-1 Juta</option>
                                <option value="1-2 Juta">1-2 Juta</option>
                                <option value="2-3 Juta">2-3 Juta</option>
                                <option value="3-5 Juta">3-5 Juta</option>
                                <option value=">5 Juta">>5 Juta</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Filter Kelompok Umur</label>
                            <select class="form-control form-control-sm" id="filter-kelompok-umur">
                                <option value="">Semua Umur</option>
                                <option value="<25">&lt;25 tahun</option>
                                <option value="26-40">26-40 tahun</option>
                                <option value="41-60">41-60 tahun</option>
                                <option value=">60">&gt;60 tahun</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Filter RT/RW</label>
                            <select class="form-control form-control-sm" id="filter-rt-rw">
                                <option value="">Semua RT/RW</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-secondary btn-sm btn-block" id="reset-filter">
                                <i class="fas fa-sync-alt"></i> Reset Filter
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table-penduduk" class="table-bordered table-striped table-hover table">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>JK</th>
                                    <th>Tgl Lahir</th>
                                    <th>Umur</th>
                                    <th>Alamat</th>
                                    <th>RT/RW</th>
                                    <th>Pendapatan</th>
                                    <th>BPJS</th>
                                    <th>Pembayaran BPJS</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- Tab Lansia Rentan -->
                <div class="tab-pane fade" id="tab-lansia-rentan" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Filter Pendapatan</label>
                            <select class="form-control form-control-sm" id="filter-lansia-pendapatan">
                                <option value="">Semua Pendapatan</option>
                                <option value="0-1 Juta">0-1 Juta</option>
                                <option value="1-2 Juta">1-2 Juta</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Filter RT/RW</label>
                            <select class="form-control form-control-sm" id="filter-lansia-rt-rw">
                                <option value="">Semua RT/RW</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-secondary btn-sm btn-block" id="reset-filter-lansia">
                                <i class="fas fa-sync-alt"></i> Reset Filter
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table-lansia" class="table-bordered table-striped table-hover table">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>JK</th>
                                    <th>Tgl Lahir</th>
                                    <th>Umur</th>
                                    <th>Alamat</th>
                                    <th>RT/RW</th>
                                    <th>Pendapatan</th>
                                    <th>BPJS</th>
                                    <th>Pembayaran BPJS</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .small-box {
            border-radius: 0.25rem;
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            display: block;
            margin-bottom: 20px;
            position: relative;
        }

        .small-box>.inner {
            padding: 10px;
        }

        .small-box h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0 0 10px;
            padding: 0;
            white-space: nowrap;
        }

        .small-box p {
            font-size: 1rem;
        }

        .small-box .icon {
            color: rgba(0, 0, 0, .15);
            z-index: 0;
        }

        .small-box .icon>i {
            font-size: 90px;
            position: absolute;
            right: 15px;
            top: 15px;
            transition: transform .3s linear;
        }

        .small-box:hover .icon>i {
            transform: scale(1.1);
        }

        /* Custom Filter Styles */
        .filter-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* DataTables Custom */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.25rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .02);
        }

        /* Badge Custom */
        .badge {
            font-size: 0.875rem;
            padding: 0.35em 0.65em;
        }

        /* Chart Card */
        .card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // ==================== LOAD STATISTIK DASAR ====================
            $.ajax({
                url: '{{ route('pendapatan.statistik.dasar') }}',
                method: 'GET',
                success: function(data) {
                    $('#total-penduduk').text(data.total_penduduk.toLocaleString('id-ID'));
                    $('#total-kk').text(data.total_kk.toLocaleString('id-ID'));
                    $('#rata-anggota').text(data.rata_anggota_per_kk);

                    // Chart Jenis Kelamin
                    new Chart($('#chartJenisKelamin'), {
                        type: 'doughnut',
                        data: {
                            labels: Object.keys(data.jenis_kelamin),
                            datasets: [{
                                data: Object.values(data.jenis_kelamin),
                                backgroundColor: ['#3788d8', '#e83e8c'],
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                }
            });

            // ==================== DISTRIBUSI PENDAPATAN ====================
            $.ajax({
                url: '{{ route('pendapatan.distribusi.pendapatan') }}',
                method: 'GET',
                success: function(data) {
                    const labels = Object.keys(data);
                    const values = labels.map(k => data[k].jumlah);

                    new Chart($('#chartDistribusiPendapatan'), {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Penduduk',
                                data: values,
                                backgroundColor: '#28a745'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });

            // ==================== PENDAPATAN PER UMUR ====================
            $.ajax({
                url: '{{ route('pendapatan.pendapatan.per.umur') }}',
                method: 'GET',
                success: function(data) {
                    const kelompokUmur = Object.keys(data);
                    const pendapatanKategori = ['0-1 Juta', '1-2 Juta', '2-3 Juta', '3-5 Juta',
                        '>5 Juta'
                    ];
                    const colors = ['#dc3545', '#ffc107', '#17a2b8', '#28a745', '#6f42c1'];

                    const datasets = pendapatanKategori.map((kategori, idx) => ({
                        label: kategori,
                        data: kelompokUmur.map(umur => data[umur][kategori] || 0),
                        backgroundColor: colors[idx]
                    }));

                    new Chart($('#chartPendapatanUmur'), {
                        type: 'bar',
                        data: {
                            labels: kelompokUmur,
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            },
                            scales: {
                                x: {
                                    stacked: true
                                },
                                y: {
                                    stacked: true,
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });

            // ==================== PENDAPATAN PER JENIS KELAMIN ====================
            $.ajax({
                url: '{{ route('pendapatan.pendapatan.per.jenkel') }}',
                method: 'GET',
                success: function(data) {
                    const pendapatanKategori = ['0-1 Juta', '1-2 Juta', '2-3 Juta', '3-5 Juta',
                        '>5 Juta'
                    ];

                    const datasets = [{
                            label: 'Laki-laki',
                            data: pendapatanKategori.map(k => data['Laki-laki'][k] || 0),
                            backgroundColor: '#3788d8'
                        },
                        {
                            label: 'Perempuan',
                            data: pendapatanKategori.map(k => data['Perempuan'][k] || 0),
                            backgroundColor: '#e83e8c'
                        }
                    ];

                    new Chart($('#chartPendapatanJenkel'), {
                        type: 'bar',
                        data: {
                            labels: pendapatanKategori,
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });

            // ==================== TOP 10 RT TERMISKIN ====================
            $.ajax({
                url: '{{ route('pendapatan.pendapatan.per.rt') }}',
                method: 'GET',
                success: function(data) {
                    const labels = Object.keys(data);
                    const values = labels.map(k => data[k].persentase_rendah);

                    new Chart($('#chartPendapatanRT'), {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: '% Pendapatan Rendah',
                                data: values,
                                backgroundColor: '#dc3545'
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.parsed.x.toFixed(2) + '%';
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    max: 100,
                                    ticks: {
                                        callback: function(value) {
                                            return value + '%';
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });

            // ==================== KELOMPOK RENTAN ====================
            $.ajax({
                url: '{{ route('pendapatan.kelompok.rentan') }}',
                method: 'GET',
                success: function(data) {
                    $('#lansia-rentan-count').text(data.total.toLocaleString('id-ID'));
                }
            });

            // ==================== DATATABLES ====================
            const tablePenduduk = $('#table-penduduk').DataTable({
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
                ajax: {
                    url: '{{ route('pendapatan.datatable.penduduk') }}',
                    data: function(d) {
                        d.pendapatan = $('#filter-pendapatan').val();
                        d.kelompok_umur = $('#filter-kelompok-umur').val();
                        d.rt_rw = $('#filter-rt-rw').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'no_nik',
                        name: 'no_nik',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        class: 'nowrap'
                    },
                    {
                        data: 'jenkel',
                        name: 'jenkel',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'tgl_lahir',
                        name: 'tgl_lahir',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'umur',
                        name: 'umur',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'kp',
                        name: 'kp',
                        class: 'nowrap'
                    },
                    {
                        data: 'rt_rw',
                        name: 'rt_rw',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'pendapatan_perbulan',
                        name: 'pendapatan_perbulan',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'punya_bpjs',
                        name: 'punya_bpjs',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'pembayaran_bpjs',
                        name: 'pembayaran_bpjs',
                        class: 'text-center nowrap',
                    }
                ],
            });

            // Load RT/RW options untuk filter
            $.ajax({
                url: '{{ route('pendapatan.datatable.penduduk') }}',
                method: 'GET',
                data: {
                    get_rt_rw: true
                },
                success: function(response) {
                    if (response.rt_rw_list) {
                        const rtRwSelect = $('#filter-rt-rw, #filter-lansia-rt-rw');
                        response.rt_rw_list.forEach(function(rt_rw) {
                            rtRwSelect.append(new Option(rt_rw, rt_rw));
                        });
                    }
                }
            });

            $('#filter-pendapatan, #filter-kelompok-umur, #filter-rt-rw').change(function() {
                tablePenduduk.draw();
            });

            $('#reset-filter').click(function() {
                $('#filter-pendapatan').val('');
                $('#filter-kelompok-umur').val('');
                $('#filter-rt-rw').val('');
                tablePenduduk.draw();
            });

            const tableLansia = $('#table-lansia').DataTable({
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
                ajax: {
                    url: '{{ route('pendapatan.datatable.lansia.rentan') }}',
                    data: function(d) {
                        d.pendapatan = $('#filter-lansia-pendapatan').val();
                        d.rt_rw = $('#filter-lansia-rt-rw').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'no_nik',
                        name: 'no_nik',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        class: 'nowrap'
                    },
                    {
                        data: 'jenkel',
                        name: 'jenkel',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'tgl_lahir',
                        name: 'tgl_lahir',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'umur',
                        name: 'umur',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'kp',
                        name: 'kp',
                        class: 'nowrap'
                    },
                    {
                        data: 'rt_rw',
                        name: 'rt_rw',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'pendapatan_perbulan',
                        name: 'pendapatan_perbulan',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'punya_bpjs',
                        name: 'punya_bpjs',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'pembayaran_bpjs',
                        name: 'pembayaran_bpjs',
                        class: 'text-center nowrap',
                    }
                ],
            });

            $('#filter-lansia-pendapatan, #filter-lansia-rt-rw').change(function() {
                tableLansia.draw();
            });

            $('#reset-filter-lansia').click(function() {
                $('#filter-lansia-pendapatan').val('');
                $('#filter-lansia-rt-rw').val('');
                tableLansia.draw();
            });

            // Reload tables saat tab diaktifkan
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $.fn.dataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust();
            });
        });
    </script>
@endpush
