@extends('admin.layout.main')
@section('title', 'Statistik Pendapatan')
@section('content-header', 'Statistik Pendapatan')

@section('content')
    <!-- Header Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card-premium elevation-2">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-success text-white">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>

                        <div class="ml-3">
                            <h5 class="font-weight-bold mb-1">Ringkasan Statistik Pendapatan</h5>
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
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
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

        <!-- Rata-rata Anggota/KK -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-warning text-white">
                            <i class="fas fa-chart-pie"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="rata-anggota">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Rata-rata Anggota/KK
                                <i class="fas fa-chart-pie stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Per Keluarga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lansia Rentan -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-danger text-white">
                            <i class="fas fa-user-shield"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="lansia-rentan-count">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Lansia Rentan
                                <i class="fas fa-user-shield stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Perlu Perhatian</p>
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

        <!-- Chart Distribusi Pendapatan -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-success">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Pendapatan</h3>
                        <p class="card-subtitle-premium">Klasifikasi tingkat pendapatan penduduk</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-distribusi" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartDistribusiPendapatan" style="display:none; max-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart Jenis Kelamin -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-venus-mars"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Jenis Kelamin</h3>
                        <p class="card-subtitle-premium">Komposisi gender populasi</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-jenkel" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartJenisKelamin" style="display:none; max-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart Pendapatan Berdasarkan Kelompok Umur -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-info">
                    <div class="card-header-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Pendapatan Berdasarkan Kelompok Umur</h3>
                        <p class="card-subtitle-premium">Analisis pendapatan per kelompok usia</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-umur" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartPendapatanUmur" style="display:none; max-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart Pendapatan Berdasarkan Jenis Kelamin -->
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-secondary">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Pendapatan Berdasarkan Jenis Kelamin</h3>
                        <p class="card-subtitle-premium">Perbandingan pendapatan gender</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-jenkel-pendapatan" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartPendapatanJenkel" style="display:none; max-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart Top 10 RT - Full Width -->
        <div class="col-12 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-danger">
                    <div class="card-header-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Top 10 RT dengan Pendapatan Rendah Tertinggi</h3>
                        <p class="card-subtitle-premium">Wilayah dengan konsentrasi pendapatan rendah</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-rt" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartPendapatanRT" style="display:none; max-height: 350px;"></canvas>
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
                        <h3 class="card-title-premium">Data Detail & Analisis Mendalam</h3>
                        <p class="card-subtitle-premium">Eksplorasi data dengan filter multi-kategori</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium p-0">
                    <!-- Main Category Pills -->
                    <div class="pills-container-premium">
                        <ul class="nav nav-pills-premium" id="categoryTab" role="tablist">
                            <li class="nav-item-premium">
                                <a class="nav-link-premium active" id="semua-tab" data-toggle="pill"
                                    href="#semua-penduduk">
                                    <div class="pill-icon"><i class="fas fa-users"></i></div>
                                    <div class="pill-text">
                                        <span class="pill-title">Semua Penduduk</span>
                                        <span class="pill-subtitle">Data lengkap</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item-premium">
                                <a class="nav-link-premium" id="lansia-tab" data-toggle="pill"
                                    href="#tab-lansia-rentan">
                                    <div class="pill-icon"><i class="fas fa-user-shield"></i></div>
                                    <div class="pill-text">
                                        <span class="pill-title">Lansia Rentan</span>
                                        <span class="pill-subtitle">Perlu perhatian</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content-premium" id="categoryTabContent">
                        <!-- Tab Semua Penduduk -->
                        <div class="tab-pane fade show active" id="semua-penduduk" role="tabpanel">
                            <!-- Filter Section -->
                            <div class="filter-section-premium">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="filter-label-premium">
                                            <i class="fas fa-money-bill-wave mr-2"></i>Filter Pendapatan
                                        </label>
                                        <select class="form-control select2-premium" id="filter-pendapatan">
                                            <option value="">Semua Pendapatan</option>
                                            <option value="0-1 Juta">0-1 Juta</option>
                                            <option value="1-2 Juta">1-2 Juta</option>
                                            <option value="2-3 Juta">2-3 Juta</option>
                                            <option value="3-5 Juta">3-5 Juta</option>
                                            <option value=">5 Juta">>5 Juta</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="filter-label-premium">
                                            <i class="fas fa-birthday-cake mr-2"></i>Filter Kelompok Umur
                                        </label>
                                        <select class="form-control select2-premium" id="filter-kelompok-umur">
                                            <option value="">Semua Umur</option>
                                            <option value="<25">&lt;25 tahun</option>
                                            <option value="26-40">26-40 tahun</option>
                                            <option value="41-60">41-60 tahun</option>
                                            <option value=">60">&gt;60 tahun</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="filter-label-premium">
                                            <i class="fas fa-map-marker-alt mr-2"></i>Filter RT/RW
                                        </label>
                                        <select class="form-control select2-premium" id="filter-rt-rw">
                                            <option value="">Semua RT/RW</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end mb-3">
                                        <button type="button" class="btn btn-reset-premium btn-block elevation-2"
                                            id="reset-filter">
                                            <i class="fas fa-sync-alt mr-2"></i>Reset Filter
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Table Section -->
                            <div class="table-container-premium">
                                <div class="table-responsive">
                                    <table class="table-premium" id="table-penduduk">
                                        <thead>
                                            <tr>
                                                <th width="5%">NO</th>
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
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Lansia Rentan -->
                        <div class="tab-pane fade" id="tab-lansia-rentan" role="tabpanel">
                            <div class="alert-premium alert-warning-premium">
                                <div class="alert-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="alert-content">
                                    <h5 class="alert-title">Perhatian Khusus</h5>
                                    <p class="alert-text">Data berikut menampilkan lansia dengan pendapatan rendah yang
                                        memerlukan perhatian khusus.</p>
                                </div>
                            </div>

                            <!-- Filter Section -->
                            <div class="filter-section-premium">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="filter-label-premium">
                                            <i class="fas fa-money-bill-wave mr-2"></i>Filter Pendapatan
                                        </label>
                                        <select class="form-control select2-premium" id="filter-lansia-pendapatan">
                                            <option value="">Semua Pendapatan</option>
                                            <option value="0-1 Juta">0-1 Juta</option>
                                            <option value="1-2 Juta">1-2 Juta</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="filter-label-premium">
                                            <i class="fas fa-map-marker-alt mr-2"></i>Filter RT/RW
                                        </label>
                                        <select class="form-control select2-premium" id="filter-lansia-rt-rw">
                                            <option value="">Semua RT/RW</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end mb-3">
                                        <button type="button" class="btn btn-reset-premium btn-block elevation-2"
                                            id="reset-filter-lansia">
                                            <i class="fas fa-sync-alt mr-2"></i>Reset Filter
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Table Section -->
                            <div class="table-container-premium">
                                <div class="table-responsive">
                                    <table class="table-premium" id="table-lansia">
                                        <thead>
                                            <tr>
                                                <th width="5%">NO</th>
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
                                        <tbody></tbody>
                                    </table>
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
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2-premium').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            // ==================== LOAD STATISTIK DASAR ====================
            $.ajax({
                url: '{{ route('pendapatan.statistik.dasar') }}',
                method: 'GET',
                success: function(data) {
                    $('#total-penduduk').text(data.total_penduduk.toLocaleString('id-ID'));
                    $('#total-kk').text(data.total_kk.toLocaleString('id-ID'));
                    $('#rata-anggota').text(data.rata_anggota_per_kk);

                    // Chart Jenis Kelamin
                    $('#loading-jenkel').fadeOut(300, function() {
                        $('#chartJenisKelamin').fadeIn(400);

                        new Chart($('#chartJenisKelamin'), {
                            type: 'doughnut',
                            data: {
                                labels: Object.keys(data.jenis_kelamin),
                                datasets: [{
                                    data: Object.values(data.jenis_kelamin),
                                    backgroundColor: [
                                        'rgba(55, 136, 216, 0.8)',
                                        'rgba(232, 62, 140, 0.8)'
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
                                            font: {
                                                size: 13,
                                                weight: '600'
                                            },
                                            usePointStyle: true,
                                            padding: 20,
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

                    $('#loading-distribusi').fadeOut(300, function() {
                        $('#chartDistribusiPendapatan').fadeIn(400);

                        new Chart($('#chartDistribusiPendapatan'), {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Jumlah Penduduk',
                                    data: values,
                                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                                    borderColor: '#28a745',
                                    borderWidth: 2,
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
                                        cornerRadius: 8
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
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
                                                size: 12,
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
                    const colors = [
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(23, 162, 184, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(111, 66, 193, 0.8)'
                    ];

                    const datasets = pendapatanKategori.map((kategori, idx) => ({
                        label: kategori,
                        data: kelompokUmur.map(umur => data[umur][kategori] || 0),
                        backgroundColor: colors[idx],
                        borderWidth: 2,
                        borderRadius: 10
                    }));

                    $('#loading-umur').fadeOut(300, function() {
                        $('#chartPendapatanUmur').fadeIn(400);

                        new Chart($('#chartPendapatanUmur'), {
                            type: 'bar',
                            data: {
                                labels: kelompokUmur,
                                datasets: datasets
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
                                            padding: 20,
                                            pointStyle: 'circle'
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
                                                size: 12,
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
                            backgroundColor: 'rgba(55, 136, 216, 0.8)',
                            borderColor: '#3788d8',
                            borderWidth: 2,
                            borderRadius: 10
                        },
                        {
                            label: 'Perempuan',
                            data: pendapatanKategori.map(k => data['Perempuan'][k] || 0),
                            backgroundColor: 'rgba(232, 62, 140, 0.8)',
                            borderColor: '#e83e8c',
                            borderWidth: 2,
                            borderRadius: 10
                        }
                    ];

                    $('#loading-jenkel-pendapatan').fadeOut(300, function() {
                        $('#chartPendapatanJenkel').fadeIn(400);

                        new Chart($('#chartPendapatanJenkel'), {
                            type: 'bar',
                            data: {
                                labels: pendapatanKategori,
                                datasets: datasets
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
                                            padding: 20,
                                            pointStyle: 'circle'
                                        }
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
                                                size: 12,
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
            });

            // ==================== TOP 10 RT TERMISKIN ====================
            $.ajax({
                url: '{{ route('pendapatan.pendapatan.per.rt') }}',
                method: 'GET',
                success: function(data) {
                    const labels = Object.keys(data);
                    const values = labels.map(k => data[k].persentase_rendah);

                    $('#loading-rt').fadeOut(300, function() {
                        $('#chartPendapatanRT').fadeIn(400);

                        new Chart($('#chartPendapatanRT'), {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: '% Pendapatan Rendah',
                                    data: values,
                                    backgroundColor: 'rgba(220, 53, 69, 0.8)',
                                    borderColor: '#dc3545',
                                    borderWidth: 2,
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
                                        callbacks: {
                                            label: function(context) {
                                                return context.parsed.x.toFixed(2) +
                                                    '%';
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
                                            },
                                            font: {
                                                size: 12
                                            }
                                        },
                                        grid: {
                                            color: 'rgba(0,0,0,0.03)'
                                        }
                                    },
                                    y: {
                                        ticks: {
                                            font: {
                                                size: 12,
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
                        className: 'text-center'
                    },
                    {
                        data: 'no_nik',
                        name: 'no_nik',
                        className: 'text-center'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jenkel',
                        name: 'jenkel',
                        className: 'text-center',
                        render: data => data == 1 ?
                            '<span class="badge-status-premium badge-primary-premium">L</span>' :
                            '<span class="badge-status-premium badge-danger-premium">P</span>'
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
                        data: 'kp',
                        name: 'kp'
                    },
                    {
                        data: 'rt_rw',
                        name: 'rt_rw',
                        className: 'text-center'
                    },
                    {
                        data: 'pendapatan_perbulan',
                        name: 'pendapatan_perbulan',
                        className: 'text-center'
                    },
                    {
                        data: 'punya_bpjs',
                        name: 'punya_bpjs',
                        className: 'text-center',
                        render: data => data === 'ya' ?
                            '<span class="badge-status-premium badge-success-premium">Punya</span>' :
                            '<span class="badge-status-premium badge-danger-premium">Tidak</span>'
                    },
                    {
                        data: 'pembayaran_bpjs',
                        name: 'pembayaran_bpjs',
                        className: 'text-center',
                        render: data => data ?
                            `<span class="badge-status-premium badge-info-premium">${data}</span>` :
                            '<span class="text-muted">-</span>'
                    }
                ]
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
                $('#filter-pendapatan').val('').trigger('change');
                $('#filter-kelompok-umur').val('').trigger('change');
                $('#filter-rt-rw').val('').trigger('change');
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
                        className: 'text-center'
                    },
                    {
                        data: 'no_nik',
                        name: 'no_nik',
                        className: 'text-center'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jenkel',
                        name: 'jenkel',
                        className: 'text-center',
                        render: data => data == 1 ?
                            '<span class="badge-status-premium badge-primary-premium">L</span>' :
                            '<span class="badge-status-premium badge-danger-premium">P</span>'
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
                        data: 'kp',
                        name: 'kp'
                    },
                    {
                        data: 'rt_rw',
                        name: 'rt_rw',
                        className: 'text-center'
                    },
                    {
                        data: 'pendapatan_perbulan',
                        name: 'pendapatan_perbulan',
                        className: 'text-center'
                    },
                    {
                        data: 'punya_bpjs',
                        name: 'punya_bpjs',
                        className: 'text-center',
                        render: data => data === 'ya' ?
                            '<span class="badge-status-premium badge-success-premium">Punya</span>' :
                            '<span class="badge-status-premium badge-danger-premium">Tidak</span>'
                    },
                    {
                        data: 'pembayaran_bpjs',
                        name: 'pembayaran_bpjs',
                        className: 'text-center',
                        render: data => data ?
                            `<span class="badge-status-premium badge-info-premium">${data}</span>` :
                            '<span class="text-muted">-</span>'
                    }
                ]
            });

            $('#filter-lansia-pendapatan, #filter-lansia-rt-rw').change(function() {
                tableLansia.draw();
            });

            $('#reset-filter-lansia').click(function() {
                $('#filter-lansia-pendapatan').val('').trigger('change');
                $('#filter-lansia-rt-rw').val('').trigger('change');
                tableLansia.draw();
            });

            // Main category pills navigation
            $('#categoryTab a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                const targetPane = $(e.target).attr('href');

                // Scroll to top of card
                $('html, body').animate({
                    scrollTop: $('.card-widget-premium:last').offset().top - 100
                }, 300);

                setTimeout(function() {
                    if (targetPane === '#semua-penduduk') {
                        tablePenduduk.columns.adjust().draw(false);
                    } else if (targetPane === '#tab-lansia-rentan') {
                        tableLansia.columns.adjust().draw(false);
                    }
                }, 150);
            });
        });
    </script>
@endpush
