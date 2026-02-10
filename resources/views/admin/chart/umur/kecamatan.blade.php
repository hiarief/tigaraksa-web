@extends('admin.layout.main')
@section('title', 'Statistik Umur')
@section('content-header', 'Statistik Umur Kecamatan')

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
                            <h5 class="font-weight-bold mb-1">Ringkasan Kategori Penduduk</h5>
                            <p class="stat-sublabel-premium mb-0">
                                Distribusi penduduk berdasarkan kelompok umur
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mb-4">

        <!-- Balita -->
        <div class="col-lg-4 col-md-4 col-sm-6 mb-2">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-danger text-white">
                            <i class="fas fa-baby"></i>
                        </div>

                        <div class="ml-3">
                            <p class="stat-number-premium" id="balita-count">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">Balita</p>
                            <p class="stat-sublabel-premium mb-0">0 – 4 Tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Anak -->
        <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-info text-white">
                            <i class="fas fa-child"></i>
                        </div>

                        <div class="ml-3">
                            <p class="stat-number-premium" id="anak-count">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">Anak</p>
                            <p class="stat-sublabel-premium mb-0">5 – 14 Tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Remaja -->
        <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-user-graduate"></i>
                        </div>

                        <div class="ml-3">
                            <p class="stat-number-premium" id="remaja-count">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">Remaja</p>
                            <p class="stat-sublabel-premium mb-0">15 – 24 Tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mb-4">
        <!-- Produktif -->
        <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-success text-white">
                            <i class="fas fa-briefcase"></i>
                        </div>

                        <div class="ml-3">
                            <p class="stat-number-premium" id="produktif-count">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">Produktif</p>
                            <p class="stat-sublabel-premium mb-0">15 – 64 Tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Lansia -->
        <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-warning text-white">
                            <i class="fas fa-user-clock"></i>
                        </div>

                        <div class="ml-3">
                            <p class="stat-number-premium" id="lansia-count">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">Lansia</p>
                            <p class="stat-sublabel-premium mb-0">65+ Tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Pemilih -->
        <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-purple text-white">
                            <i class="fas fa-vote-yea"></i>
                        </div>

                        <div class="ml-3">
                            <p class="stat-number-premium" id="pemilih-count">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">Layak Memilih</p>
                            <p class="stat-sublabel-premium mb-0">≥ 17 Tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">

        <div class="col-12 mb-3">
            <h4 class="section-title">
                <i class="fas fa-chart-line mr-2"></i> Indikator Demografis
            </h4>
        </div>


        <!-- Dependency Ratio -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-indigo text-white">
                            <i class="fas fa-balance-scale"></i>
                        </div>

                        <div class="ml-3">
                            <p class="stat-number-premium" id="dependency-ratio">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">Dependency Ratio</p>
                            <p class="stat-sublabel-premium mb-0">Per 100 penduduk produktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Rata Umur -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-teal text-white">
                            <i class="fas fa-calculator"></i>
                        </div>

                        <div class="ml-3">
                            <p class="stat-number-premium" id="rata-rata-umur">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">Rata-rata Umur</p>
                            <p class="stat-sublabel-premium mb-0">Tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Median Umur -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-danger text-white">
                            <i class="fas fa-chart-bar"></i>
                        </div>

                        <div class="ml-3">
                            <p class="stat-number-premium" id="median-umur">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">Median Umur</p>
                            <p class="stat-sublabel-premium mb-0">Tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Persentase Pemilih -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-warning text-white">
                            <i class="fas fa-percentage"></i>
                        </div>

                        <div class="ml-3">
                            <p class="stat-number-premium" id="persen-pemilih">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">Persentase Pemilih</p>
                            <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Distribusi Umur Penduduk -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Umur Penduduk</h3>
                        <p class="card-subtitle-premium">Piramida penduduk berdasarkan kelompok umur 5 tahunan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="chart-loader-1" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartDistribusiUmur" style="display:none; max-height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Per Desa -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-success">
                    <div class="card-header-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Usia Produktif Per Desa</h3>
                        <p class="card-subtitle-premium">Distribusi penduduk produktif</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="chart-loader-2" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartProduktifDesa" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-info">
                    <div class="card-header-icon">
                        <i class="fas fa-vote-yea"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Layak Memilih Per Desa</h3>
                        <p class="card-subtitle-premium">Penduduk yang memenuhi syarat pemilih</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="chart-loader-3" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartPemilihDesa" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tren Kelahiran -->
    <div class="row mb-4">
        <div class="col-12 mb-3">
            <h4 class="section-title">
                <i class="fas fa-chart-line mr-2"></i> Tren Kelahiran Penduduk
            </h4>
        </div>

        <!-- Statistik Kelahiran -->
        <div class="col-lg-4 col-md-4 mb-lg-0 mb-3">
            <div class="info-box-premium elevation-3"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="info-box-premium-icon">
                    <div class="icon-circle bg-white">
                        <i class="fas fa-users" style="color: #667eea;"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Total Kelahiran Tercatat</span>
                    <span class="info-box-premium-number" id="total-kelahiran">
                        <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                    </span>
                    <small class="d-block" style="opacity: 0.9;">Penduduk</small>
                    <div class="progress-premium">
                        <div class="progress-bar bg-white"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 mb-lg-0 mb-3">
            <div class="info-box-premium bg-gradient-success elevation-3">
                <div class="info-box-premium-icon">
                    <div class="icon-circle bg-white">
                        <i class="fas fa-calendar-check text-success"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Kelahiran Tahun Ini</span>
                    <span class="info-box-premium-number" id="kelahiran-tahun">
                        <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                    </span>
                    <small class="d-block" style="opacity: 0.9;">12 Bulan Terakhir</small>
                    <div class="progress-premium">
                        <div class="progress-bar bg-white"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4">
            <div class="info-box-premium bg-gradient-danger elevation-3">
                <div class="info-box-premium-icon">
                    <div class="icon-circle bg-white">
                        <i class="fas fa-calendar-day text-danger"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Kelahiran Bulan Ini</span>
                    <span class="info-box-premium-number" id="kelahiran-bulan">
                        <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                    </span>
                    <small class="d-block" style="opacity: 0.9;">30 Hari Terakhir</small>
                    <div class="progress-premium">
                        <div class="progress-bar bg-white"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Tren Kelahiran -->
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-danger">
                    <div class="card-header-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Tren Kelahiran Per Bulan</h3>
                        <p class="card-subtitle-premium">12 Bulan Terakhir</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="chart-loader-6" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartTrenBulan" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-secondary">
                    <div class="card-header-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Kelahiran Per Tahun</h3>
                        <p class="card-subtitle-premium">20 Tahun Terakhir</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="chart-loader-7" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartTrenTahun" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Komposisi Umur Per Desa -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-header-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Komposisi Umur Per Desa</h3>
                        <p class="card-subtitle-premium">Distribusi kelompok umur berdasarkan desa</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="chart-loader-8" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartUmurDesa" style="display:none; max-height: 400px;"></canvas>
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
                primary: '#667eea',
                success: '#4ecdc4',
                danger: '#ff6b6b',
                warning: '#ffeaa7',
                info: '#45b7d1',
                purple: '#a29bfe',
                gradient: ['#667eea', '#764ba2', '#f093fb', '#4facfe']
            };

            function formatNumber(num) {
                return new Intl.NumberFormat('id-ID').format(num);
            }

            function hideLoader(loaderId, canvasId) {
                $(loaderId).fadeOut(300, function() {
                    $(canvasId).fadeIn(400);
                });
            }

            function animateValue(id, start, end, duration) {
                const element = document.getElementById(id);
                if (!element) return;

                const isDecimal = id.includes('ratio') || id.includes('rata') || id.includes('median');
                const isPercentage = id.includes('persen');

                const startTime = performance.now();

                function update(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                    const current = start + (end - start) * easeOutQuart;

                    if (isPercentage) {
                        element.textContent = current.toFixed(2) + '%';
                    } else if (isDecimal) {
                        element.textContent = current.toFixed(2);
                    } else {
                        element.textContent = formatNumber(Math.round(current));
                    }

                    if (progress < 1) {
                        requestAnimationFrame(update);
                    } else {
                        if (isPercentage) {
                            element.textContent = end.toFixed(2) + '%';
                        } else if (isDecimal) {
                            element.textContent = end.toFixed(2);
                        } else {
                            element.textContent = formatNumber(end);
                        }
                    }
                }

                requestAnimationFrame(update);
            }

            function loadKategoriUmur() {
                $.ajax({
                    url: '{{ route('kecamatan.umur.kategori.umur') }}',
                    method: 'GET',
                    success: function(data) {
                        if (data.error) {
                            console.error('Error:', data.message);
                            return;
                        }

                        animateValue('balita-count', 0, data.balita, 1000);
                        animateValue('anak-count', 0, data.anak, 1000);
                        animateValue('remaja-count', 0, data.remaja, 1000);
                        animateValue('produktif-count', 0, data.produktif, 1000);
                        animateValue('lansia-count', 0, data.lansia, 1000);
                        animateValue('pemilih-count', 0, data.layak_memilih, 1000);
                    }
                });
            }

            function loadStatistikLanjutan() {
                $.ajax({
                    url: '{{ route('kecamatan.umur.statistik.lanjutan') }}',
                    method: 'GET',
                    success: function(data) {
                        if (data.error) {
                            console.error('Error:', data.message);
                            return;
                        }

                        animateValue('dependency-ratio', 0, data.dependency_ratio, 1000);
                        animateValue('rata-rata-umur', 0, data.rata_rata_umur, 1000);
                        animateValue('median-umur', 0, data.median_umur, 1000);

                        // Animate percentage
                        const persenValue = parseFloat(data.persen_layak_memilih);
                        const element = document.getElementById('persen-pemilih');
                        const startTime = performance.now();

                        function update(currentTime) {
                            const elapsed = currentTime - startTime;
                            const progress = Math.min(elapsed / 1000, 1);
                            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                            const current = persenValue * easeOutQuart;

                            element.textContent = current.toFixed(2) + '%';

                            if (progress < 1) {
                                requestAnimationFrame(update);
                            } else {
                                element.textContent = persenValue.toFixed(2) + '%';
                            }
                        }

                        requestAnimationFrame(update);
                    }
                });
            }

            function loadDistribusiUmur() {
                $.ajax({
                    url: '{{ route('kecamatan.umur.distribusi.umur') }}',
                    method: 'GET',
                    success: function(data) {
                        if (data.error || !Array.isArray(data) || data.length === 0) {
                            console.error('Error loading data');
                            return;
                        }

                        hideLoader('#chart-loader-1', '#chartDistribusiUmur');

                        const ctx = document.getElementById('chartDistribusiUmur').getContext('2d');
                        charts.distribusiUmur = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.map(item => item.kelompok_umur + ' tahun'),
                                datasets: [{
                                    label: 'Jumlah Penduduk',
                                    data: data.map(item => item.jumlah),
                                    backgroundColor: colors.primary,
                                    borderColor: colors.primary,
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
                                                return 'Jumlah: ' + formatNumber(context
                                                    .parsed.y) + ' orang';
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
                                            font: {
                                                size: 12,
                                                weight: 'bold'
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            }

            function loadProduktifPerDesa() {
                $.ajax({
                    url: '{{ route('kecamatan.umur.produktif.desa') }}',
                    method: 'GET',
                    success: function(data) {
                        if (data.error || !Array.isArray(data)) {
                            console.error('Error loading data');
                            return;
                        }

                        hideLoader('#chart-loader-2', '#chartProduktifDesa');

                        const ctx = document.getElementById('chartProduktifDesa').getContext('2d');
                        charts.produktifDesa = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.map(item => item.desa),
                                datasets: [{
                                    label: 'Usia Produktif',
                                    data: data.map(item => item.produktif),
                                    backgroundColor: colors.success,
                                    borderRadius: 10
                                }]
                            },
                            options: {
                                indexAxis: 'y',
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
                                                const item = data[context.dataIndex];
                                                const persen = ((item.produktif / item
                                                    .total) * 100).toFixed(1);
                                                return `Produktif: ${formatNumber(context.parsed.x)} (${persen}%)`;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
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
                                    y: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            font: {
                                                size: 12,
                                                weight: 'bold'
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            }

            function loadLayakMemilihPerDesa() {
                $.ajax({
                    url: '{{ route('kecamatan.umur.layak_memilih.desa') }}',
                    method: 'GET',
                    success: function(data) {
                        if (data.error || !Array.isArray(data)) {
                            console.error('Error loading data');
                            return;
                        }

                        hideLoader('#chart-loader-3', '#chartPemilihDesa');

                        const ctx = document.getElementById('chartPemilihDesa').getContext('2d');
                        charts.pemilihDesa = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: data.map(item => item.desa),
                                datasets: [{
                                    data: data.map(item => item.layak_memilih),
                                    backgroundColor: [
                                        '#667eea', '#764ba2', '#f093fb', '#4facfe',
                                        '#00f2fe', '#43e97b', '#fa709a', '#fee140'
                                    ],
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
                                                const item = data[context.dataIndex];
                                                const persen = ((item.layak_memilih / item
                                                    .total) * 100).toFixed(1);
                                                return `${item.desa}: ${formatNumber(context.parsed)} (${persen}%)`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            }

            function loadTrenPertumbuhan() {
                $.ajax({
                    url: '{{ route('kecamatan.umur.tren.pertumbuhan') }}',
                    method: 'GET',
                    success: function(data) {
                        if (data.error) {
                            console.error('Error:', data.message);
                            return;
                        }

                        if (data.statistik) {
                            animateValue('total-kelahiran', 0, data.statistik.total_kelahiran, 1000);
                            animateValue('kelahiran-tahun', 0, data.statistik.kelahiran_tahun_ini,
                                1000);
                            animateValue('kelahiran-bulan', 0, data.statistik.kelahiran_bulan_ini,
                                1000);
                        }

                        const hasMonthData = data.per_bulan && data.per_bulan.length > 0;
                        const hasYearData = data.per_tahun && data.per_tahun.length > 0;

                        // Tren Per Bulan
                        if (hasMonthData) {
                            hideLoader('#chart-loader-6', '#chartTrenBulan');

                            const maxValue = Math.max(...data.per_bulan.map(item => item.jumlah));
                            const suggestedMax = Math.ceil(maxValue * 1.1);

                            const ctxBulan = document.getElementById('chartTrenBulan').getContext('2d');
                            charts.trenBulan = new Chart(ctxBulan, {
                                type: 'line',
                                data: {
                                    labels: data.per_bulan.map(item => item.label),
                                    datasets: [{
                                        label: 'Jumlah Kelahiran',
                                        data: data.per_bulan.map(item => item.jumlah),
                                        borderColor: colors.danger,
                                        backgroundColor: 'rgba(255, 107, 107, 0.1)',
                                        fill: true,
                                        tension: 0.4,
                                        borderWidth: 3,
                                        pointRadius: 6,
                                        pointHoverRadius: 8,
                                        pointBackgroundColor: colors.danger,
                                        pointBorderColor: '#fff',
                                        pointBorderWidth: 3,
                                        pointHoverBackgroundColor: '#fff',
                                        pointHoverBorderColor: colors.danger
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
                                                    return 'Kelahiran: ' + formatNumber(
                                                        context.parsed.y) + ' orang';
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            suggestedMax: suggestedMax,
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
                                                font: {
                                                    size: 12,
                                                    weight: 'bold'
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }

                        // Tren Per Tahun
                        if (hasYearData) {
                            hideLoader('#chart-loader-7', '#chartTrenTahun');

                            const maxValue = Math.max(...data.per_tahun.map(item => item.jumlah));
                            const suggestedMax = Math.ceil(maxValue * 1.1);

                            const ctxTahun = document.getElementById('chartTrenTahun').getContext('2d');
                            charts.trenTahun = new Chart(ctxTahun, {
                                type: 'bar',
                                data: {
                                    labels: data.per_tahun.map(item => item.tahun),
                                    datasets: [{
                                        label: 'Jumlah Kelahiran',
                                        data: data.per_tahun.map(item => item.jumlah),
                                        backgroundColor: '#6c757d',
                                        borderRadius: 10,
                                        hoverBackgroundColor: '#5a6268'
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
                                                    return 'Kelahiran: ' + formatNumber(
                                                        context.parsed.y) + ' orang';
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            suggestedMax: suggestedMax,
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
                                                font: {
                                                    size: 12,
                                                    weight: 'bold'
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    }
                });
            }

            function loadDistribusiUmurPerDesa() {
                $.ajax({
                    url: '{{ route('kecamatan.umur.distribusi.umur.desa') }}',
                    method: 'GET',
                    success: function(data) {
                        if (data.error || !Array.isArray(data)) {
                            console.error('Error loading data');
                            return;
                        }

                        hideLoader('#chart-loader-8', '#chartUmurDesa');

                        const kelompokUmur = ['0-4', '5-14', '15-24', '25-64', '65+'];
                        const desas = [...new Set(data.map(item => item.desa))];

                        const datasets = kelompokUmur.map((kelompok, index) => {
                            const warna = [colors.danger, colors.info, colors.primary, colors
                                .success, colors.warning
                            ];
                            return {
                                label: kelompok + ' tahun',
                                data: desas.map(desa => {
                                    const item = data.find(d => d.desa === desa && d
                                        .kelompok_umur === kelompok);
                                    return item ? item.jumlah : 0;
                                }),
                                backgroundColor: warna[index]
                            };
                        });

                        const ctx = document.getElementById('chartUmurDesa').getContext('2d');
                        charts.umurDesa = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: desas,
                                datasets: datasets
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
                                                return context.dataset.label + ': ' +
                                                    formatNumber(context.parsed.y) +
                                                    ' orang';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        stacked: true,
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            font: {
                                                size: 12,
                                                weight: 'bold'
                                            }
                                        }
                                    },
                                    y: {
                                        stacked: true,
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
                                    }
                                }
                            }
                        });
                    }
                });
            }

            function initializeData() {
                loadKategoriUmur();
                loadStatistikLanjutan();
                loadDistribusiUmur();
                loadProduktifPerDesa();
                loadLayakMemilihPerDesa();
                loadTrenPertumbuhan();
                loadDistribusiUmurPerDesa();
            }

            initializeData();
        });
    </script>
@endpush
