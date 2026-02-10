@extends('admin.layout.main')
@section('title', 'Statistik Kependudukan')
@section('content-header', 'Statistik Kependudukan Kecamatan')

@push('styles')
@endpush

@section('content')

    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card-premium elevation-2">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-users"></i>
                        </div>

                        <div class="ml-3">
                            <h5 class="font-weight-bold mb-1">Ringkasan Statistik Kependudukan</h5>
                            <p class="stat-sublabel-premium mb-0">
                                Data diperbarui secara otomatis berdasarkan database terkini
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mb-4">

        <div class="col-12 mb-3">
            <h4 class="section-title">
                <i class="fas fa-calculator mr-2"></i> Statistik Jumlah
            </h4>
        </div>

        <!-- Total Penduduk -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-users"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalPenduduk">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Total Penduduk
                                <i class="fas fa-users stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Penduduk Desa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Total KK -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-success text-white">
                            <i class="fas fa-id-card"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalKK">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Total Kartu Keluarga
                                <i class="fas fa-id-card stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Kartu Keluarga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Total Kepala Keluarga -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-warning text-white">
                            <i class="fas fa-user-tie"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalKepalaKeluarga">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Kepala Keluarga
                                <i class="fas fa-user-tie stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Penanggung Keluarga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Total Anggota -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-info text-white">
                            <i class="fas fa-user-friends"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalAnggotaKeluarga">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Total Anggota
                                <i class="fas fa-user-friends stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Anggota Keluarga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <!-- ===============================
                             STATISTIK RASIO
                        ================================= -->
    <div class="row mb-4">

        <div class="col-12 mb-3">
            <h4 class="section-title">
                <i class="fas fa-chart-pie mr-2"></i> Statistik Rasio
            </h4>
        </div>


        <!-- Rata-rata anggota -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-purple text-white">
                            <i class="fas fa-home"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="rataAnggotaKK">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Rata-rata Anggota / KK
                                <i class="fas fa-home stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Orang per keluarga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Rasio Kepala Keluarga -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-orange text-white">
                            <i class="fas fa-percentage"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium">
                                <span id="rasioKepalaKeluarga">
                                    <span class="skeleton-premium skeleton-number-premium"></span>
                                </span>
                                <span class="d-none" id="rasioKepalaKeluargaPercent">%</span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Rasio Kepala Keluarga
                                <i class="fas fa-percentage stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Dependency Ratio -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-teal text-white">
                            <i class="fas fa-balance-scale"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium">
                                <span id="dependencyRatio">
                                    <span class="skeleton-premium skeleton-number-premium"></span>
                                </span>
                                <span class="d-none" id="dependencyRatioPercent">%</span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Dependency Ratio
                                <i class="fas fa-balance-scale stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Beban tanggungan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- STATISTIK DISTRIBUSI -->
    <div class="row mb-4">
        <div class="col-12 mb-3">
            <h4 class="section-title">
                <i class="fas fa-chart-bar mr-2"></i> Statistik Distribusi
            </h4>
        </div>

        <!-- Distribusi Desa -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Per Desa</h3>
                        <p class="card-subtitle-premium">Total penduduk per desa</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingChartDesa" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartDesa" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Distribusi Hubungan Keluarga -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-success">
                    <div class="card-header-icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Hubungan Keluarga</h3>
                        <p class="card-subtitle-premium">Berdasarkan status dalam keluarga</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingChartHubungan" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartHubungan" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Distribusi Kelompok Umur -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-warning">
                    <div class="card-header-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Kelompok Umur</h3>
                        <p class="card-subtitle-premium">Segmentasi berdasarkan usia</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingChartUmur" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartUmur" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Produktif vs Non Produktif -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-info">
                    <div class="card-header-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Produktif vs Non Produktif</h3>
                        <p class="card-subtitle-premium">Klasifikasi usia produktif</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingChartProduktif" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartProduktif" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Distribusi Anggota per KK -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-danger">
                    <div class="card-header-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Anggota per KK</h3>
                        <p class="card-subtitle-premium">Jumlah anggota dalam keluarga</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingChartAnggotaKK" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartAnggotaKK" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Pertumbuhan Bulanan -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Pertumbuhan Penduduk</h3>
                        <p class="card-subtitle-premium">12 Bulan Terakhir</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingChartPertumbuhan" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartPertumbuhan" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Distribusi Wilayah -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-dark">
                    <div class="card-header-icon">
                        <i class="fas fa-table"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Per Wilayah</h3>
                        <p class="card-subtitle-premium">Data seluruh desa di kecamatan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium p-0">
                    <div class="table-container-premium">
                        <div class="table-responsive">
                            <table class="table-premium table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="35%">Nama Desa</th>
                                        <th width="20%" class="text-center">Total Penduduk</th>
                                        <th width="20%" class="text-center">Total KK</th>
                                        <th width="20%" class="text-center">Rasio Penduduk/KK</th>
                                    </tr>
                                </thead>
                                <tbody id="tableWilayah">
                                    <tr>
                                        <td colspan="5" class="py-4 text-center">
                                            <div class="spinner-premium">
                                                <div class="double-bounce1"></div>
                                                <div class="double-bounce2"></div>
                                            </div>
                                            <p class="loading-text mt-2">Memproses data...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let charts = {};

            const colors = {
                primary: ['#007bff', '#0056b3', '#004085', '#6610f2', '#6f42c1'],
                success: ['#28a745', '#20c997', '#17a2b8', '#138496', '#117a8b'],
                warning: ['#ffc107', '#ff9800', '#ff5722', '#e91e63', '#f44336'],
                info: ['#17a2b8', '#20c997', '#6610f2', '#007bff', '#6c757d'],
                mixed: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2', '#fd7e14', '#20c997',
                    '#e83e8c', '#6c757d', '#343a40'
                ],
                desa: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2', '#fd7e14', '#20c997',
                    '#e83e8c', '#6c757d', '#343a40'
                ]
            };

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function hideChartLoading(chartId) {
                $('#loading' + chartId.charAt(0).toUpperCase() + chartId.slice(1)).fadeOut(300, function() {
                    $('#' + chartId).fadeIn(400);
                });
            }

            function animateNumber(selector, target) {
                const element = $(selector);
                const duration = 1000;
                const increment = target / (duration / 16);
                let current = 0;

                const timer = setInterval(function() {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    element.text(formatNumber(Math.floor(current)));
                }, 16);
            }

            // PARALLEL LOADING - Semua request jalan bersamaan!
            function loadAllData() {
                // 1. Load Statistik Jumlah
                $.ajax({
                    url: '{{ route('kecamatan.kependudukan.jumlah') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            animateNumber('#totalPenduduk', data.total_penduduk);
                            animateNumber('#totalKK', data.total_kk);
                            animateNumber('#totalKepalaKeluarga', data.total_kepala_keluarga);
                            animateNumber('#totalAnggotaKeluarga', data.total_anggota_keluarga);
                        }
                    }
                });

                // 2. Load Statistik Rasio
                $.ajax({
                    url: '{{ route('kecamatan.kependudukan.rasio') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            $('#rataAnggotaKK').html(data.rata_anggota_kk);
                            $('#rasioKepalaKeluarga').html(data.rasio_kepala_keluarga);
                            $('#rasioKepalaKeluargaPercent').removeClass('d-none');
                            $('#dependencyRatio').html(data.dependency_ratio);
                            $('#dependencyRatioPercent').removeClass('d-none');
                        }
                    }
                });

                // 3. Load Chart Desa
                $.ajax({
                    url: '{{ route('kecamatan.kependudukan.distribusi.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartDesa', 'Distribusi Per Desa', response.data, colors
                                .desa);
                        }
                    }
                });

                // 4. Load Chart Hubungan
                $.ajax({
                    url: '{{ route('kecamatan.kependudukan.distribusi.hubungan') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderPieChart('chartHubungan', 'Hubungan Keluarga', response.data, colors
                                .mixed);
                        }
                    }
                });

                // 5. Load Chart Umur
                $.ajax({
                    url: '{{ route('kecamatan.kependudukan.distribusi.umur') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const umurOrder = ['Balita (0-4)', 'Anak (5-11)', 'Remaja (12-17)',
                                'Produktif (18-59)', 'Lansia (60+)'
                            ];
                            const sortedUmur = sortByOrder(response.data, umurOrder);
                            renderDoughnutChart('chartUmur', 'Kelompok Umur', sortedUmur, colors
                                .warning);
                        }
                    }
                });

                // 6. Load Chart Produktif
                $.ajax({
                    url: '{{ route('kecamatan.kependudukan.distribusi.produktif') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderPieChart('chartProduktif', 'Status Produktivitas', response.data, [
                                '#28a745', '#dc3545'
                            ]);
                        }
                    }
                });

                // 7. Load Chart Anggota KK
                $.ajax({
                    url: '{{ route('kecamatan.kependudukan.distribusi.anggota_kk') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const kkOrder = ['1 orang', '2 orang', '3-4 orang', '5-6 orang',
                                '7+ orang'
                            ];
                            const sortedKK = sortByOrder(response.data, kkOrder);
                            renderBarChart('chartAnggotaKK', 'Anggota per KK', sortedKK, colors.info);
                        }
                    }
                });

                // 8. Load Chart Pertumbuhan
                $.ajax({
                    url: '{{ route('kecamatan.kependudukan.pertumbuhan') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderLineChart('chartPertumbuhan', 'Pertumbuhan Bulanan', response.data,
                                colors.primary[0]);
                        }
                    }
                });

                // 9. Load Table Wilayah
                $.ajax({
                    url: '{{ route('kecamatan.kependudukan.distribusi.wilayah') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderTableWilayah(response.data);
                        }
                    }
                });
            }

            function sortByOrder(obj, order) {
                const result = {};
                order.forEach(key => {
                    if (obj[key] !== undefined) {
                        result[key] = obj[key];
                    }
                });
                Object.keys(obj).forEach(key => {
                    if (!order.includes(key)) {
                        result[key] = obj[key];
                    }
                });
                return result;
            }

            function renderBarChart(canvasId, title, data, colorPalette) {
                const ctx = document.getElementById(canvasId);
                if (charts[canvasId]) charts[canvasId].destroy();

                const labels = Object.keys(data);
                const values = Object.values(data);
                const backgroundColors = labels.map((_, index) => colorPalette[index % colorPalette.length]);

                charts[canvasId] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah',
                            data: values,
                            backgroundColor: backgroundColors,
                            borderColor: backgroundColors,
                            borderWidth: 1,
                            borderRadius: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 15,
                                cornerRadius: 8,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: function(context) {
                                        return 'Jumlah: ' + formatNumber(context.parsed.y) + ' orang';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.03)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return formatNumber(value);
                                    },
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45,
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
                hideChartLoading(canvasId);
            }

            function renderPieChart(canvasId, title, data, colorPalette) {
                const ctx = document.getElementById(canvasId);
                if (charts[canvasId]) charts[canvasId].destroy();

                charts[canvasId] = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            data: Object.values(data),
                            backgroundColor: colorPalette,
                            borderWidth: 4,
                            borderColor: '#fff',
                            hoverBorderWidth: 6,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 13,
                                        weight: '600'
                                    },
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 15,
                                cornerRadius: 8,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': ' + formatNumber(value) + ' (' + percentage +
                                            '%)';
                                    }
                                }
                            }
                        }
                    }
                });
                hideChartLoading(canvasId);
            }

            function renderDoughnutChart(canvasId, title, data, colorPalette) {
                const ctx = document.getElementById(canvasId);
                if (charts[canvasId]) charts[canvasId].destroy();

                charts[canvasId] = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            data: Object.values(data),
                            backgroundColor: colorPalette,
                            borderWidth: 4,
                            borderColor: '#fff',
                            hoverBorderWidth: 6,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 13,
                                        weight: '600'
                                    },
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 15,
                                cornerRadius: 8,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': ' + formatNumber(value) + ' (' + percentage +
                                            '%)';
                                    }
                                }
                            }
                        }
                    }
                });
                hideChartLoading(canvasId);
            }

            function renderLineChart(canvasId, title, data, color) {
                const ctx = document.getElementById(canvasId);
                if (charts[canvasId]) charts[canvasId].destroy();

                const labels = Object.keys(data).map(key => {
                    const [year, month] = key.split('-');
                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep',
                        'Okt', 'Nov', 'Des'
                    ];
                    return monthNames[parseInt(month) - 1] + ' ' + year;
                });

                charts[canvasId] = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Kelahiran per Bulan',
                            data: Object.values(data),
                            borderColor: color,
                            backgroundColor: color + '20',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointBackgroundColor: color,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 3,
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: color
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 13,
                                        weight: '600'
                                    },
                                    usePointStyle: true,
                                    padding: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 15,
                                cornerRadius: 8,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: function(context) {
                                        return 'Kelahiran: ' + formatNumber(context.parsed.y) +
                                            ' orang';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.03)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return formatNumber(value);
                                    },
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45,
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
                hideChartLoading(canvasId);
            }

            function renderTableWilayah(data) {
                let html = '';
                const badgeColors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary', 'dark',
                    'primary', 'success', 'info', 'warning'
                ];

                data.forEach((item, index) => {
                    const badgeColor = badgeColors[index % badgeColors.length];
                    html += `
                        <tr>
                            <td class="font-weight-bold">${index + 1}</td>
                            <td>
                                <i class="fas fa-map-marker-alt text-${badgeColor} mr-2"></i>
                                <strong>${item.desa || 'Tidak Diketahui'}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-${badgeColor} badge-stat">${formatNumber(item.penduduk)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary badge-stat">${formatNumber(item.kk)}</span>
                            </td>
                            <td class="text-center">
                                <strong>${item.rasio}</strong> orang/KK
                            </td>
                        </tr>
                    `;
                });

                if (html === '') {
                    html = '<tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data</td></tr>';
                }

                $('#tableWilayah').html(html);
            }

            // INITIALIZE - Load semua data secara parallel
            loadAllData();
        });
    </script>
@endpush
