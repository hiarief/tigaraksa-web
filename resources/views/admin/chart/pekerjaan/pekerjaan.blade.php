@extends('admin.layout.main')
@section('title', 'Statistik Pekerjaan')
@section('content-header', 'Statistik Pekerjaan')

@section('content')
    <div class="row">
        <div class="col-sm">

            <!-- KPI Cards Section -->
            <div id="kpi-section" class="kpi-grid mb-4">
                <div class="col-12">
                    <div class="py-5 text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="text-muted mt-2">Memuat data KPI...</p>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1: Distribusi Pekerjaan & Pendapatan -->
            <div class="row mb-4">
                <!-- Distribusi Pekerjaan -->
                <div class="col-lg-8 col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-briefcase mr-2"></i>Distribusi Pekerjaan</h5>
                            <small>10 Jenis Pekerjaan Terbanyak (Usia Kerja ≥15 Tahun)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-pekerjaan" class="py-5 text-center">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="text-muted mt-2">Memuat data pekerjaan...</p>
                            </div>
                            <canvas id="chartDistribusiPekerjaan" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Pendapatan -->
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-money-bill-wave mr-2"></i>Distribusi Pendapatan</h5>
                            <small>Kategori Pendapatan Per Bulan (Usia Kerja)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-pendapatan" class="py-5 text-center">
                                <div class="spinner-border text-success" role="status"></div>
                                <p class="text-muted mt-2">Memuat data pendapatan...</p>
                            </div>
                            <canvas id="chartDistribusiPendapatan" style="display:none;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row 2: Pekerjaan vs Pendapatan (UTAMA) -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-bar mr-2"></i>Analisis Pekerjaan vs Pendapatan</h5>
                            <small>Distribusi Pendapatan Berdasarkan Jenis Pekerjaan (Usia Kerja)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-cross" class="py-5 text-center">
                                <div class="spinner-border text-info" role="status"></div>
                                <p class="text-muted mt-2">Memuat analisis data...</p>
                            </div>
                            <canvas id="chartPekerjaanVsPendapatan" style="display:none; height: 450px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row 3: Status Pekerjaan & Analisis Pendapatan (NEW) -->
            <div class="row mb-4">
                <!-- Status Pekerjaan Usia Kerja -->
                <div class="col-lg-5 col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-purple text-white" style="background-color: #6f42c1 !important;">
                            <h5 class="mb-0"><i class="fas fa-chart-pie mr-2"></i>Status Pekerjaan</h5>
                            <small>Usia Kerja (15-64 Tahun)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-status" class="py-5 text-center">
                                <div class="spinner-border" style="color: #6f42c1;" role="status"></div>
                                <p class="text-muted mt-2">Memuat data status...</p>
                            </div>
                            <canvas id="chartStatusPekerjaan" style="display:none; max-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Analisis Rata-rata Pendapatan -->
                <div class="col-lg-7 col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-teal text-white" style="background-color: #20c997 !important;">
                            <h5 class="mb-0"><i class="fas fa-chart-line mr-2"></i>Rata-rata Pendapatan Per Usia</h5>
                            <small>Usia Produktif (15-64 Tahun) yang Berpendapatan</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-analisis" class="py-5 text-center">
                                <div class="spinner-border text-info" role="status"></div>
                                <p class="text-muted mt-2">Memuat analisis pendapatan...</p>
                            </div>
                            <canvas id="chartAnalisisPendapatan" style="display:none; max-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 4: Gender & Usia -->
            <div class="row mb-4">
                <!-- Pekerjaan by Gender -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="fas fa-venus-mars mr-2"></i>Pekerjaan Berdasarkan Jenis Kelamin
                            </h5>
                            <small>Perbandingan Laki-Laki & Perempuan (Usia Kerja)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-gender" class="py-5 text-center">
                                <div class="spinner-border text-warning" role="status"></div>
                                <p class="text-muted mt-2">Memuat data gender...</p>
                            </div>
                            <canvas id="chartPekerjaanGender" style="display:none; max-height:400px"></canvas>

                        </div>
                    </div>
                </div>

                <!-- Pekerjaan by Usia -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="fas fa-users mr-2"></i>Pekerjaan Berdasarkan Kategori Usia</h5>
                            <small>Standar BPS: Anak s/d Lansia (6 Kategori)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-usia" class="py-5 text-center">
                                <div class="spinner-border text-secondary" role="status"></div>
                                <p class="text-muted mt-2">Memuat data usia...</p>
                            </div>
                            <canvas id="chartPekerjaanUsia" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row 5: Piramida Penduduk -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-area mr-2"></i>Piramida Penduduk Berdasarkan Usia
                            </h5>
                            <small>Distribusi Laki-Laki dan Perempuan Per Kategori Usia (Semua Umur)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-piramida" class="py-5 text-center">
                                <div class="spinner-border text-dark" role="status"></div>
                                <p class="text-muted mt-2">Memuat piramida penduduk...</p>
                            </div>
                            <canvas id="chartPiramidaPenduduk" style="display:none; height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* KPI Cards Styling */
        .kpi-card {
            border-left: 4px solid;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .kpi-card.primary {
            border-color: #007bff;
        }

        .kpi-card.success {
            border-color: #28a745;
        }

        .kpi-card.danger {
            border-color: #dc3545;
        }

        .kpi-card.warning {
            border-color: #ffc107;
        }

        .kpi-card.info {
            border-color: #17a2b8;
        }

        .kpi-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }

        .kpi-value {
            font-size: 2rem;
            font-weight: bold;
            margin: 10px 0;
        }

        .kpi-label {
            font-size: 0.9rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kpi-subtitle {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        .kpi-card {
            height: 100%;
        }


        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .kpi-value {
                font-size: 1.5rem;
            }

            .kpi-icon {
                font-size: 2rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Chart instances
            let charts = {
                pekerjaan: null,
                pendapatan: null,
                cross: null,
                gender: null,
                usia: null,
                piramida: null,
                status: null,
                analisis: null
            };

            // Color schemes
            const colors = {
                primary: ['#007bff', '#0056b3', '#004085', '#003d82', '#003366'],
                success: ['#28a745', '#20c997', '#17a2b8', '#138496', '#0e6e7e'],
                info: ['#17a2b8', '#138496', '#117a8b', '#0c6980', '#0a5875'],
                warm: ['#fd7e14', '#ffc107', '#28a745', '#20c997', '#17a2b8'],
                multi: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#20c997', '#fd7e14', '#e83e8c'],
                status: ['#28a745', '#dc3545', '#ff6b6b', '#ffc107']
            };

            // 1. Load KPI Data (Enhanced)
            function loadKPIData() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.kpi') }}',
                    method: 'GET',
                    success: function(data) {
                        const kpiHtml = `
                        <div class="card kpi-card primary shadow-sm animate-fade-in">
                            <div class="card-body text-center">
                                <i class="fas fa-users kpi-icon text-primary"></i>
                                <div class="kpi-value text-primary">${data.total_penduduk.toLocaleString()}</div>
                                <div class="kpi-label">Total Penduduk</div>
                                <div class="kpi-subtitle">Semua Usia</div>
                            </div>
                        </div>

                        <div class="card kpi-card info shadow-sm animate-fade-in">
                            <div class="card-body text-center">
                                <i class="fas fa-user-check kpi-icon text-info"></i>
                                <div class="kpi-value text-info">${data.usia_kerja.toLocaleString()}</div>
                                <div class="kpi-label">Usia Kerja</div>
                                <div class="kpi-subtitle">
                                    15–64 Tahun (${((data.usia_kerja / data.total_penduduk) * 100).toFixed(1)}%)
                                </div>
                            </div>
                        </div>

                        <div class="card kpi-card success shadow-sm animate-fade-in">
                            <div class="card-body text-center">
                                <i class="fas fa-briefcase kpi-icon text-success"></i>
                                <div class="kpi-value text-success">${data.pekerja_aktif.toLocaleString()}</div>
                                <div class="kpi-label">Pekerja Aktif</div>
                                <div class="kpi-subtitle">TPAK: ${data.tpak}%</div>
                            </div>
                        </div>

                        <div class="card kpi-card danger shadow-sm animate-fade-in">
                            <div class="card-body text-center">
                                <i class="fas fa-user-times kpi-icon text-danger"></i>
                                <div class="kpi-value text-danger">${data.persentase_pengangguran}%</div>
                                <div class="kpi-label">Pengangguran</div>
                                <div class="kpi-subtitle">${data.pengangguran.toLocaleString()} orang</div>
                            </div>
                        </div>

                        <div class="card kpi-card warning shadow-sm animate-fade-in">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-line kpi-icon text-warning"></i>
                                <div class="kpi-value text-warning">${data.pendapatan_dominan}</div>
                                <div class="kpi-label">Pendapatan Dominan</div>
                                <div class="kpi-subtitle">Semua Usia</div>
                            </div>
                        </div>
                    `;
                        $('#kpi-section').html(kpiHtml);
                    }
                });
            }


            // 2. Load Distribusi Pekerjaan
            function loadDistribusiPekerjaan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.distribusi.pekerjaan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-pekerjaan').hide();
                        $('#chartDistribusiPekerjaan').show();

                        const ctx = document.getElementById('chartDistribusiPekerjaan').getContext(
                            '2d');

                        if (charts.pekerjaan) charts.pekerjaan.destroy();

                        charts.pekerjaan = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.map(item => item.pekerjaan),
                                datasets: [{
                                    label: 'Jumlah Penduduk',
                                    data: data.map(item => item.jumlah),
                                    backgroundColor: colors.primary[0],
                                    borderColor: colors.primary[1],
                                    borderWidth: 1
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
                                                return 'Jumlah: ' + context.parsed.x
                                                    .toLocaleString() + ' orang';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        $('#loading-pekerjaan').html(
                            '<div class="alert alert-danger">Gagal memuat data</div>');
                    }
                });
            }

            // 3. Load Distribusi Pendapatan
            function loadDistribusiPendapatan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.distribusi.pendapatan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-pendapatan').hide();
                        $('#chartDistribusiPendapatan').show();

                        const ctx = document.getElementById('chartDistribusiPendapatan').getContext(
                            '2d');

                        if (charts.pendapatan) charts.pendapatan.destroy();

                        charts.pendapatan = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: data.map(item => item.kategori),
                                datasets: [{
                                    data: data.map(item => item.jumlah),
                                    backgroundColor: colors.success,
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            padding: 15,
                                            font: {
                                                size: 11
                                            }
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const total = context.dataset.data.reduce((
                                                    a, b) => a + b, 0);
                                                const percentage = ((context.parsed /
                                                    total) * 100).toFixed(1);
                                                return context.label + ': ' + context.parsed
                                                    .toLocaleString() + ' (' + percentage +
                                                    '%)';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        $('#loading-pendapatan').html(
                            '<div class="alert alert-danger">Gagal memuat data</div>');
                    }
                });
            }

            // 4. Load Pekerjaan vs Pendapatan
            function loadPekerjaanVsPendapatan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.pekerjaan.pendapatan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-cross').hide();
                        $('#chartPekerjaanVsPendapatan').show();

                        const ctx = document.getElementById('chartPekerjaanVsPendapatan').getContext(
                            '2d');

                        if (charts.cross) charts.cross.destroy();

                        const datasets = data.datasets.map((dataset, index) => ({
                            label: dataset.label,
                            data: dataset.data,
                            backgroundColor: colors.info[index % colors.info.length],
                            borderWidth: 0
                        }));

                        charts.cross = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels,
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            padding: 15
                                        }
                                    },
                                    tooltip: {
                                        mode: 'index',
                                        intersect: false,
                                        callbacks: {
                                            footer: function(tooltipItems) {
                                                let sum = 0;
                                                tooltipItems.forEach(function(tooltipItem) {
                                                    sum += tooltipItem.parsed.y;
                                                });
                                                return 'Total: ' + sum.toLocaleString() +
                                                    ' orang';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        stacked: true,
                                        ticks: {
                                            font: {
                                                size: 10
                                            }
                                        }
                                    },
                                    y: {
                                        stacked: true,
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        $('#loading-cross').html(
                            '<div class="alert alert-danger">Gagal memuat data</div>');
                    }
                });
            }

            // 5. Load Status Pekerjaan (NEW)
            function loadStatusPekerjaan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.status.pekerjaan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-status').hide();
                        $('#chartStatusPekerjaan').show();

                        const ctx = document.getElementById('chartStatusPekerjaan').getContext('2d');

                        if (charts.status) charts.status.destroy();

                        charts.status = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: data.map(item => item.status),
                                datasets: [{
                                    data: data.map(item => item.jumlah),
                                    backgroundColor: colors.status,
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            padding: 12
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const total = context.dataset.data.reduce((
                                                    a, b) => a + b, 0);
                                                const percentage = ((context.parsed /
                                                    total) * 100).toFixed(1);
                                                return context.label + ': ' + context.parsed
                                                    .toLocaleString() + ' (' + percentage +
                                                    '%)';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        $('#loading-status').html(
                            '<div class="alert alert-danger">Gagal memuat data</div>');
                    }
                });
            }

            // 6. Load Analisis Pendapatan (NEW)
            function loadAnalisisPendapatan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.analisis.pendapatan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-analisis').hide();
                        $('#chartAnalisisPendapatan').show();

                        const ctx = document.getElementById('chartAnalisisPendapatan').getContext('2d');

                        if (charts.analisis) charts.analisis.destroy();

                        charts.analisis = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.map(item => item.kategori_usia),
                                datasets: [{
                                    label: 'Rata-rata Pendapatan',
                                    data: data.map(item => item.rata_pendapatan),
                                    backgroundColor: '#20c997',
                                    borderColor: '#17a085',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return 'Rata-rata: Rp ' + context.parsed.y
                                                    .toLocaleString('id-ID');
                                            },
                                            afterLabel: function(context) {
                                                const index = context.dataIndex;
                                                return [
                                                    'Min: Rp ' + data[index]
                                                    .min_pendapatan.toLocaleString(
                                                        'id-ID'),
                                                    'Max: Rp ' + data[index]
                                                    .max_pendapatan.toLocaleString(
                                                        'id-ID'),
                                                    'Jumlah: ' + data[index].jumlah
                                                    .toLocaleString() + ' orang'
                                                ];
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading gender data:', error);
                        $('#loading-gender').html(
                            '<div class="alert alert-danger">Gagal memuat data: ' + error + '</div>'
                        );
                    }
                });
            }

            // 7. Load Pekerjaan by Gender (FIXED)
            function loadPekerjaanByGender() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.pekerjaan.gender') }}',
                    method: 'GET',
                    success: function(data) {
                        console.log('Gender data:', data);

                        $('#loading-gender').hide();
                        $('#chartPekerjaanGender').show();

                        const ctx = document.getElementById('chartPekerjaanGender').getContext('2d');

                        if (charts.gender) charts.gender.destroy();

                        charts.gender = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                        label: 'Laki-Laki',
                                        data: data.datasets[0].data,
                                        backgroundColor: '#007bff',
                                        borderWidth: 0
                                    },
                                    {
                                        label: 'Perempuan',
                                        data: data.datasets[1].data,
                                        backgroundColor: '#e83e8c',
                                        borderWidth: 0
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            footer: function(tooltipItems) {
                                                let sum = 0;
                                                tooltipItems.forEach(function(tooltipItem) {
                                                    sum += tooltipItem.parsed.y;
                                                });
                                                return 'Total: ' + sum.toLocaleString() +
                                                    ' orang';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        ticks: {
                                            font: {
                                                size: 10
                                            }
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,

                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading gender data:', error);
                        $('#loading-gender').html(
                            '<div class="alert alert-danger">Gagal memuat data: ' + error + '</div>'
                        );
                    }
                });
            }
            // 8. Load Pekerjaan by Usia
            function loadPekerjaanByUsia() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.pekerjaan.usia') }}',
                    method: 'GET',
                    success: function(data) {
                        console.log('Usia data:', data);

                        $('#loading-usia').hide();
                        $('#chartPekerjaanUsia').show();

                        const ctx = document.getElementById('chartPekerjaanUsia').getContext('2d');

                        if (charts.usia) charts.usia.destroy();

                        const usiaColors = [
                            '#ff6b6b', '#4ecdc4', '#45b7d1',
                            '#96ceb4', '#ffeaa7', '#dfe6e9'
                        ];

                        const datasets = data.datasets.map((dataset, index) => ({
                            label: dataset.label,
                            data: dataset.data,
                            backgroundColor: usiaColors[index],
                            borderWidth: 0
                        }));

                        charts.usia = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels,
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            font: {
                                                size: 10
                                            },
                                            padding: 10
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            footer: function(tooltipItems) {
                                                let sum = 0;
                                                tooltipItems.forEach(function(tooltipItem) {
                                                    sum += tooltipItem.parsed.y;
                                                });
                                                return 'Total: ' + sum.toLocaleString() +
                                                    ' orang';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        stacked: true,
                                        ticks: {
                                            font: {
                                                size: 9
                                            }
                                        }
                                    },
                                    y: {
                                        stacked: true,
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading usia data:', error);
                        $('#loading-usia').html('<div class="alert alert-danger">Gagal memuat data: ' +
                            error + '</div>');
                    }
                });
            }

            // 9. Load Piramida Penduduk (FIXED)
            function loadPiramidaPenduduk() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.distribusi.usia') }}',
                    method: 'GET',
                    success: function(data) {
                        console.log('Piramida data:', data);

                        $('#loading-piramida').hide();
                        $('#chartPiramidaPenduduk').show();

                        const ctx = document.getElementById('chartPiramidaPenduduk').getContext('2d');

                        if (charts.piramida) charts.piramida.destroy();

                        charts.piramida = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                        label: 'Laki-Laki',
                                        data: data.datasets[0].data,
                                        backgroundColor: '#007bff',
                                        borderWidth: 0
                                    },
                                    {
                                        label: 'Perempuan',
                                        data: data.datasets[1].data,
                                        backgroundColor: '#e83e8c',
                                        borderWidth: 0
                                    }
                                ]
                            },
                            options: {
                                indexAxis: 'y',
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const value = Math.abs(context.parsed.x);
                                                return context.dataset.label + ': ' + value
                                                    .toLocaleString() + ' orang';
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
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading piramida data:', error);
                        $('#loading-piramida').html(
                            '<div class="alert alert-danger">Gagal memuat data: ' + error + '</div>'
                        );
                    }
                });
            }


            // Initialize all charts
            function initializeCharts() {
                loadKPIData();
                loadDistribusiPekerjaan();
                loadDistribusiPendapatan();
                loadPekerjaanVsPendapatan();
                loadStatusPekerjaan();
                loadAnalisisPendapatan();
                loadPekerjaanByGender();
                loadPekerjaanByUsia();
                loadPiramidaPenduduk();
            }

            // Run on page load
            initializeCharts();
        });
    </script>
@endpush
