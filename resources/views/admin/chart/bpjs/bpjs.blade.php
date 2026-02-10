@extends('admin.layout.main')
@section('title', 'Statistik BPJS')
@section('content-header', 'Statistik BPJS')

@section('content')

    <!-- Premium Info Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
            <div class="info-box-premium bg-gradient-primary elevation-3">
                <div class="info-box-premium-icon">
                    <div class="icon-circle bg-white">
                        <i class="fas fa-users text-primary"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Total Penduduk</span>
                    <span class="info-box-premium-number" id="total_penduduk">
                        <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                    </span>

                    <span class="info-box-premium-percentage" id="">Penduduk</span>
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
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Punya BPJS</span>
                    <span class="info-box-premium-number" id="punya_bpjs">
                        <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                    </span>
                    <span class="info-box-premium-percentage" id="persentase_punya"></span>
                    <div class="progress-premium">
                        <div class="progress-bar bg-white"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
            <div class="info-box-premium bg-gradient-danger elevation-3">
                <div class="info-box-premium-icon">
                    <div class="icon-circle bg-white">
                        <i class="fas fa-times-circle text-danger"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Tidak Punya BPJS</span>
                    <span class="info-box-premium-number" id="tidak_punya_bpjs">
                        <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                    </span>
                    <span class="info-box-premium-percentage" id="persentase_tidak_punya"></span>
                    <div class="progress-premium">
                        <div class="progress-bar bg-white"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="info-box-premium bg-gradient-warning elevation-3">
                <div class="info-box-premium-icon">
                    <div class="icon-circle bg-white">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Data Anomali</span>
                    <span class="info-box-premium-number" id="total_anomali">
                        <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                    </span>
                    <span class="info-box-premium-percentage">Data tidak valid</span>
                    <div class="progress-premium">
                        <div class="progress-bar bg-white"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 - Premium Design -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-success">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Kepemilikan BPJS</h3>
                        <p class="card-subtitle-premium">Proporsi kepemilikan BPJS penduduk</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingChartKepemilikan" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartKepemilikan" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Jenis BPJS</h3>
                        <p class="card-subtitle-premium">Distribusi berdasarkan jenis BPJS</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingChartJenis" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartJenisBpjs" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 - Premium Design -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-info">
                    <div class="card-header-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Sumber Pembayaran BPJS</h3>
                        <p class="card-subtitle-premium">Klasifikasi metode pembayaran</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingChartPembayaran" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartPembayaran" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-secondary">
                    <div class="card-header-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Status BPJS per Kartu Keluarga</h3>
                        <p class="card-subtitle-premium">Kepemilikan BPJS dalam keluarga</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingChartKK" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartKK" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Kombinasi - Premium Design -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-dark">
                    <div class="card-header-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Kombinasi Jenis BPJS × Sumber Pembayaran</h3>
                        <p class="card-subtitle-premium">Analisis korelasi jenis dan metode pembayaran</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingChartKombinasi" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartKombinasi" style="display:none; max-height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Anomali - Premium Design -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-warning">
                    <div class="card-header-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Validasi & Anomali Data</h3>
                        <p class="card-subtitle-premium">Deteksi ketidaksesuaian data BPJS</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium p-0">
                    <div class="table-container-premium-compact">
                        <table class="table-premium-compact">
                            <thead>
                                <tr>
                                    <th width="60%">Jenis Anomali</th>
                                    <th width="20%" class="text-center">Jumlah</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="anomaliTable">
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <div class="spinner-premium">
                                            <div class="double-bounce1"></div>
                                            <div class="double-bounce2"></div>
                                        </div>
                                        <p class="loading-text">Memuat data...</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Data Tables - Premium Design -->
    <div class="row">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-dark">
                    <div class="card-header-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Detail Data Penduduk</h3>
                        <p class="card-subtitle-premium">Eksplorasi data berdasarkan filter kategori</p>
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
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <label class="filter-label-premium">
                                    <i class="fas fa-filter mr-2"></i>Filter Data
                                </label>
                                <select class="form-control select2-premium" id="filterData">
                                    <option value="">Semua Data</option>
                                    <optgroup label="Status Kepemilikan">
                                        <option value="punya_bpjs">Punya BPJS</option>
                                        <option value="tidak_punya_bpjs">Tidak Punya BPJS</option>
                                    </optgroup>
                                    <optgroup label="Jenis BPJS" id="filterJenis">
                                        <!-- Akan diisi dinamis -->
                                    </optgroup>
                                    <optgroup label="Sumber Pembayaran" id="filterPembayaran">
                                        <!-- Akan diisi dinamis -->
                                    </optgroup>
                                    <optgroup label="Data Anomali">
                                        <option value="anomali_punya_null_jenis">Punya BPJS tapi Jenis Kosong</option>
                                        <option value="anomali_tidak_punya_ada_jenis">Tidak Punya tapi Ada Jenis</option>
                                        <option value="anomali_ada_jenis_null_pembayaran">Ada Jenis tapi Pembayaran Kosong
                                        </option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-4 text-right">
                                <button class="btn btn-export-premium elevation-2" id="exportExcel">
                                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="table-container-premium">
                        <table class="table-premium" id="tableDetail">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>No. KK</th>
                                    <th>JK</th>
                                    <th>Umur</th>
                                    <th>Alamat</th>
                                    <th>RT/RW</th>
                                    <th>Status BPJS</th>
                                    <th>Jenis BPJS</th>
                                    <th>Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
        let charts = {};
        let dataTable;

        $(document).ready(function() {
            // Initialize Select2
            $('#filterData').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Pilih Filter Data'
            });

            loadStatistik();
            initDataTable();
        });

        function loadStatistik() {
            $.ajax({
                url: '{{ route('bpjs.statistik') }}',
                method: 'GET',
                success: function(data) {
                    updateCards(data.kepemilikan, data.anomali);
                    updateAnomaliTable(data.anomali);
                    createChartKepemilikan(data.kepemilikan);
                    createChartJenisBpjs(data.jenis_bpjs);
                    createChartPembayaran(data.pembayaran);
                    createChartKK(data.kepemilikan_kk);
                    createChartKombinasi(data.kombinasi);
                    populateFilters(data.jenis_bpjs, data.pembayaran);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat statistik',
                        confirmButtonColor: '#667eea'
                    });
                }
            });
        }

        function updateCards(kepemilikan, anomali) {
            $('#total_penduduk').text(kepemilikan.total_penduduk.toLocaleString('id-ID'));
            $('#punya_bpjs').text(kepemilikan.punya_bpjs.toLocaleString('id-ID'));
            $('#persentase_punya').text(kepemilikan.persentase_punya + '%');
            $('#tidak_punya_bpjs').text(kepemilikan.tidak_punya_bpjs.toLocaleString('id-ID'));

            let persentaseTidak = (100 - kepemilikan.persentase_punya).toFixed(2);
            $('#persentase_tidak_punya').text(persentaseTidak + '%');

            let totalAnomali = anomali.punya_tapi_null_jenis +
                anomali.tidak_punya_tapi_ada_jenis +
                anomali.ada_jenis_null_pembayaran;
            $('#total_anomali').text(totalAnomali.toLocaleString('id-ID'));
        }

        function updateAnomaliTable(anomali) {
            let html = '';

            const anomaliData = [{
                    condition: anomali.punya_tapi_null_jenis > 0,
                    text: 'Punya BPJS tapi Jenis BPJS Kosong',
                    count: anomali.punya_tapi_null_jenis,
                    filter: 'anomali_punya_null_jenis',
                    badgeClass: 'badge-warning-premium'
                },
                {
                    condition: anomali.tidak_punya_tapi_ada_jenis > 0,
                    text: 'Tidak Punya BPJS tapi Ada Jenis BPJS',
                    count: anomali.tidak_punya_tapi_ada_jenis,
                    filter: 'anomali_tidak_punya_ada_jenis',
                    badgeClass: 'badge-danger-premium'
                },
                {
                    condition: anomali.ada_jenis_null_pembayaran > 0,
                    text: 'Ada Jenis BPJS tapi Pembayaran Kosong',
                    count: anomali.ada_jenis_null_pembayaran,
                    filter: 'anomali_ada_jenis_null_pembayaran',
                    badgeClass: 'badge-warning-premium'
                }
            ];

            anomaliData.forEach(item => {
                if (item.condition) {
                    html += `
                        <tr>
                            <td>
                                <i class="fas fa-exclamation-triangle text-warning mr-2"></i>
                                <strong>${item.text}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge-status-premium ${item.badgeClass}">${item.count.toLocaleString('id-ID')}</span>
                            </td>
                            <td class="text-center">
                                <button class="btn-anomaly-view" onclick="viewDetail('${item.filter}')">
                                    <i class="fas fa-eye mr-1"></i> Lihat Detail
                                </button>
                            </td>
                        </tr>`;
                }
            });

            if (html === '') {
                html = `
                    <tr>
                        <td colspan="3" class="text-center" style="padding: 30px;">
                            <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                            <p class="mt-3 mb-0 font-weight-bold text-success">Tidak ada anomali data</p>
                            <p class="text-muted">Semua data BPJS valid dan konsisten</p>
                        </td>
                    </tr>`;
            }

            $('#anomaliTable').html(html);
        }

        function createChartKepemilikan(data) {
            const ctx = document.getElementById('chartKepemilikan').getContext('2d');
            if (charts.kepemilikan) charts.kepemilikan.destroy();

            $('#loadingChartKepemilikan').fadeOut(300, function() {
                $('#chartKepemilikan').fadeIn(400);

                charts.kepemilikan = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Punya BPJS', 'Tidak Punya BPJS'],
                        datasets: [{
                            data: [data.punya_bpjs, data.tidak_punya_bpjs],
                            backgroundColor: [
                                'rgba(40, 167, 69, 0.8)',
                                'rgba(220, 53, 69, 0.8)'
                            ],
                            borderColor: ['#28a745', '#dc3545'],
                            borderWidth: 3,
                            hoverOffset: 15
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
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
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        let value = context.parsed || 0;
                                        let total = data.total_penduduk;
                                        let pct = ((value / total) * 100).toFixed(2);
                                        return label + ': ' + value.toLocaleString('id-ID') + ' (' +
                                            pct + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            });
        }

        function createChartJenisBpjs(data) {
            const ctx = document.getElementById('chartJenisBpjs').getContext('2d');
            if (charts.jenis) charts.jenis.destroy();

            const labels = data.map(item => formatLabel(item.jenis_bpjs));
            const values = data.map(item => item.jumlah);

            $('#loadingChartJenis').fadeOut(300, function() {
                $('#chartJenisBpjs').fadeIn(400);

                charts.jenis = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Penduduk',
                            data: values,
                            backgroundColor: 'rgba(0, 123, 255, 0.8)',
                            borderColor: '#007bff',
                            borderWidth: 2,
                            borderRadius: 8
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
                                ticks: {
                                    precision: 0,
                                    font: {
                                        size: 12
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.03)'
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 11,
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            });
        }

        function createChartPembayaran(data) {
            const ctx = document.getElementById('chartPembayaran').getContext('2d');
            if (charts.pembayaran) charts.pembayaran.destroy();

            const labels = data.map(item => formatLabel(item.pembayaran_bpjs));
            const values = data.map(item => item.jumlah);
            const colors = [
                'rgba(23, 162, 184, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(40, 167, 69, 0.8)',
                'rgba(111, 66, 193, 0.8)'
            ];

            $('#loadingChartPembayaran').fadeOut(300, function() {
                $('#chartPembayaran').fadeIn(400);

                charts.pembayaran = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: colors,
                            borderWidth: 3,
                            borderColor: '#fff',
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
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    },
                                    usePointStyle: true,
                                    padding: 15
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
            });
        }

        function createChartKK(data) {
            const ctx = document.getElementById('chartKK').getContext('2d');
            if (charts.kk) charts.kk.destroy();

            $('#loadingChartKK').fadeOut(300, function() {
                $('#chartKK').fadeIn(400);

                charts.kk = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Semua Punya BPJS', 'Sebagian Punya', 'Tidak Ada yang Punya'],
                        datasets: [{
                            label: 'Jumlah KK',
                            data: [data.kk_semua_punya, data.kk_sebagian_punya, data.kk_tidak_ada],
                            backgroundColor: [
                                'rgba(40, 167, 69, 0.8)',
                                'rgba(255, 193, 7, 0.8)',
                                'rgba(220, 53, 69, 0.8)'
                            ],
                            borderColor: ['#28a745', '#ffc107', '#dc3545'],
                            borderWidth: 2,
                            borderRadius: 8
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
                                ticks: {
                                    precision: 0,
                                    font: {
                                        size: 12
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.03)'
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 11,
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            });
        }

        function createChartKombinasi(data) {
            const ctx = document.getElementById('chartKombinasi').getContext('2d');
            if (charts.kombinasi) charts.kombinasi.destroy();

            // Group by jenis_bpjs
            const grouped = {};
            data.forEach(item => {
                if (!grouped[item.jenis_bpjs]) {
                    grouped[item.jenis_bpjs] = {};
                }
                grouped[item.jenis_bpjs][item.pembayaran_bpjs] = item.jumlah;
            });

            const allPembayaran = [...new Set(data.map(item => item.pembayaran_bpjs))];
            const colors = [
                'rgba(23, 162, 184, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(40, 167, 69, 0.8)',
                'rgba(111, 66, 193, 0.8)'
            ];

            const datasets = allPembayaran.map((pembayaran, idx) => ({
                label: formatLabel(pembayaran),
                data: Object.keys(grouped).map(jenis => grouped[jenis][pembayaran] || 0),
                backgroundColor: colors[idx % colors.length],
                borderWidth: 2,
                borderRadius: 6
            }));

            $('#loadingChartKombinasi').fadeOut(300, function() {
                $('#chartKombinasi').fadeIn(400);

                charts.kombinasi = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(grouped).map(jenis => formatLabel(jenis)),
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 13,
                                        weight: '600'
                                    },
                                    usePointStyle: true,
                                    padding: 15
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 15,
                                cornerRadius: 8
                            }
                        },
                        scales: {
                            x: {
                                stacked: true,
                                ticks: {
                                    font: {
                                        size: 11,
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    font: {
                                        size: 12
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.03)'
                                }
                            }
                        }
                    }
                });
            });
        }

        function formatLabel(text) {
            if (!text) return '-';
            return text.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        }

        function populateFilters(jenisBpjs, pembayaran) {
            let jenisHtml = '';
            jenisBpjs.forEach(item => {
                jenisHtml += `<option value="jenis_${item.jenis_bpjs}">${formatLabel(item.jenis_bpjs)}</option>`;
            });
            $('#filterJenis').html(jenisHtml);

            let pembayaranHtml = '';
            pembayaran.forEach(item => {
                pembayaranHtml +=
                    `<option value="pembayaran_${item.pembayaran_bpjs}">${formatLabel(item.pembayaran_bpjs)}</option>`;
            });
            $('#filterPembayaran').html(pembayaranHtml);
        }

        function initDataTable() {
            dataTable = $('#tableDetail').DataTable({
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
                ajax: {
                    url: '{{ route('bpjs.detail') }}',
                    data: function(d) {
                        d.filter = $('#filterData').val();
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
                        className: 'text-center'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'no_kk',
                        className: 'text-center'
                    },
                    {
                        data: 'jenkel',
                        className: 'text-center',
                        render: data => data == 1 ?
                            '<span class="badge-status-premium badge-primary-premium">L</span>' :
                            '<span class="badge-status-premium badge-danger-premium">P</span>'
                    },
                    {
                        data: 'umur',
                        className: 'text-center'
                    },
                    {
                        data: 'kp'
                    },
                    {
                        data: 'rt_rw',
                        className: 'text-center'
                    },
                    {
                        data: 'punya_bpjs',
                        className: 'text-center',
                        render: data => data === 'ya' ?
                            '<span class="badge-status-premium badge-success-premium">Punya</span>' :
                            '<span class="badge-status-premium badge-danger-premium">Tidak</span>'
                    },
                    {
                        data: 'jenis_bpjs',
                        className: 'text-center',
                        render: data => data ?
                            `<span class="badge-status-premium badge-info-premium">${formatLabel(data)}</span>` :
                            '<span class="text-muted">-</span>'
                    },
                    {
                        data: 'pembayaran_bpjs',
                        className: 'text-center',
                        render: data => data ?
                            `<span class="badge-status-premium badge-secondary-premium">${formatLabel(data)}</span>` :
                            '<span class="text-muted">-</span>'
                    }
                ]
            });

            $('#filterData').on('change', function() {
                dataTable.ajax.reload();
            });
        }

        function viewDetail(filter) {
            $('#filterData').val(filter).trigger('change');
            $('html, body').animate({
                scrollTop: $('#tableDetail').offset().top - 100
            }, 500);
        }

        // Export Excel Function
        $('#exportExcel').on('click', function() {
            if (!dataTable) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Data belum dimuat',
                    confirmButtonColor: '#667eea'
                });
                return;
            }

            const data = dataTable.rows({
                search: 'applied'
            }).data();

            if (data.length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Informasi',
                    text: 'Tidak ada data untuk di-export',
                    confirmButtonColor: '#667eea'
                });
                return;
            }

            let csv = 'No,NIK,Nama,No KK,Jenis Kelamin,Umur,Alamat,RT/RW,Status BPJS,Jenis BPJS,Pembayaran\n';
            data.each(function(row, index) {
                const jenkel = row.jenkel == 1 ? 'Laki-laki' : 'Perempuan';
                const status = row.punya_bpjs === 'ya' ? 'Punya' : 'Tidak Punya';
                csv +=
                    `"${index + 1}","${row.no_nik}","${row.nama}","${row.no_kk}","${jenkel}","${row.umur}","${row.kp}","${row.rt_rw}","${status}","${formatLabel(row.jenis_bpjs)}","${formatLabel(row.pembayaran_bpjs)}"\n`;
            });

            const blob = new Blob([csv], {
                type: 'text/csv;charset=utf-8;'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            const filter = $('#filterData option:selected').text();

            a.href = url;
            a.download = `Data_BPJS_${filter}_${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil di-export',
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>
@endpush
