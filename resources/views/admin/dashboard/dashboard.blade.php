@extends('admin.layout.main')
@section('title', 'Dashboard')
@section('content-header', 'Dashboard Statistik Kependudukan')

@section('content')
    <div class="container-fluid">

        <!-- Filter Section - Premium Design -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-primary card-outline elevation-2">
                    <div class="card-header bg-gradient-primary border-0">
                        <h3 class="card-title text-white">
                            <i class="fas fa-sliders-h mr-2"></i>Panel Filter & Kontrol
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-dark text-sm">
                                        <i class="fas fa-map-marker-alt text-primary mr-1"></i>Filter Desa
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
                                <button type="button" id="btnAnalisis"
                                    class="btn btn-primary btn-lg btn-block elevation-2">
                                    <i class="fas fa-chart-line mr-2"></i>Analisis Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Premium Info Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
                <div class="info-box-premium bg-gradient-info elevation-3">
                    <div class="info-box-premium-icon">
                        <div class="icon-circle bg-white">
                            <i class="fas fa-users text-info"></i>
                        </div>
                    </div>
                    <div class="info-box-premium-content">
                        <span class="info-box-premium-text">Total Penduduk</span>
                        <span class="info-box-premium-number" id="totalPenduduk">
                            <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                        </span>
                        <div class="progress-premium">
                            <div class="progress-bar bg-white"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
                <div class="info-box-premium bg-gradient-success elevation-3">
                    <div class="info-box-premium-icon">
                        <div class="icon-circle bg-white">
                            <i class="fas fa-home text-success"></i>
                        </div>
                    </div>
                    <div class="info-box-premium-content">
                        <span class="info-box-premium-text">Total Kepala Keluarga</span>
                        <span class="info-box-premium-number" id="totalKK">
                            <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                        </span>
                        <div class="progress-premium">
                            <div class="progress-bar bg-white"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
                <div class="info-box-premium bg-gradient-warning elevation-3">
                    <div class="info-box-premium-icon">
                        <div class="icon-circle bg-white">
                            <i class="fas fa-user-friends text-warning"></i>
                        </div>
                    </div>
                    <div class="info-box-premium-content">
                        <span class="info-box-premium-text">Rata-rata Anggota/KK</span>
                        <span class="info-box-premium-number" id="rataKK">
                            <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                        </span>
                        <div class="progress-premium">
                            <div class="progress-bar bg-white"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="info-box-premium bg-gradient-danger elevation-3">
                    <div class="info-box-premium-icon">
                        <div class="icon-circle bg-white">
                            <i class="fas fa-heartbeat text-danger"></i>
                        </div>
                    </div>
                    <div class="info-box-premium-content">
                        <span class="info-box-premium-text">Kepesertaan BPJS</span>
                        <span class="info-box-premium-number" id="persenBPJS">
                            <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                        </span>
                        <div class="progress-premium">
                            <div class="progress-bar bg-white"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1: Gender & Umur -->
        <div class="row">
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
        </div>

        <!-- Charts Row 2: BPJS & Perkawinan -->
        <div class="row">
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
        </div>

        <!-- Charts Row 3: Pendapatan & Kepemilikan Rumah -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card card-widget-premium elevation-3">
                    <div class="card-header-premium bg-gradient-teal">
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

            <div class="col-lg-6 mb-4">
                <div class="card card-widget-premium elevation-3">
                    <div class="card-header-premium bg-gradient-indigo">
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
        </div>

        <!-- Charts Row 4: Distribusi RT/RW & Golongan Darah -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card card-widget-premium elevation-3">
                    <div class="card-header-premium bg-gradient-purple">
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
                        <div id="tableRTRW" style="display:none; max-height: 400px; overflow-y: auto;">
                            <table class="table-premium-compact table">
                                <thead class="thead-premium">
                                    <tr>
                                        <th><i class="fas fa-map-pin mr-1"></i>RT/RW</th>
                                        <th class="text-right"><i class="fas fa-users mr-1"></i>Jumlah Penduduk</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyRTRW"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

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
        </div>

        <!-- Tabel Summary Per Desa - Premium Design -->
        <div class="row">
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
                        <div id="loadingPerDesa" class="loading-premium" style="padding: 60px 20px;">
                            <div class="spinner-premium">
                                <div class="double-bounce1"></div>
                                <div class="double-bounce2"></div>
                            </div>
                            <p class="loading-text">Memproses data...</p>
                        </div>
                        <div id="tablePerDesa" style="display:none;">
                            <div class="table-responsive">
                                <table class="table-premium table" id="tblPerDesa">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-map-marked-alt mr-1"></i>Desa</th>
                                            <th class="text-right"><i class="fas fa-users mr-1"></i>Penduduk</th>
                                            <th class="text-right"><i class="fas fa-home mr-1"></i>KK</th>
                                            <th class="text-right"><i class="fas fa-male mr-1"></i>Laki-laki</th>
                                            <th class="text-right"><i class="fas fa-female mr-1"></i>Perempuan</th>
                                            <th class="text-right"><i class="fas fa-heartbeat mr-1"></i>Punya BPJS</th>
                                            <th class="text-right"><i class="fas fa-percentage mr-1"></i>% BPJS</th>
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

