@extends('admin.layout.main')
@section('title', 'Dashboard')
@section('content-header', 'Dashboard Statistik Kependudukan')

@section('content')

    <!-- Ringkasan Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card-premium elevation-2">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-chart-line"></i>
                        </div>

                        <div class="ml-3">
                            <h5 class="font-weight-bold mb-1">Dashboard Statistik Kependudukan</h5>
                            <p class="stat-sublabel-premium mb-0">
                                Analisis dan visualisasi data demografis kecamatan
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3">

                <!-- Header -->
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-sliders-h"></i>
                    </div>

                    <div class="card-header-text">
                        <h3 class="card-title-premium">Panel Filter & Kontrol</h3>
                        <p class="card-subtitle-premium">Pengaturan filter dan analisis data</p>
                    </div>

                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="card-body-premium">
                    <div class="row align-items-end">

                        <div class="col-md-8">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold text-sm">
                                    <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                                    Filter Desa
                                </label>

                                <select id="filterDesa" class="form-control form-control-lg select2-primary">
                                    <option value="">Semua Desa</option>
                                    @foreach ($desaList as $desa)
                                        <option value="{{ $desa->code }}">{{ $desa->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <button type="button" id="btnAnalisis" class="btn btn-primary btn-lg btn-block elevation-2">
                                <i class="fas fa-chart-line mr-2"></i>
                                Analisis Data
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- STATISTIK JUMLAH -->
    <div class="row mb-4">

        <div class="col-12 mb-3">
            <h4 class="section-title">
                <i class="fas fa-calculator mr-2"></i> Statistik Ringkasan
            </h4>
        </div>

        <!-- Total Penduduk -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-info text-white">
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

                            <p class="stat-sublabel-premium mb-0">Seluruh penduduk</p>
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
                            <i class="fas fa-home"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalKK">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Total Kepala Keluarga
                                <i class="fas fa-home stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Kartu Keluarga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rata-rata KK -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-warning text-white">
                            <i class="fas fa-user-friends"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="rataKK">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Rata-rata Anggota / KK
                                <i class="fas fa-user-friends stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Orang per keluarga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BPJS -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-danger text-white">
                            <i class="fas fa-heartbeat"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium">
                                <span id="persenBPJS">
                                    <span class="skeleton-premium skeleton-number-premium"></span>
                                </span>
                                <span class="d-none" id="persenBPJSSymbol">%</span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Kepesertaan BPJS
                                <i class="fas fa-heartbeat stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Persentase peserta</p>
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
                <i class="fas fa-chart-bar mr-2"></i> Statistik Distribusi Demografis
            </h4>
        </div>

        <!-- Gender -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-venus-mars"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Statistik Jenis Kelamin</h3>
                        <p class="card-subtitle-premium">Komposisi penduduk berdasarkan gender</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingGender" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartGender" style="display:none; max-height: 320px;"></canvas>
                    <div id="statsGenderText" class="mt-3" style="display:none;"></div>
                </div>
            </div>
        </div>

        <!-- Umur -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-info">
                    <div class="card-header-icon">
                        <i class="fas fa-birthday-cake"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Statistik Kelompok Umur</h3>
                        <p class="card-subtitle-premium">Distribusi penduduk per kelompok usia</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingUmur" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartUmur" style="display:none; max-height: 320px;"></canvas>
                    <div id="statsUmurText" class="mt-3" style="display:none;"></div>
                </div>
            </div>
        </div>

        <!-- BPJS -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-success">
                    <div class="card-header-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Statistik Kepesertaan BPJS</h3>
                        <p class="card-subtitle-premium">Status kepesertaan jaminan kesehatan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingBPJS" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartBPJS" style="display:none; max-height: 320px;"></canvas>
                    <div id="statsBPJSText" class="mt-3" style="display:none;"></div>
                </div>
            </div>
        </div>

        <!-- Perkawinan -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-warning">
                    <div class="card-header-icon">
                        <i class="fas fa-ring"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Statistik Status Perkawinan</h3>
                        <p class="card-subtitle-premium">Klasifikasi status pernikahan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingPerkawinan" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartPerkawinan" style="display:none; max-height: 320px;"></canvas>
                    <div id="statsPerkawinanText" class="mt-3" style="display:none;"></div>
                </div>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Statistik Pendapatan</h3>
                        <p class="card-subtitle-premium">Distribusi tingkat pendapatan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingPendapatan" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartPendapatan" style="display:none; max-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Kepemilikan Rumah -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-success">
                    <div class="card-header-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Statistik Kepemilikan Rumah</h3>
                        <p class="card-subtitle-premium">Status kepemilikan tempat tinggal</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingRumah" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartRumah" style="display:none; max-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Golongan Darah -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-danger">
                    <div class="card-header-icon">
                        <i class="fas fa-tint"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Statistik Golongan Darah</h3>
                        <p class="card-subtitle-premium">Distribusi golongan darah penduduk</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingGolDarah" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartGolDarah" style="display:none; max-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Distribusi RT/RW -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-info">
                    <div class="card-header-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi RT/RW</h3>
                        <p class="card-subtitle-premium">Sebaran penduduk per wilayah</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingRTRW" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div id="tableRTRW" style="display:none;">
                        <div class="table-container-premium" style="max-height:400px; overflow-y:auto;">
                            <table class="table-premium table">
                                <thead>
                                    <tr>
                                        <th>RT/RW</th>
                                        <th class="text-right">Jumlah Penduduk</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyRTRW"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Ringkasan Per Desa -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-dark">
                    <div class="card-header-icon">
                        <i class="fas fa-table"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Ringkasan Statistik Per Desa</h3>
                        <p class="card-subtitle-premium">Rekapitulasi lengkap data demografis</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium p-0">
                    <div id="loadingPerDesa" class="loading-premium" style="padding:60px 20px;">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div id="tablePerDesa" style="display:none;">
                        <div class="table-container-premium">
                            <div class="table-responsive">
                                <table class="table-premium table-hover" id="tblPerDesa">
                                    <thead>
                                        <tr>
                                            <th width="25%">Desa</th>
                                            <th width="12%" class="text-right">Penduduk</th>
                                            <th width="12%" class="text-right">KK</th>
                                            <th width="12%" class="text-right">Laki-laki</th>
                                            <th width="12%" class="text-right">Perempuan</th>
                                            <th width="12%" class="text-right">Punya BPJS</th>
                                            <th width="15%" class="text-right">% BPJS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyPerDesa"></tbody>
                                </table>
                            </div>
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
                danger: ['#dc3545', '#c82333', '#bd2130', '#b21f2d', '#a71d2a'],
                mixed: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2', '#fd7e14', '#20c997',
                    '#e83e8c', '#6c757d', '#343a40'
                ]
            };

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function hideLoading(loadingId, contentId) {
                $('#' + loadingId).fadeOut(300, function() {
                    $('#' + contentId).fadeIn(400);
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

            // Initialize Select2
            $('.select2-primary').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih Desa',
                allowClear: true,
                width: '100%'
            });

            // Load semua data saat pertama kali
            loadAllStats();

            // Reload saat tombol Analisis diklik
            $('#btnAnalisis').click(function() {
                loadAllStats();
            });

            // Optional: Reload saat filter desa berubah
            $('#filterDesa').change(function() {
                loadAllStats();
            });

            function loadAllStats() {
                const desa = $('#filterDesa').val();

                loadKependudukan(desa);
                loadGender(desa);
                loadUmur(desa);
                loadBPJS(desa);
                loadPerkawinan(desa);
                loadPendapatan(desa);
                loadKepemilikanRumah(desa);
                loadGolDarah(desa);
                loadPerDesa();
            }

            // 1. Load Statistik Kependudukan
            function loadKependudukan(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.kependudukan') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        animateNumber('#totalPenduduk', data.total_penduduk);
                        animateNumber('#totalKK', data.total_kk);
                        $('#rataKK').html(data.rata_anggota_kk);

                        // Distribusi RT/RW
                        hideLoading('loadingRTRW', 'tableRTRW');
                        let html = '';
                        data.distribusi_rt_rw.forEach(function(item) {
                            html += `<tr>
                                <td><span class="badge badge-light">RT/RW ${item.rt_rw}</span></td>
                                <td class="text-right"><strong>${formatNumber(item.jumlah)}</strong></td>
                            </tr>`;
                        });
                        $('#tbodyRTRW').html(html);
                    }
                });
            }

            // 2. Load Statistik Gender
            function loadGender(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.gender') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        hideLoading('loadingGender', 'chartGender');
                        $('#statsGenderText').fadeIn(400);

                        if (charts.gender) charts.gender.destroy();

                        const ctx = document.getElementById('chartGender').getContext('2d');
                        charts.gender = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: ['#3b82f6', '#ec4899'],
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
                                                const total = context.dataset.data.reduce((
                                                    a, b) => a + b, 0);
                                                const percentage = ((value / total) * 100)
                                                    .toFixed(1);
                                                return label + ': ' + formatNumber(value) +
                                                    ' (' + percentage + '%)';
                                            }
                                        }
                                    }
                                }
                            }
                        });

                        $('#statsGenderText').html(`
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-right">
                                        <h4 class="text-primary mb-1">${formatNumber(data.laki_laki)}</h4>
                                        <p class="text-muted mb-0"><small>Laki-laki</small></p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-danger mb-1">${formatNumber(data.perempuan)}</h4>
                                    <p class="text-muted mb-0"><small>Perempuan</small></p>
                                </div>
                            </div>
                            <div class="alert alert-light mt-3 mb-0">
                                <i class="fas fa-info-circle mr-1"></i>
                                <small>Rasio: <strong>${data.rasio}</strong> laki-laki per 100 perempuan</small>
                            </div>
                        `);
                    }
                });
            }

            // 3. Load Statistik Umur
            function loadUmur(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.umur') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        hideLoading('loadingUmur', 'chartUmur');
                        $('#statsUmurText').fadeIn(400);

                        if (charts.umur) charts.umur.destroy();

                        const ctx = document.getElementById('chartUmur').getContext('2d');
                        charts.umur = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    label: 'Jumlah Penduduk',
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: '#3b82f6',
                                    borderRadius: 10,
                                    barThickness: 40
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

                        $('#statsUmurText').html(`
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="border-right">
                                        <h5 class="text-success mb-1">${formatNumber(data.produktif)}</h5>
                                        <small class="text-muted">Usia Produktif</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-right">
                                        <h5 class="text-warning mb-1">${formatNumber(data.non_produktif)}</h5>
                                        <small class="text-muted">Non Produktif</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <h5 class="text-info mb-1">${formatNumber(data.lansia)}</h5>
                                    <small class="text-muted">Lansia (60+)</small>
                                </div>
                            </div>
                        `);
                    }
                });
            }

            // 4. Load Statistik BPJS
            function loadBPJS(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.bpjs') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        hideLoading('loadingBPJS', 'chartBPJS');
                        $('#statsBPJSText').fadeIn(400);
                        $('#persenBPJS').html(data.persentase);
                        $('#persenBPJSSymbol').removeClass('d-none');

                        if (charts.bpjs) charts.bpjs.destroy();

                        const ctx = document.getElementById('chartBPJS').getContext('2d');
                        charts.bpjs = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: ['#10b981', '#ef4444'],
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
                                                const total = context.dataset.data.reduce((
                                                    a, b) => a + b, 0);
                                                const percentage = ((value / total) * 100)
                                                    .toFixed(1);
                                                return label + ': ' + formatNumber(value) +
                                                    ' (' + percentage + '%)';
                                            }
                                        }
                                    }
                                }
                            }
                        });

                        let jenisBPJSHtml =
                            '<div class="alert alert-light"><h6 class="mb-2"><i class="fas fa-list mr-2"></i>Jenis BPJS:</h6><ul class="mb-0 pl-3">';
                        data.jenis_bpjs.forEach(function(item) {
                            jenisBPJSHtml +=
                                `<li class="mb-1">${item.jenis_bpjs || 'Tidak Diketahui'}: <strong>${formatNumber(item.jumlah)}</strong></li>`;
                        });
                        jenisBPJSHtml += '</ul></div>';

                        $('#statsBPJSText').html(jenisBPJSHtml);
                    }
                });
            }

            // 5. Load Statistik Perkawinan
            function loadPerkawinan(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.perkawinan') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        hideLoading('loadingPerkawinan', 'chartPerkawinan');
                        $('#statsPerkawinanText').fadeIn(400);

                        if (charts.perkawinan) charts.perkawinan.destroy();

                        const ctx = document.getElementById('chartPerkawinan').getContext('2d');
                        charts.perkawinan = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: ['#f59e0b', '#8b5cf6', '#ef4444',
                                        '#6b7280'
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
                                                const label = context.label || '';
                                                const value = context.parsed || 0;
                                                const total = context.dataset.data.reduce((
                                                    a, b) => a + b, 0);
                                                const percentage = ((value / total) * 100)
                                                    .toFixed(1);
                                                return label + ': ' + formatNumber(value) +
                                                    ' (' + percentage + '%)';
                                            }
                                        }
                                    }
                                }
                            }
                        });

                        $('#statsPerkawinanText').html(`
                            <div class="alert alert-light text-center mb-0">
                                <i class="fas fa-certificate mr-1"></i>
                                <strong>Perkawinan Tercatat:</strong> ${formatNumber(data.kawin_tercatat)} orang
                            </div>
                        `);
                    }
                });
            }

            // 6. Load Statistik Pendapatan
            function loadPendapatan(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.pendapatan') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        hideLoading('loadingPendapatan', 'chartPendapatan');

                        if (charts.pendapatan) charts.pendapatan.destroy();

                        const ctx = document.getElementById('chartPendapatan').getContext('2d');
                        charts.pendapatan = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    label: 'Jumlah Penduduk',
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: '#10b981',
                                    borderRadius: 10
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                indexAxis: 'y',
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
                                                    .parsed.x) + ' orang';
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

            // 7. Load Statistik Kepemilikan Rumah
            function loadKepemilikanRumah(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.kepemilikan.rumah') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        hideLoading('loadingRumah', 'chartRumah');

                        if (charts.rumah) charts.rumah.destroy();

                        const ctx = document.getElementById('chartRumah').getContext('2d');
                        charts.rumah = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b',
                                        '#ef4444'
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
                                                const label = context.label || '';
                                                const value = context.parsed || 0;
                                                const total = context.dataset.data.reduce((
                                                    a, b) => a + b, 0);
                                                const percentage = ((value / total) * 100)
                                                    .toFixed(1);
                                                return label + ': ' + formatNumber(value) +
                                                    ' (' + percentage + '%)';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            }

            // 8. Load Statistik Golongan Darah
            function loadGolDarah(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.gol.darah') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        hideLoading('loadingGolDarah', 'chartGolDarah');

                        if (charts.goldarah) charts.goldarah.destroy();

                        const ctx = document.getElementById('chartGolDarah').getContext('2d');
                        charts.goldarah = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    label: 'Jumlah',
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: '#ef4444',
                                    borderRadius: 10,
                                    barThickness: 50
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

            // 9. Load Statistik Per Desa
            function loadPerDesa() {
                $.ajax({
                    url: '{{ route('dashboard.per.desa') }}',
                    success: function(data) {
                        hideLoading('loadingPerDesa', 'tablePerDesa');

                        const badgeColors = ['primary', 'success', 'info', 'warning', 'danger',
                            'secondary', 'dark'
                        ];
                        let html = '';
                        data.forEach(function(item, index) {
                            const badgeColor = badgeColors[index % badgeColors.length];
                            const persenBPJS = item.total_penduduk > 0 ?
                                ((item.punya_bpjs / item.total_penduduk) * 100).toFixed(2) :
                                0;

                            html += `<tr>
                                <td>
                                    <i class="fas fa-map-marker-alt text-${badgeColor} mr-2"></i>
                                    <strong>${item.desa || 'Tidak Diketahui'}</strong>
                                </td>
                                <td class="text-right">
                                    <span class="badge badge-${badgeColor} badge-stat">${formatNumber(item.total_penduduk)}</span>
                                </td>
                                <td class="text-right">
                                    <span class="badge badge-secondary badge-stat">${formatNumber(item.total_kk)}</span>
                                </td>
                                <td class="text-right">${formatNumber(item.laki_laki)}</td>
                                <td class="text-right">${formatNumber(item.perempuan)}</td>
                                <td class="text-right">${formatNumber(item.punya_bpjs)}</td>
                                <td class="text-right">
                                    <span class="badge badge-success">${persenBPJS}%</span>
                                </td>
                            </tr>`;
                        });

                        if (html === '') {
                            html =
                                '<tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data</td></tr>';
                        }

                        $('#tbodyPerDesa').html(html);
                    }
                });
            }
        });
    </script>
@endpush
