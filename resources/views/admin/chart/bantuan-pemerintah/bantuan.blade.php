@extends('admin.layout.main')
@section('title', 'Statistik Bantuan Pemerintah')
@section('content-header', 'Statistik Bantuan Pemerintah')

@section('content')
    <!-- Header Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card-premium elevation-2">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>

                        <div class="ml-3">
                            <h5 class="font-weight-bold mb-1">Ringkasan Statistik Bantuan Pemerintah</h5>
                            <p class="stat-sublabel-premium mb-0">
                                Data diperbarui secara otomatis berdasarkan database terkini
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Section -->
    <div class="row mb-4">
        <div class="col-12 mb-3">
            <h4 class="section-title">
                <i class="fas fa-calculator mr-2"></i> Statistik Jumlah
            </h4>
        </div>

        <!-- Total Penduduk -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-info text-white">
                            <i class="fas fa-users"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="total-penduduk">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Total Penduduk
                                <i class="fas fa-users stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Jumlah Penduduk</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total KK -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-success text-white">
                            <i class="fas fa-home"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="total-kk">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Total KK
                                <i class="fas fa-home stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Kepala Keluarga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Penerima -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-warning text-white">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="total-penerima">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Total Penerima
                                <i class="fas fa-hand-holding-heart stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Penerima Bantuan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layak Belum Terima -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-danger text-white">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="layak-belum-menerima">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Layak Belum Terima
                                <i class="fas fa-exclamation-triangle stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Perlu Perhatian</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anomali -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-danger text-white">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="tidak-layak-menerima">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Anomali
                                <i class="fas fa-exclamation-circle stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Tidak Layak Terima</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lansia Layak -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-user-clock"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="lansia-layak">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Lansia Layak
                                <i class="fas fa-user-clock stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Persentase</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-12 mb-3">
            <h4 class="section-title">
                <i class="fas fa-chart-bar mr-2"></i> Statistik Distribusi
            </h4>
        </div>

        <!-- Status Kelayakan Bantuan -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-success">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Status Kelayakan Bantuan</h3>
                        <p class="card-subtitle-premium">Distribusi kelayakan penerima bantuan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingKelayakan" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="kelayakanChartWrapper">
                        <canvas id="chart-kelayakan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribusi Penerima Bantuan -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Penerima Bantuan</h3>
                        <p class="card-subtitle-premium">Jumlah penerima per jenis bantuan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingBantuan" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="bantuanChartWrapper">
                        <canvas id="chart-bantuan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-info">
                    <div class="card-header-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Kelompok Umur</h3>
                        <p class="card-subtitle-premium">Penerima bantuan berdasarkan kelompok usia</p>
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
                    <div style="position: relative; height: 400px; display: none;" id="umurChartWrapper">
                        <canvas id="chart-umur"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-purple">
                    <div class="card-header-icon">
                        <i class="fas fa-venus-mars"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Penerima Bantuan Berdasarkan Gender</h3>
                        <p class="card-subtitle-premium">Komposisi penerima berdasarkan jenis kelamin</p>
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
                    <div style="position: relative; height: 400px; display: none;" id="genderChartWrapper">
                        <canvas id="chart-gender"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 3 -->
    <div class="row mb-4">
        <div class="col-lg-7 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-warning">
                    <div class="card-header-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Top 10 RT/RW Penerima Bantuan</h3>
                        <p class="card-subtitle-premium">Wilayah dengan penerima bantuan terbanyak</p>
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
                    <div style="position: relative; height: 400px; display: none;" id="rtrwChartWrapper">
                        <canvas id="chart-rtrw"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-teal">
                    <div class="card-header-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Status Kartu Keluarga</h3>
                        <p class="card-subtitle-premium">Distribusi KK penerima bantuan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingKK" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="kkChartWrapper">
                        <canvas id="chart-kk"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Info Cards Row -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-danger">
                    <div class="card-header-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Detail Anomali</h3>
                        <p class="card-subtitle-premium">Tidak layak tapi menerima bantuan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium p-0">
                    <div class="table-info-premium">
                        <table class="table-premium-info table" id="table-anomali">
                            <thead>
                                <tr>
                                    <th>Jenis Bantuan</th>
                                    <th class="text-center" width="100">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <div class="spinner-premium-sm">
                                            <div class="double-bounce1"></div>
                                            <div class="double-bounce2"></div>
                                        </div>
                                        <p class="loading-text-sm">Memuat data...</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-info">
                    <div class="card-header-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Per Kampung</h3>
                        <p class="card-subtitle-premium">Penerima bantuan per wilayah kampung</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium p-0">
                    <div class="table-info-premium" style="max-height: 400px; overflow-y: auto;">
                        <table class="table-premium-info table" id="table-kampung">
                            <thead>
                                <tr>
                                    <th>Kampung</th>
                                    <th class="text-center" width="80">Total</th>
                                    <th class="text-center" width="100">Penerima</th>
                                    <th class="text-center" width="80">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="spinner-premium-sm">
                                            <div class="double-bounce1"></div>
                                            <div class="double-bounce2"></div>
                                        </div>
                                        <p class="loading-text-sm">Memuat data...</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Data Tables -->
    <div class="row">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-dark">
                    <div class="card-header-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Data Detail Penduduk</h3>
                        <p class="card-subtitle-premium">Eksplorasi data berdasarkan kategori kelayakan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium p-0">
                    <!-- Filter Section -->
                    <div class="filter-section-premium">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="filter-label">
                                    <i class="fas fa-filter mr-2"></i>Filter Data
                                </label>
                                <select id="filter-kategori" class="form-control select2-premium">
                                    <option value="semua">📋 Semua Data</option>
                                    <option value="layak">✅ Layak</option>
                                    <option value="tidak_layak">❌ Tidak Layak</option>
                                    <option value="penerima">🎁 Penerima Bantuan</option>
                                    <option value="belum_menerima">⏳ Belum Menerima</option>
                                    <option value="layak_belum_menerima">🚨 Layak Belum Menerima (Kritis)</option>
                                    <option value="anomali">⚠️ Anomali (Tidak Layak Menerima)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="table-container-premium">
                        <div class="table-responsive">
                            <table class="table-premium" id="table-detail">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Kampung</th>
                                        <th>RT/RW</th>
                                        <th>JK</th>
                                        <th>Tgl Lahir</th>
                                        <th>Umur</th>
                                        <th>Kelompok Umur</th>
                                        <th>Status Kelayakan</th>
                                        <th>Bantuan</th>
                                        <th>Status</th>
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
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2-premium').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            let charts = {};
            let dataTable;

            // Color palette
            const colors = {
                primary: '#007bff',
                success: '#28a745',
                danger: '#dc3545',
                warning: '#ffc107',
                info: '#17a2b8',
                secondary: '#6c757d',
                purple: '#6f42c1',
                orange: '#fd7e14',
                teal: '#20c997',
                pink: '#e83e8c'
            };

            // Load statistik data
            function loadStatistik() {
                $.ajax({
                    url: '{{ route('bantuan.pemerintah.statistik') }}',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        updateDashboardHeader(response.ringkasan);
                        createChartKelayakan(response.kelayakan);
                        createChartBantuan(response.distribusi_bantuan);
                        createChartUmur(response.umur);
                        createChartGender(response.gender);
                        createChartRTRW(response.wilayah.rt_rw);
                        createChartKK(response.kk);
                        updateAnomaliTable(response.anomali.detail);
                        updateKampungTable(response.wilayah.kampung);
                    },
                    error: function(xhr) {
                        console.error('Error loading statistik:', xhr);
                    }
                });
            }

            // Update dashboard header
            function updateDashboardHeader(data) {
                $('#total-penduduk').text(data.total_penduduk.toLocaleString('id-ID'));
                $('#total-kk').text(data.total_kk.toLocaleString('id-ID'));
                $('#total-penerima').text(data.total_penerima_bantuan.toLocaleString('id-ID'));
                $('#layak-belum-menerima').text(data.layak_belum_menerima.toLocaleString('id-ID'));
                $('#tidak-layak-menerima').text(data.tidak_layak_menerima.toLocaleString('id-ID'));
                $('#lansia-layak').text(data.lansia_layak_persen + '%');
            }

            // Chart: Kelayakan
            function createChartKelayakan(data) {
                const ctx = document.getElementById('chart-kelayakan').getContext('2d');
                if (charts.kelayakan) charts.kelayakan.destroy();

                $('#loadingKelayakan').fadeOut(300, function() {
                    $('#kelayakanChartWrapper').fadeIn(400);

                    charts.kelayakan = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Layak', 'Tidak Layak'],
                            datasets: [{
                                data: [data.layak, data.tidak_layak],
                                backgroundColor: [colors.success, colors.warning],
                                borderWidth: 4,
                                borderColor: '#fff',
                                hoverBorderWidth: 6,
                                hoverOffset: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
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
                                            const persen = context.dataIndex === 0 ? data
                                                .persen_layak :
                                                data.persen_tidak_layak;
                                            return label + ': ' + value.toLocaleString(
                                                'id-ID') + ' (' + persen + '%)';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            }

            // Chart: Distribusi Bantuan
            function createChartBantuan(data) {
                const ctx = document.getElementById('chart-bantuan').getContext('2d');
                if (charts.bantuan) charts.bantuan.destroy();

                const labels = Object.keys(data);
                const values = Object.values(data);
                const backgroundColors = [
                    colors.primary, colors.success, colors.danger,
                    colors.warning, colors.info, colors.purple, colors.secondary
                ];

                $('#loadingBantuan').fadeOut(300, function() {
                    $('#bantuanChartWrapper').fadeIn(400);

                    charts.bantuan = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Penerima',
                                data: values,
                                backgroundColor: backgroundColors.slice(0, labels.length),
                                borderWidth: 2,
                                borderRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.03)'
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        precision: 0,
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
                                            size: 11,
                                            weight: 'bold'
                                        }
                                    }
                                }
                            },
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
                                            return 'Jumlah: ' + context.parsed.y.toLocaleString(
                                                'id-ID') + ' orang';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            }

            // Chart: Kelompok Umur
            function createChartUmur(data) {
                const ctx = document.getElementById('chart-umur').getContext('2d');
                if (charts.umur) charts.umur.destroy();

                const urutan = [
                    'Balita (0-5)',
                    'Anak (6-12)',
                    'Remaja (13-17)',
                    'Produktif Muda (18-35)',
                    'Produktif (36-59)',
                    'Lansia (≥60)'
                ];

                const labels = [];
                const total = [];
                const penerima = [];

                urutan.forEach(kel => {
                    if (data.distribusi[kel]) {
                        labels.push(kel);
                        total.push(data.distribusi[kel]);
                        penerima.push(data.penerima_bantuan[kel] || 0);
                    }
                });

                $('#loadingUmur').fadeOut(300, function() {
                    $('#umurChartWrapper').fadeIn(400);

                    charts.umur = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Penduduk',
                                data: total,
                                backgroundColor: colors.info,
                                borderWidth: 2,
                                borderRadius: 8
                            }, {
                                label: 'Penerima Bantuan',
                                data: penerima,
                                backgroundColor: colors.success,
                                borderWidth: 2,
                                borderRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.03)'
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        precision: 0,
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
                                            size: 11,
                                            weight: 'bold'
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        font: {
                                            size: 13,
                                            weight: '600'
                                        },
                                        usePointStyle: true,
                                        pointStyle: 'circle',
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
                                            return context.dataset.label + ': ' + context.parsed
                                                .y
                                                .toLocaleString('id-ID') + ' orang';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            }

            // Chart: Gender
            function createChartGender(data) {
                const ctx = document.getElementById('chart-gender').getContext('2d');
                if (charts.gender) charts.gender.destroy();

                $('#loadingGender').fadeOut(300, function() {
                    $('#genderChartWrapper').fadeIn(400);

                    charts.gender = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Laki-laki', 'Perempuan'],
                            datasets: [{
                                label: 'Total',
                                data: [data.laki_laki, data.perempuan],
                                backgroundColor: colors.primary,
                                borderWidth: 2,
                                borderRadius: 8
                            }, {
                                label: 'Penerima Bantuan',
                                data: [data.laki_laki_bantuan, data.perempuan_bantuan],
                                backgroundColor: colors.success,
                                borderWidth: 2,
                                borderRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.03)'
                                    },
                                    ticks: {
                                        precision: 0,
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
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        font: {
                                            size: 13,
                                            weight: '600'
                                        },
                                        usePointStyle: true,
                                        pointStyle: 'circle',
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
                                            return context.dataset.label + ': ' + context.parsed
                                                .y
                                                .toLocaleString('id-ID') + ' orang';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            }

            // Chart: RT/RW
            function createChartRTRW(data) {
                const ctx = document.getElementById('chart-rtrw').getContext('2d');
                if (charts.rtrw) charts.rtrw.destroy();

                const labels = Object.keys(data);
                const values = Object.values(data).map(item => item.penerima);

                $('#loadingRTRW').fadeOut(300, function() {
                    $('#rtrwChartWrapper').fadeIn(400);

                    charts.rtrw = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Penerima Bantuan',
                                data: values,
                                backgroundColor: colors.warning,
                                borderWidth: 2,
                                borderRadius: 8
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.03)'
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        precision: 0,
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
                                            size: 11,
                                            weight: 'bold'
                                        }
                                    }
                                }
                            },
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
                                            return 'Penerima: ' + context.parsed.x
                                                .toLocaleString('id-ID') + ' orang';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            }

            // Chart: KK
            function createChartKK(data) {
                const ctx = document.getElementById('chart-kk').getContext('2d');
                if (charts.kk) charts.kk.destroy();

                $('#loadingKK').fadeOut(300, function() {
                    $('#kkChartWrapper').fadeIn(400);

                    charts.kk = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['KK Penerima', 'KK Belum Menerima', 'Multi Penerima (1 KK)'],
                            datasets: [{
                                data: [data.kk_penerima, data.kk_belum_menerima, data
                                    .multi_penerima
                                ],
                                backgroundColor: [colors.success, colors.secondary, colors
                                    .danger
                                ],
                                borderWidth: 4,
                                borderColor: '#fff',
                                hoverBorderWidth: 6,
                                hoverOffset: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
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
                                            const total = context.dataset.data.reduce((a, b) =>
                                                a + b, 0);
                                            const percentage = ((value / total) * 100).toFixed(
                                                1);
                                            return label + ': ' + value.toLocaleString(
                                                    'id-ID') + ' (' +
                                                percentage + '%)';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            }

            // Update Anomali Table
            function updateAnomaliTable(data) {
                let html = '';
                if (Object.keys(data).length === 0) {
                    html = '<tr><td colspan="2" class="text-center">Tidak ada data anomali</td></tr>';
                } else {
                    $.each(data, function(bantuan, jumlah) {
                        html += '<tr>';
                        html += '<td>' + bantuan + '</td>';
                        html += '<td class="text-center"><span class="badge badge-danger badge-lg">' +
                            jumlah + '</span></td>';
                        html += '</tr>';
                    });
                }
                $('#table-anomali tbody').html(html);
            }

            // Update Kampung Table
            function updateKampungTable(data) {
                let html = '';
                if (Object.keys(data).length === 0) {
                    html = '<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>';
                } else {
                    $.each(data, function(kampung, item) {
                        html += '<tr>';
                        html += '<td>' + kampung + '</td>';
                        html += '<td class="text-center">' + item.total + '</td>';
                        html += '<td class="text-center"><span class="badge badge-success">' + item
                            .penerima + '</span></td>';
                        html += '<td class="text-center"><strong>' + item.persen + '%</strong></td>';
                        html += '</tr>';
                    });
                }
                $('#table-kampung tbody').html(html);
            }

            // Initialize DataTable
            function initDataTable(kategori = 'semua') {
                if (dataTable) {
                    dataTable.destroy();
                }

                dataTable = $('#table-detail').DataTable({
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
                        [10, 25, 50, 100, "Semua"]
                    ],
                    language: {
                        processing: '<div class="spinner-premium"><div class="double-bounce1"></div><div class="double-bounce2"></div></div><p class="loading-text">Memproses data...</p>',
                        lengthMenu: 'Tampilkan _MENU_ data per halaman',
                        zeroRecords: 'Data tidak ditemukan',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                        infoEmpty: 'Tidak ada data tersedia',
                        infoFiltered: '(disaring dari _MAX_ total data)',
                        search: 'Pencarian:',
                        paginate: {
                            first: '<i class="fas fa-angle-double-left"></i>',
                            last: '<i class="fas fa-angle-double-right"></i>',
                            next: '<i class="fas fa-angle-right"></i>',
                            previous: '<i class="fas fa-angle-left"></i>'
                        }
                    },
                    destroy: true,
                    ajax: {
                        url: '{{ route('bantuan.pemerintah.datatables') }}',
                        data: function(d) {
                            d.kategori = kategori;
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'no_nik',
                            name: 'no_nik',
                            className: 'text-center'
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            className: 'text-left'
                        },
                        {
                            data: 'kp',
                            name: 'kp',
                            className: 'text-left'
                        },
                        {
                            data: 'rt_rw',
                            name: 'rt_rw',
                            className: 'text-center'
                        },
                        {
                            data: 'jenkel_text',
                            name: 'jenkel_text',
                            className: 'text-center'
                        },
                        {
                            data: 'tgl_lahir',
                            name: 'tgl_lahir',
                            className: 'text-center'
                        },
                        {
                            data: 'umur',
                            name: 'umur',
                            className: 'text-center'
                        },
                        {
                            data: 'kelompok_umur',
                            name: 'kelompok_umur',
                            className: 'text-left'
                        },
                        {
                            data: 'status_kelayakan',
                            name: 'status_kelayakan',
                            orderable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'nama_bantuan',
                            name: 'nama_bantuan',
                            defaultContent: '-',
                            className: 'text-center'
                        },
                        {
                            data: 'status_bantuan',
                            name: 'status_bantuan',
                            orderable: false,
                            className: 'text-center'
                        }
                    ],
                });
            }

            // Filter kategori change
            $('#filter-kategori').on('change', function() {
                const kategori = $(this).val();
                initDataTable(kategori);
            });

            // Initialize
            loadStatistik();
            initDataTable();
        });
    </script>
@endpush