@push('styles')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            let charts = {};

            // Initialize Select2 with premium theme
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

            // Optional: Reload saat filter desa berubah (auto-reload)
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
                        $('#totalPenduduk').html(data.total_penduduk.toLocaleString('id-ID'));
                        $('#totalKK').html(data.total_kk.toLocaleString('id-ID'));
                        $('#rataKK').html(data.rata_anggota_kk);

                        // Distribusi RT/RW
                        $('#loadingRTRW').fadeOut(300, function() {
                            $('#tableRTRW').fadeIn(400);
                        });
                        let html = '';
                        data.distribusi_rt_rw.forEach(function(item) {
                            html += `<tr>
                                <td><span class="badge badge-light">RT/RW ${item.rt_rw}</span></td>
                                <td class="text-right"><strong>${item.jumlah.toLocaleString('id-ID')}</strong></td>
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
                        $('#loadingGender').fadeOut(300, function() {
                            $('#chartGender').fadeIn(400);
                            $('#statsGenderText').fadeIn(400);
                        });

                        // Destroy existing chart
                        if (charts.gender) charts.gender.destroy();

                        // Create pie chart
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
                                        }
                                    }
                                }
                            }
                        });

                        $('#statsGenderText').html(`
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-right">
                                        <h4 class="text-primary mb-1">${data.laki_laki.toLocaleString('id-ID')}</h4>
                                        <p class="text-muted mb-0"><small>Laki-laki</small></p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-danger mb-1">${data.perempuan.toLocaleString('id-ID')}</h4>
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
                        $('#loadingUmur').fadeOut(300, function() {
                            $('#chartUmur').fadeIn(400);
                            $('#statsUmurText').fadeIn(400);
                        });

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
                                    borderRadius: 8,
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
                                        cornerRadius: 8
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0,0,0,0.05)'
                                        },
                                        ticks: {
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
                                        <h5 class="text-success mb-1">${data.produktif.toLocaleString('id-ID')}</h5>
                                        <small class="text-muted">Usia Produktif</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-right">
                                        <h5 class="text-warning mb-1">${data.non_produktif.toLocaleString('id-ID')}</h5>
                                        <small class="text-muted">Non Produktif</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <h5 class="text-info mb-1">${data.lansia.toLocaleString('id-ID')}</h5>
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
                        $('#loadingBPJS').fadeOut(300, function() {
                            $('#chartBPJS').fadeIn(400);
                            $('#statsBPJSText').fadeIn(400);
                        });
                        $('#persenBPJS').html(data.persentase + '%');

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
                                        cornerRadius: 8
                                    }
                                }
                            }
                        });

                        let jenisBPJSHtml =
                            '<div class="alert alert-light"><h6 class="mb-2"><i class="fas fa-list mr-2"></i>Jenis BPJS:</h6><ul class="mb-0 pl-3">';
                        data.jenis_bpjs.forEach(function(item) {
                            jenisBPJSHtml +=
                                `<li class="mb-1">${item.jenis_bpjs || 'Tidak Diketahui'}: <strong>${item.jumlah.toLocaleString('id-ID')}</strong></li>`;
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
                        $('#loadingPerkawinan').fadeOut(300, function() {
                            $('#chartPerkawinan').fadeIn(400);
                            $('#statsPerkawinanText').fadeIn(400);
                        });

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
                                        cornerRadius: 8
                                    }
                                }
                            }
                        });

                        $('#statsPerkawinanText').html(`
                            <div class="alert alert-light text-center mb-0">
                                <i class="fas fa-certificate mr-1"></i>
                                <strong>Perkawinan Tercatat:</strong> ${data.kawin_tercatat.toLocaleString('id-ID')} orang
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
                        $('#loadingPendapatan').fadeOut(300, function() {
                            $('#chartPendapatan').fadeIn(400);
                        });

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
                                    borderRadius: 8
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
                                        cornerRadius: 8
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0,0,0,0.05)'
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
                        $('#loadingRumah').fadeOut(300, function() {
                            $('#chartRumah').fadeIn(400);
                        });

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
                                        cornerRadius: 8
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
                        $('#loadingGolDarah').fadeOut(300, function() {
                            $('#chartGolDarah').fadeIn(400);
                        });

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
                                    borderRadius: 8,
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
                                        cornerRadius: 8
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0,0,0,0.05)'
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
                        $('#loadingPerDesa').fadeOut(300, function() {
                            $('#tablePerDesa').fadeIn(400);
                        });

                        let html = '';
                        data.forEach(function(item) {
                            const persenBPJS = item.total_penduduk > 0 ?
                                ((item.punya_bpjs / item.total_penduduk) * 100).toFixed(2) :
                                0;

                            html += `<tr>
                                <td><strong>${item.desa || 'Tidak Diketahui'}</strong></td>
                                <td class="text-right">${item.total_penduduk.toLocaleString('id-ID')}</td>
                                <td class="text-right">${item.total_kk.toLocaleString('id-ID')}</td>
                                <td class="text-right">${item.laki_laki.toLocaleString('id-ID')}</td>
                                <td class="text-right">${item.perempuan.toLocaleString('id-ID')}</td>
                                <td class="text-right">${item.punya_bpjs.toLocaleString('id-ID')}</td>
                                <td class="text-right"><span class="badge badge-success">${persenBPJS}%</span></td>
                            </tr>`;
                        });
                        $('#tbodyPerDesa').html(html);
                    }
                });
            }
        });
    </script>
@endpush
