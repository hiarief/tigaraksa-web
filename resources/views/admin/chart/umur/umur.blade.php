@extends('admin.layout.main')
@section('title', 'Statistik Umur')
@section('content-header', 'Statistik Umur')

@section('content')
    <div class="row">
        <div class="col-sm">
            <!-- Tabs -->
            <ul class="nav nav-tabs" id="umurTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="semua-tab" data-toggle="tab" href="#semua" role="tab">
                        <i class="fas fa-users"></i> Semua Penduduk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pemilih-tab" data-toggle="tab" href="#pemilih" role="tab">
                        <i class="fas fa-vote-yea"></i> Pemilih (17+ Tahun)
                    </a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="umurTabContent">
                <!-- Tab Semua Penduduk -->
                <div class="tab-pane fade show active" id="semua" role="tabpanel">
                    <div class="row mt-3">
                        <!-- Card Piramida Penduduk -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-bar"></i> Piramida Penduduk
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div id="loadingPiramida" class="py-5 text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <p class="mt-2">Memuat data...</p>
                                    </div>
                                    <canvas id="piramidaChart" style="display:none; height: 400px;"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Card Distribusi Kelompok Umur -->
                        <div class="col-md-6 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie"></i> Distribusi Kelompok Umur
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div id="loadingDistribusi" class="py-5 text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <canvas id="distribusiChart" style="display:none;"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Card Statistik -->
                        <div class="col-md-6 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-info-circle"></i> Ringkasan Statistik
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div id="loadingStats" class="py-5 text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <div id="statistikContent" style="display:none;">
                                        <table class="table-sm table">
                                            <tr>
                                                <td><strong>Total Penduduk</strong></td>
                                                <td class="text-right"><span id="totalPenduduk">-</span> orang</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Laki-laki</strong></td>
                                                <td class="text-right"><span id="totalLaki">-</span> orang</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Perempuan</strong></td>
                                                <td class="text-right"><span id="totalPerempuan">-</span> orang</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Rasio Jenis Kelamin</strong></td>
                                                <td class="text-right"><span id="rasio">-</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <small id="noteRasio" class="text-muted d-block mt-1"></small>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-table"></i> Data Detail Semua Penduduk
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <!-- Filter RW/RT untuk Semua Penduduk -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label>Filter RW:</label>
                                            <select id="filterRWSemua" class="form-control form-control-sm">
                                                <option value="">Semua RW</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Filter RT:</label>
                                            <select id="filterRTSemua" class="form-control form-control-sm">
                                                <option value="">Semua RT</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <button type="button" id="btnFilterSemua"
                                                class="btn btn-primary btn-sm btn-block">
                                                <i class="fas fa-filter"></i> Terapkan Filter
                                            </button>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <button type="button" id="btnResetSemua"
                                                class="btn btn-secondary btn-sm btn-block">
                                                <i class="fas fa-redo"></i> Reset Filter
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Tabs RW untuk Semua -->
                                    <ul class="nav nav-pills mb-3" id="rwTabsSemua" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="pill" href="#" data-rw="">
                                                <i class="fas fa-list"></i> Semua
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- DataTable -->
                                    <div class="table-responsive">
                                        <table class="table-bordered table-hover table-striped table-sm nowrap table"
                                            id="detailTableSemuaPenduduk" style="width:100%">
                                            <thead class="table-dark">
                                                <tr class="nowrap text-center">
                                                    <th>NO</th>
                                                    <th>NIK</th>
                                                    <th>NAMA</th>
                                                    <th>KK</th>
                                                    <th>JENIS KELAMIN</th>
                                                    <th>TANGGAL LAHIR</th>
                                                    <th>UMUR</th>
                                                    <th>ALAMAT</th>
                                                    <th>RT/RW</th>
                                                    <th>DESA</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Pemilih -->
                <div class="tab-pane fade" id="pemilih" role="tabpanel">
                    <div class="row mt-3">
                        <!-- Card Piramida Pemilih -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-bar"></i> Piramida Pemilih (17+ Tahun)
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div id="loadingPiramidaPemilih" class="py-5 text-center">
                                        <div class="spinner-border text-success" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <p class="mt-2">Memuat data...</p>
                                    </div>
                                    <canvas id="piramidaPemilihChart" style="display:none; height: 400px;"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Card Statistik Pemilih -->
                        <div class="col-md-12 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-info-circle"></i> Ringkasan Pemilih
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div id="loadingStatsPemilih" class="py-5 text-center">
                                        <div class="spinner-border text-success" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <div id="statistikPemilihContent" style="display:none;">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="info-box bg-success">
                                                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Total Pemilih</span>
                                                        <span class="info-box-number" id="totalPemilih">-</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-box bg-info">
                                                    <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Laki-laki</span>
                                                        <span class="info-box-number" id="pemilihLaki">-</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-box bg-warning">
                                                    <span class="info-box-icon"><i class="fas fa-female"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Perempuan</span>
                                                        <span class="info-box-number" id="pemilihPerempuan">-</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-box bg-danger">
                                                    <span class="info-box-icon"><i class="fas fa-percentage"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">% dari Total</span>
                                                        <span class="info-box-number" id="persenPemilih">-</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Data Pemilih (DataTables) -->
                        <div class="col-md-12 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-table"></i> Data Detail Pemilih
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <!-- Filter RW/RT untuk Pemilih -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label>Filter RW:</label>
                                            <select id="filterRWPemilih" class="form-control form-control-sm">
                                                <option value="">Semua RW</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Filter RT:</label>
                                            <select id="filterRTPemilih" class="form-control form-control-sm">
                                                <option value="">Semua RT</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <button type="button" id="btnFilterPemilih"
                                                class="btn btn-primary btn-sm btn-block">
                                                <i class="fas fa-filter"></i> Terapkan Filter
                                            </button>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <button type="button" id="btnResetPemilih"
                                                class="btn btn-secondary btn-sm btn-block">
                                                <i class="fas fa-redo"></i> Reset Filter
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Tabs RW untuk Pemilih -->
                                    <ul class="nav nav-pills mb-3" id="rwTabsPemilih" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="pill" href="#" data-rw="">
                                                <i class="fas fa-list"></i> Semua
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- DataTable -->
                                    <div class="table-responsive">
                                        <table class="table-bordered table-hover table-striped table-sm nowrap table"
                                            id="detailTable" style="width:100%">
                                            <thead class="table-dark">
                                                <tr class="nowrap text-center">
                                                    <th>NO</th>
                                                    <th>NIK</th>
                                                    <th>NAMA</th>
                                                    <th>KK</th>
                                                    <th>JENIS KELAMIN</th>
                                                    <th>TANGGAL LAHIR</th>
                                                    <th>UMUR</th>
                                                    <th>ALAMAT</th>
                                                    <th>RT/RW</th>
                                                    <th>DESA</th>
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
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .nav-tabs .nav-link {
            color: #495057;
        }

        .nav-tabs .nav-link.active {
            font-weight: bold;
        }

        .info-box {
            min-height: 80px;
            color: white;
        }

        .info-box-icon {
            font-size: 2rem;
        }

        .nav-pills .nav-link {
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .nav-pills .nav-link.active {
            background-color: #007bff;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let piramidaChart = null;
        let distribusiChart = null;
        let piramidaPemilihChart = null;
        let detailTable = null;
        let detailTableSemua = null;

        let currentRWSemua = '';
        let currentRTSemua = '';
        let currentRWPemilih = '';
        let currentRTPemilih = '';

        $(document).ready(function() {
            loadData();
            loadRWList();

            initDataTableSemuaPenduduk();

            $('#umurTab a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                if (piramidaChart) piramidaChart.resize();
                if (distribusiChart) distribusiChart.resize();
                if (piramidaPemilihChart) piramidaPemilihChart.resize();

                if ($(e.target).attr('href') === '#pemilih' && !detailTable) {
                    initDataTable();
                }
            });

            // Filter untuk Tab Semua Penduduk
            $('#filterRWSemua').on('change', function() {
                loadRTList($(this).val(), 'semua');
            });

            $('#btnFilterSemua').on('click', function() {
                currentRWSemua = $('#filterRWSemua').val();
                currentRTSemua = $('#filterRTSemua').val();
                if (detailTableSemua) detailTableSemua.ajax.reload();
            });

            $('#btnResetSemua').on('click', function() {
                currentRWSemua = '';
                currentRTSemua = '';
                $('#filterRWSemua').val('');
                $('#filterRTSemua').val('');
                loadRTList('', 'semua');
                if (detailTableSemua) detailTableSemua.ajax.reload();
            });

            // Filter untuk Tab Pemilih
            $('#filterRWPemilih').on('change', function() {
                loadRTList($(this).val(), 'pemilih');
            });

            $('#btnFilterPemilih').on('click', function() {
                currentRWPemilih = $('#filterRWPemilih').val();
                currentRTPemilih = $('#filterRTPemilih').val();
                if (detailTable) detailTable.ajax.reload();
            });

            $('#btnResetPemilih').on('click', function() {
                currentRWPemilih = '';
                currentRTPemilih = '';
                $('#filterRWPemilih').val('');
                $('#filterRTPemilih').val('');
                loadRTList('', 'pemilih');
                if (detailTable) detailTable.ajax.reload();
            });

            // Tab RW untuk Semua Penduduk
            $(document).on('click', '#rwTabsSemua .nav-link', function(e) {
                e.preventDefault();
                $('#rwTabsSemua .nav-link').removeClass('active');
                $(this).addClass('active');

                currentRWSemua = $(this).data('rw');
                currentRTSemua = '';
                loadRTList(currentRWSemua, 'semua');

                if (detailTableSemua) detailTableSemua.ajax.reload();
            });

            // Tab RW untuk Pemilih
            $(document).on('click', '#rwTabsPemilih .nav-link', function(e) {
                e.preventDefault();
                $('#rwTabsPemilih .nav-link').removeClass('active');
                $(this).addClass('active');

                currentRWPemilih = $(this).data('rw');
                currentRTPemilih = '';
                loadRTList(currentRWPemilih, 'pemilih');

                if (detailTable) detailTable.ajax.reload();
            });
        });

        /* =========================
           LOAD DATA UTAMA
        ========================= */
        function loadData() {
            $.get('{{ route('umur.data') }}', function(res) {
                renderPiramida(res.kelompok_umur);
                renderDistribusi(res.kelompok_umur);
                renderStatistik(res.kelompok_umur);

                renderPiramidaPemilih(res.pemilih);
                renderStatistikPemilih(res.pemilih);
            });
        }

        /* =========================
           RW & RT
        ========================= */
        function loadRWList() {
            $.get('{{ route('umur.rw.list') }}', function(data) {
                let rwSelectSemua = $('#filterRWSemua');
                let rwSelectPemilih = $('#filterRWPemilih');
                let rwTabsSemua = $('#rwTabsSemua');
                let rwTabsPemilih = $('#rwTabsPemilih');

                data.forEach(rw => {
                    rwSelectSemua.append(`<option value="${rw}">RW ${rw}</option>`);
                    rwSelectPemilih.append(`<option value="${rw}">RW ${rw}</option>`);

                    rwTabsSemua.append(`
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-rw="${rw}">RW ${rw}</a>
                        </li>
                    `);

                    rwTabsPemilih.append(`
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-rw="${rw}">RW ${rw}</a>
                        </li>
                    `);
                });
            });
        }

        function loadRTList(rw, type) {
            $.get('{{ route('umur.rt.list') }}', {
                rw
            }, function(data) {
                let rtSelect = type === 'semua' ? $('#filterRTSemua') : $('#filterRTPemilih');
                rtSelect.html('<option value="">Semua RT</option>');
                data.forEach(rt => {
                    rtSelect.append(`<option value="${rt}">RT ${rt}</option>`);
                });
            });
        }

        /* =========================
           DATA PARSER PIRAMIDA
        ========================= */
        function parsePiramida(data) {
            let labels = [];
            let laki = [];
            let perempuan = [];
            let map = {};

            data.forEach(d => {
                if (!map[d.kelompok_umur]) {
                    map[d.kelompok_umur] = {
                        L: 0,
                        P: 0
                    };
                    labels.push(d.kelompok_umur);
                }
                if (d.jenkel == 1) map[d.kelompok_umur].L += d.jumlah;
                if (d.jenkel == 2) map[d.kelompok_umur].P += d.jumlah;
            });

            labels.forEach(k => {
                laki.push(-map[k].L);
                perempuan.push(map[k].P);
            });

            return {
                labels,
                laki,
                perempuan
            };
        }

        /* =========================
           PIRAMIDA PENDUDUK
        ========================= */
        function renderPiramida(data) {
            const parsed = parsePiramida(data);

            $('#loadingPiramida').hide();
            $('#piramidaChart').show();

            piramidaChart = new Chart(document.getElementById('piramidaChart'), {
                type: 'bar',
                data: {
                    labels: parsed.labels,
                    datasets: [{
                            label: 'Laki-laki',
                            data: parsed.laki,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Perempuan',
                            data: parsed.perempuan,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    let value = Math.abs(context.parsed.x);
                                    return label + ': ' + value.toLocaleString() + ' orang';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                callback: function(value) {
                                    return Math.abs(value).toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        /* =========================
           DISTRIBUSI UMUR
        ========================= */
        function renderDistribusi(data) {
            let map = {};
            data.forEach(d => {
                map[d.kelompok_umur] = (map[d.kelompok_umur] || 0) + d.jumlah;
            });

            $('#loadingDistribusi').hide();
            $('#distribusiChart').show();

            distribusiChart = new Chart(document.getElementById('distribusiChart'), {
                type: 'pie',
                data: {
                    labels: Object.keys(map),
                    datasets: [{
                        data: Object.values(map),
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                            '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384',
                            '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(1);
                                    return label + ': ' + value.toLocaleString() + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

        /* =========================
           STATISTIK PENDUDUK
        ========================= */
        function renderStatistik(data) {
            let L = 0,
                P = 0;

            data.forEach(d => {
                if (d.jenkel == 1) L += d.jumlah;
                if (d.jenkel == 2) P += d.jumlah;
            });

            let total = L + P;
            let rasio = P ? ((L / P) * 100).toFixed(2) : 0;

            $('#totalPenduduk').text(total);
            $('#totalLaki').text(L);
            $('#totalPerempuan').text(P);
            $('#rasio').text(rasio + ' : 100');

            let rasioAngka = parseFloat(rasio);
            let noteRasio = '';

            if (rasioAngka > 100) {
                noteRasio = `Catatan: Rasio jenis kelamin menunjukkan jumlah laki-laki per 100 perempuan.
                Nilai ${rasioAngka.toFixed(2)} berarti terdapat lebih banyak laki-laki dibandingkan perempuan
                di wilayah ini.`;
            } else if (rasioAngka < 100) {
                noteRasio = `Catatan: Rasio jenis kelamin menunjukkan jumlah laki-laki per 100 perempuan.
                Nilai ${rasioAngka.toFixed(2)} berarti terdapat lebih banyak perempuan dibandingkan laki-laki
                di wilayah ini.`;
            } else {
                noteRasio = `Catatan: Rasio jenis kelamin menunjukkan jumlah laki-laki per 100 perempuan.
                Nilai ${rasioAngka.toFixed(2)} berarti jumlah laki-laki dan perempuan relatif seimbang
                di wilayah ini.`;
            }

            $('#noteRasio').text(noteRasio);

            $('#loadingStats').hide();
            $('#statistikContent').show();
        }

        /* =========================
           PIRAMIDA PEMILIH
        ========================= */
        function renderPiramidaPemilih(data) {
            const parsed = parsePiramida(data);

            $('#loadingPiramidaPemilih').hide();
            $('#piramidaPemilihChart').show();

            piramidaPemilihChart = new Chart(document.getElementById('piramidaPemilihChart'), {
                type: 'bar',
                data: {
                    labels: parsed.labels,
                    datasets: [{
                            label: 'Laki-laki',
                            data: parsed.laki,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Perempuan',
                            data: parsed.perempuan,
                            backgroundColor: 'rgba(255, 159, 64, 0.7)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    let value = Math.abs(context.parsed.x);
                                    return label + ': ' + value.toLocaleString() + ' orang';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                callback: function(value) {
                                    return Math.abs(value).toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        /* =========================
           STATISTIK PEMILIH
        ========================= */
        function renderStatistikPemilih(data) {
            let L = 0,
                P = 0;
            data.forEach(d => {
                if (d.jenkel == 1) L += d.jumlah;
                if (d.jenkel == 2) P += d.jumlah;
            });

            let rasio = P ? ((L / P) * 100).toFixed(2) : 0;

            $('#totalPemilih').text(L + P);
            $('#pemilihLaki').text(L);
            $('#pemilihPerempuan').text(P);
            $('#persenPemilih').text(rasio);

            $('#loadingStatsPemilih').hide();
            $('#statistikPemilihContent').show();
        }

        /* =========================
           DATATABLE PEMILIH
        ========================= */
        function initDataTable() {
            detailTable = $('#detailTable').DataTable({
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
                    url: '{{ route('umur.pemilih') }}',
                    data: function(d) {
                        d.rw = currentRWPemilih;
                        d.rt = currentRTPemilih;
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
                        class: 'nowrap text-center',
                        defaultContent: '-'
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        class: 'nowrap',
                        defaultContent: '-'
                    },
                    {
                        data: 'no_kk',
                        name: 'no_kk',
                        class: 'nowrap text-center',
                        defaultContent: '-'
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
                        class: 'text-left nowrap'
                    },
                    {
                        data: 'rt_rw',
                        name: 'rt_rw',
                        orderable: false,
                        searchable: false,
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'desa',
                        name: 'desa',
                        class: 'text-center nowrap'
                    }
                ],
            });
        }

        /* =========================
           DATATABLE SEMUA PENDUDUK
        ========================= */
        function initDataTableSemuaPenduduk() {
            detailTableSemua = $('#detailTableSemuaPenduduk').DataTable({
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
                    url: '{{ route('umur.semua') }}',
                    data: function(d) {
                        d.rw = currentRWSemua;
                        d.rt = currentRTSemua;
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
                        class: 'nowrap text-center',
                        defaultContent: '-'
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        class: 'nowrap',
                        defaultContent: '-'
                    },
                    {
                        data: 'no_kk',
                        name: 'no_kk',
                        class: 'nowrap text-center',
                        defaultContent: '-'
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
                        class: 'text-left nowrap'
                    },
                    {
                        data: 'rt_rw',
                        name: 'rt_rw',
                        orderable: false,
                        searchable: false,
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'desa',
                        name: 'desa',
                        class: 'text-center nowrap'
                    }
                ]
            });
        }
    </script>
@endpush
