@extends('admin.layout.main')
@section('title', 'Statistik BPJS')
@section('content-header', 'Statistik BPJS Kecamatan')

@push('styles')
    <style>
        /* DataTables Custom Style */
        .table {
            font-size: 0.9rem;
        }

        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge-lg {
            font-size: 0.9rem;
            padding: 0.4rem 0.6rem;
        }

        .badge-stat {
            font-size: 0.85rem;
            padding: 0.35rem 0.6rem;
            font-weight: 600;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #495057;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .badge-purple {
            background-color: #6f42c1;
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">

            <!-- Header Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-2">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-primary text-white">
                                    <i class="fas fa-id-card"></i>
                                </div>

                                <div class="ml-3">
                                    <h5 class="font-weight-bold mb-1">Ringkasan Statistik BPJS</h5>
                                    <p class="stat-sublabel-premium mb-0">
                                        Data kepemilikan BPJS dan metode pembayaran di seluruh desa
                                    </p>
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

                                    <p class="stat-sublabel-premium mb-0">Seluruh Penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Laki-laki -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-male"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalLaki">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Laki-laki
                                        <i class="fas fa-male stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Jumlah Laki-laki</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Perempuan -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-female"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalPerempuan">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Perempuan
                                        <i class="fas fa-female stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Jumlah Perempuan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Punya BPJS -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-check-circle"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="punyaBpjs">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Punya BPJS
                                        <i class="fas fa-check-circle stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Terdaftar BPJS</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tidak Punya BPJS -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-times-circle"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="tidakPunyaBpjs">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Tidak Punya BPJS
                                        <i class="fas fa-times-circle stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Belum Terdaftar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BPJS Kesehatan -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-hospital"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="bpjsKesehatan">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        BPJS Kesehatan
                                        <i class="fas fa-hospital stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Kesehatan Saja</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BPJS Ketenagakerjaan -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-primary text-white">
                                    <i class="fas fa-hard-hat"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="bpjsKetenagakerjaan">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        BPJS Ketenagakerjaan
                                        <i class="fas fa-hard-hat stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Ketenagakerjaan Saja</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Memiliki Keduanya -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white"
                                    style="background: linear-gradient(135deg, #6f42c1 0%, #563d7c 100%);">
                                    <i class="fas fa-shield-alt"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="memilikiKeduanya">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Memiliki Keduanya
                                        <i class="fas fa-shield-alt stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Kesehatan & Ketenagakerjaan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bayar Pemerintah -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-landmark"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="bayarPemerintah">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Bayar Pemerintah
                                        <i class="fas fa-landmark stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Pemerintah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bayar Perusahaan -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-primary text-white">
                                    <i class="fas fa-building"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="bayarPerusahaan">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Bayar Perusahaan
                                        <i class="fas fa-building stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Pemerintah/Perusahaan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bayar Mandiri -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-wallet"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="bayarMandiri">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Bayar Mandiri
                                        <i class="fas fa-wallet stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Mandiri</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATISTIK RASIO -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h4 class="section-title">
                        <i class="fas fa-chart-pie mr-2"></i> Statistik Rasio
                    </h4>
                </div>

                <!-- Persentase Punya BPJS -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-percentage"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentasePunyaBpjs">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentasePunyaBpjsPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        % Punya BPJS
                                        <i class="fas fa-percentage stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Persentase Tidak Punya -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-chart-line"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentaseTidakPunya">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentaseTidakPunyaPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        % Tidak Punya
                                        <i class="fas fa-chart-line stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rasio Kepemilikan -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-balance-scale"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="rasioKepemilikan">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="rasioKepemilikanSuffix">:1</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Rasio Kepemilikan
                                        <i class="fas fa-balance-scale stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Punya : Tidak Punya</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATISTIK DISTRIBUSI CHARTS -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h4 class="section-title">
                        <i class="fas fa-chart-bar mr-2"></i> Statistik Distribusi
                    </h4>
                </div>

                <!-- Jenis BPJS -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Jenis BPJS</h3>
                                <p class="card-subtitle-premium">Jenis BPJS yang dimiliki</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartJenisBpjs" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartJenisBpjs" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Metode Pembayaran</h3>
                                <p class="card-subtitle-premium">Cara pembayaran BPJS</p>
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
                            <canvas id="chartPembayaran" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-info">
                            <div class="card-header-icon">
                                <i class="fas fa-venus-mars"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Jenis Kelamin</h3>
                                <p class="card-subtitle-premium">Pemilik BPJS berdasarkan gender</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartJenkel" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartJenkel" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Per Desa -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-warning">
                            <div class="card-header-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Per Desa</h3>
                                <p class="card-subtitle-premium">Kepemilikan BPJS per desa</p>
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

                <!-- Kelompok Umur -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-purple">
                            <div class="card-header-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Kelompok Umur</h3>
                                <p class="card-subtitle-premium">Pemilik BPJS per kelompok umur</p>
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

                <!-- BPJS Berdasarkan Umur dan Jenis Kelamin -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">BPJS per Umur & Gender</h3>
                                <p class="card-subtitle-premium">Distribusi berdasarkan umur dan jenis kelamin</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartUmurJenkel" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartUmurJenkel" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Jenis BPJS Per Desa (Stacked) -->
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Jenis BPJS Per Desa</h3>
                                <p class="card-subtitle-premium">Perbandingan jenis BPJS di setiap desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartBpjsDesa" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartBpjsDesa" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Detail Per Desa -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon">
                                <i class="fas fa-table"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Detail BPJS Per Desa</h3>
                                <p class="card-subtitle-premium">Rincian lengkap setiap desa</p>
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
                                        <thead class="nowrap">
                                            <tr class="nowrap">
                                                <th width="3%">#</th>
                                                <th width="15%">Desa</th>
                                                <th width="8%" class="text-center">Total</th>
                                                <th width="8%" class="text-center">Laki-laki</th>
                                                <th width="8%" class="text-center">Perempuan</th>
                                                <th width="9%" class="text-center">Punya BPJS</th>
                                                <th width="9%" class="text-center">Tidak Punya</th>
                                                <th width="10%" class="text-center">BPJS Kesehatan</th>
                                                <th width="10%" class="text-center">BPJS Naker</th>
                                                <th width="10%" class="text-center">Keduanya</th>
                                                <th width="10%" class="text-center">Bayar Mandiri</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableDetailDesa" class="nowrap">
                                            <tr class="nowrap">
                                                <td colspan="11" class="py-4 text-center">
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

            <!-- ANALISIS DATA ABNORMAL -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <div class="alert alert-warning border-left-warning">
                        <h5 class="alert-heading">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Analisis Data Abnormal & Validasi Data
                        </h5>
                        <p class="mb-0">
                            <strong>Catatan Penting:</strong> Data berikut menampilkan <strong>inkonsistensi</strong> dalam
                            pengisian data BPJS yang perlu <strong>diverifikasi dan diperbaiki</strong> untuk akurasi data.
                        </p>
                    </div>
                </div>

                <!-- Chart Data Abnormal -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Kategori Data Abnormal</h3>
                                <p class="card-subtitle-premium">Inkonsistensi pengisian data</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartAbnormal" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartAbnormal" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Info Boxes Abnormal -->
                <div class="col-lg-6 mb-4">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="stat-card-premium elevation-3 border-warning">
                                <div class="stat-card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon-premium icon-warning text-white">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                        <div class="flex-grow-1 ml-3">
                                            <p class="stat-number-premium text-warning" id="abnormalJenis">0</p>
                                            <p class="stat-label-premium mb-0">Punya BPJS Tanpa Jenis</p>
                                            <p class="stat-sublabel-premium text-warning mb-0">Perlu dilengkapi jenis BPJS
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="stat-card-premium elevation-3 border-warning">
                                <div class="stat-card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon-premium icon-warning text-white">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <div class="flex-grow-1 ml-3">
                                            <p class="stat-number-premium text-warning" id="abnormalBayar">0</p>
                                            <p class="stat-label-premium mb-0">Punya BPJS Tanpa Metode Bayar</p>
                                            <p class="stat-sublabel-premium text-warning mb-0">Perlu dilengkapi metode
                                                pembayaran</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="stat-card-premium elevation-3 border-danger">
                                <div class="stat-card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon-premium icon-danger text-white">
                                            <i class="fas fa-times-circle"></i>
                                        </div>
                                        <div class="flex-grow-1 ml-3">
                                            <p class="stat-number-premium text-danger" id="abnormalTidakPunyaJenis">0</p>
                                            <p class="stat-label-premium mb-0">Tidak Punya BPJS Ada Jenis</p>
                                            <p class="stat-sublabel-premium text-danger mb-0">Data bertentangan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DataTable Data Abnormal -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-list-alt"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Data Lengkap Abnormal untuk Verifikasi</h3>
                                <p class="card-subtitle-premium">Daftar data yang perlu diperbaiki</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div class="alert alert-danger mb-3">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Tindak Lanjut yang Diperlukan:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Verifikasi data lapangan</li>
                                    <li>Perbaiki inkonsistensi data</li>
                                    <li>Lengkapi data yang kurang</li>
                                    <li>Update database dengan data yang benar</li>
                                </ul>
                            </div>

                            <!-- Filter Section -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="filterKategoriAbnormal">
                                            <i class="fas fa-filter mr-1"></i> Kategori
                                        </label>
                                        <select class="form-control select2" id="filterKategoriAbnormal"
                                            style="width: 100%;">
                                            <option value="">-- Semua Kategori --</option>
                                            <option value="Punya BPJS Tanpa Jenis">Punya BPJS Tanpa Jenis</option>
                                            <option value="Punya BPJS Tanpa Metode Bayar">Punya BPJS Tanpa Metode Bayar
                                            </option>
                                            <option value="Tidak Punya BPJS Ada Jenis">Tidak Punya BPJS Ada Jenis</option>
                                            <option value="Tidak Punya BPJS Ada Pembayaran">Tidak Punya BPJS Ada Pembayaran
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="filterDesaAbnormal">
                                            <i class="fas fa-map-marker-alt mr-1"></i> Desa
                                        </label>
                                        <select class="form-control select2" id="filterDesaAbnormal"
                                            style="width: 100%;">
                                            <option value="">-- Semua Desa --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-danger flex-grow-1 mr-2"
                                                id="btnFilterAbnormal">
                                                <i class="fas fa-search mr-1"></i> Filter
                                            </button>
                                            <button type="button" class="btn btn-secondary flex-grow-1"
                                                id="btnResetFilterAbnormal">
                                                <i class="fas fa-redo mr-1"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- DataTable -->
                            <div class="table-responsive">
                                <table class="table-bordered table-hover table" id="tableAbnormal" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="4%">No</th>
                                            <th width="10%">Desa</th>
                                            <th width="12%">NIK</th>
                                            <th width="15%">Nama</th>
                                            <th width="8%" class="text-center">JK</th>
                                            <th width="6%" class="text-center">Umur</th>
                                            <th width="10%" class="text-center">Tgl Lahir</th>
                                            <th width="8%" class="text-center">RT/RW</th>
                                            <th width="15%">Kategori Abnormal</th>
                                            <th width="12%">Detail Masalah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DataTable Lengkap Penduduk -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Data Lengkap Penduduk dan BPJS</h3>
                                <p class="card-subtitle-premium">Daftar detail seluruh penduduk dengan informasi BPJS</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <!-- Filter Section -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filterDesa">
                                            <i class="fas fa-map-marker-alt mr-1"></i> Filter Desa
                                        </label>
                                        <select class="form-control select2" id="filterDesa" style="width: 100%;">
                                            <option value="">-- Semua Desa --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filterStatusBpjs">
                                            <i class="fas fa-id-card mr-1"></i> Status BPJS
                                        </label>
                                        <select class="form-control select2" id="filterStatusBpjs" style="width: 100%;">
                                            <option value="">-- Semua Status --</option>
                                            <option value="punya">Punya BPJS</option>
                                            <option value="tidak_punya">Tidak Punya BPJS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filterJenkel">
                                            <i class="fas fa-venus-mars mr-1"></i> Jenis Kelamin
                                        </label>
                                        <select class="form-control select2" id="filterJenkel" style="width: 100%;">
                                            <option value="">-- Semua --</option>
                                            <option value="1">Laki-laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-primary flex-grow-1 mr-2"
                                                id="btnFilter">
                                                <i class="fas fa-search mr-1"></i> Filter
                                            </button>
                                            <button type="button" class="btn btn-secondary flex-grow-1"
                                                id="btnResetFilter">
                                                <i class="fas fa-redo mr-1"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- DataTable -->
                            <div class="table-responsive">
                                <table class="table-bordered table-hover table" id="tablePendudukBpjs"
                                    style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="4%">No</th>
                                            <th width="10%">Desa</th>
                                            <th width="12%">NIK</th>
                                            <th width="15%">Nama</th>
                                            <th width="8%" class="text-center">Jenis Kelamin</th>
                                            <th width="6%" class="text-center">Umur</th>
                                            <th width="10%" class="text-center">Tgl Lahir</th>
                                            <th width="8%" class="text-center">RT/RW</th>
                                            <th width="10%" class="text-center">Status BPJS</th>
                                            <th width="10%">Jenis BPJS</th>
                                            <th width="9%">Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
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
            let tableAbnormal;
            let tablePenduduk;

            const colors = {
                primary: ['#007bff', '#0056b3', '#004085', '#6610f2', '#6f42c1'],
                success: ['#28a745', '#20c997', '#17a2b8', '#138496', '#117a8b'],
                warning: ['#ffc107', '#ff9800', '#ff5722', '#e91e63', '#f44336'],
                info: ['#17a2b8', '#20c997', '#6610f2', '#007bff', '#6c757d'],
                danger: ['#dc3545', '#c82333', '#bd2130', '#a71d2a', '#8b0000'],
                purple: ['#6f42c1', '#5a32a3', '#452586', '#563d7c', '#6610f2'],
                mixed: ['#28a745', '#007bff', '#6f42c1', '#ffc107', '#17a2b8', '#fd7e14', '#20c997', '#e83e8c',
                    '#6c757d', '#343a40'
                ]
            };

            // Helper Functions
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

            // Chart Rendering Functions
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

            function renderGroupedBarChart(canvasId, data) {
                const ctx = document.getElementById(canvasId);
                if (charts[canvasId]) charts[canvasId].destroy();

                const labels = Object.values(data).map(item => item.label);
                const dataLaki = Object.values(data).map(item => item.laki);
                const dataPerempuan = Object.values(data).map(item => item.perempuan);

                charts[canvasId] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Laki-laki',
                                data: dataLaki,
                                backgroundColor: '#007bff',
                                borderColor: '#007bff',
                                borderWidth: 1
                            },
                            {
                                label: 'Perempuan',
                                data: dataPerempuan,
                                backgroundColor: '#e83e8c',
                                borderColor: '#e83e8c',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 13,
                                        weight: '600'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 15,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + formatNumber(context
                                            .parsed.y) + ' orang';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                stacked: false,
                                grid: {
                                    color: 'rgba(0,0,0,0.03)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return formatNumber(value);
                                    }
                                }
                            },
                            x: {
                                stacked: false,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45,
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
                hideChartLoading(canvasId);
            }

            function renderStackedBarChart(canvasId, data) {
                const ctx = document.getElementById(canvasId);
                if (charts[canvasId]) charts[canvasId].destroy();

                charts[canvasId] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 13,
                                        weight: '600'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 15,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + formatNumber(context
                                            .parsed.y) + ' orang';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                stacked: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.03)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return formatNumber(value);
                                    }
                                }
                            },
                            x: {
                                stacked: true,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45,
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
                hideChartLoading(canvasId);
            }

            function renderTableDetailDesa(data) {
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
                                <strong>${item.desa}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-${badgeColor} badge-stat">${formatNumber(item.total_penduduk)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info badge-stat">${formatNumber(item.laki_laki)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-danger badge-stat">${formatNumber(item.perempuan)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success badge-stat">${formatNumber(item.punya_bpjs)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary badge-stat">${formatNumber(item.tidak_punya_bpjs)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success badge-stat">${formatNumber(item.bpjs_kesehatan)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary badge-stat">${formatNumber(item.bpjs_ketenagakerjaan)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-purple badge-stat">${formatNumber(item.memiliki_keduanya)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-warning badge-stat">${formatNumber(item.bayar_mandiri)}</span>
                            </td>
                        </tr>
                    `;
                });

                if (html === '') {
                    html = '<tr><td colspan="11" class="text-center text-muted py-4">Tidak ada data</td></tr>';
                }

                $('#tableDetailDesa').html(html);
            }

            // Initialize DataTable Abnormal
            function initDataTableAbnormal() {
                if ($.fn.DataTable.isDataTable('#tableAbnormal')) {
                    $('#tableAbnormal').DataTable().destroy();
                }

                tableAbnormal = $('#tableAbnormal').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('kecamatan.bpjs.datatable.abnormal') }}',
                        type: 'GET',
                        data: function(d) {
                            d.kategori = $('#filterKategoriAbnormal').val();
                            d.desa = $('#filterDesaAbnormal').val();
                        },
                        error: function(xhr, error, code) {
                            console.log('DataTable Error:', xhr.responseText);
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
                            data: 'desa',
                            name: 'desa'
                        },
                        {
                            data: 'no_nik',
                            name: 'no_nik',
                            render: function(data) {
                                return '<small class="text-muted">' + data + '</small>';
                            }
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            render: function(data) {
                                return '<strong>' + data + '</strong>';
                            }
                        },
                        {
                            data: 'jenkel_display',
                            name: 'jenkel',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'umur_display',
                            name: 'umur',
                            orderable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'tgl_lahir_display',
                            name: 'tgl_lahir',
                            className: 'text-center'
                        },
                        {
                            data: 'rt_rw',
                            name: 'rt_rw',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'kategori_badge',
                            name: 'kategori_abnormal',
                            className: 'text-center'
                        },
                        {
                            data: 'detail_masalah',
                            name: 'detail_masalah',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    order: [
                        [1, 'asc'],
                        [3, 'asc']
                    ],
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "Semua"]
                    ],
                    language: {
                        processing: '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>',
                        search: '<i class="fas fa-search"></i>',
                        searchPlaceholder: 'Cari data...',
                        lengthMenu: 'Tampilkan _MENU_ data',
                        info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                        infoEmpty: 'Tidak ada data',
                        infoFiltered: '(difilter dari _MAX_ total)',
                        zeroRecords: '<div class="alert alert-success"><i class="fas fa-check-circle fa-3x mb-3"></i><h5>Tidak ada data abnormal</h5><p>Semua data sudah benar</p></div>',
                        emptyTable: '<div class="alert alert-info"><i class="fas fa-info-circle fa-3x mb-3"></i><h5>Tidak ada data</h5></div>',
                        paginate: {
                            first: '<<',
                            last: '>>',
                            next: '>',
                            previous: '<'
                        }
                    },
                    responsive: false,
                    autoWidth: false
                });
            }

            // Initialize DataTable Penduduk
            function initDataTablePenduduk() {
                if ($.fn.DataTable.isDataTable('#tablePendudukBpjs')) {
                    $('#tablePendudukBpjs').DataTable().destroy();
                }

                tablePenduduk = $('#tablePendudukBpjs').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('kecamatan.bpjs.datatable.penduduk') }}',
                        data: function(d) {
                            d.desa = $('#filterDesa').val();
                            d.status_bpjs = $('#filterStatusBpjs').val();
                            d.jenkel = $('#filterJenkel').val();
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
                            data: 'desa',
                            name: 'desa'
                        },
                        {
                            data: 'no_nik',
                            name: 'no_nik',
                            render: function(data) {
                                return '<small class="text-muted">' + data + '</small>';
                            }
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            render: function(data) {
                                return '<strong>' + data + '</strong>';
                            }
                        },
                        {
                            data: 'jenkel_display',
                            name: 'jenkel',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'umur_display',
                            name: 'umur',
                            orderable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'tgl_lahir_display',
                            name: 'tgl_lahir',
                            className: 'text-center'
                        },
                        {
                            data: 'rt_rw',
                            name: 'rt_rw',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'status_bpjs',
                            name: 'punya_bpjs',
                            className: 'text-center'
                        },
                        {
                            data: 'jenis_display',
                            name: 'jenis_bpjs'
                        },
                        {
                            data: 'pembayaran_display',
                            name: 'pembayaran_bpjs'
                        }
                    ],
                    order: [
                        [1, 'asc'],
                        [3, 'asc']
                    ],
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "Semua"]
                    ],
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                        search: '<i class="fas fa-search"></i>',
                        searchPlaceholder: 'Cari data...',
                        lengthMenu: 'Tampilkan _MENU_ data per halaman',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                        infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
                        infoFiltered: '(difilter dari _MAX_ total data)',
                        zeroRecords: '<div class="text-center"><i class="fas fa-search text-muted fa-3x mb-3"></i><h5 class="text-muted">Tidak ada data yang ditemukan</h5></div>',
                        emptyTable: '<div class="text-center"><i class="fas fa-info-circle text-muted fa-3x mb-3"></i><h5 class="text-muted">Tidak ada data</h5></div>',
                        paginate: {
                            first: '<i class="fas fa-angle-double-left"></i>',
                            last: '<i class="fas fa-angle-double-right"></i>',
                            next: '<i class="fas fa-angle-right"></i>',
                            previous: '<i class="fas fa-angle-left"></i>'
                        }
                    },
                    responsive: false,
                    autoWidth: false
                });
            }

            // Load All Data
            function loadAllData() {
                // 1. Statistik Jumlah
                $.ajax({
                    url: '{{ route('kecamatan.bpjs.jumlah') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            animateNumber('#totalPenduduk', data.total_penduduk);
                            animateNumber('#totalLaki', data.total_laki);
                            animateNumber('#totalPerempuan', data.total_perempuan);
                            animateNumber('#punyaBpjs', data.punya_bpjs);
                            animateNumber('#tidakPunyaBpjs', data.tidak_punya_bpjs);
                            animateNumber('#bpjsKesehatan', data.bpjs_kesehatan);
                            animateNumber('#bpjsKetenagakerjaan', data.bpjs_ketenagakerjaan);
                            animateNumber('#memilikiKeduanya', data.memiliki_keduanya);
                            animateNumber('#bayarPemerintah', data.bayar_pemerintah);
                            animateNumber('#bayarPerusahaan', data.bayar_perusahaan);
                            animateNumber('#bayarMandiri', data.bayar_mandiri);
                        }
                    }
                });

                // 2. Statistik Rasio
                $.ajax({
                    url: '{{ route('kecamatan.bpjs.rasio') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            $('#persentasePunyaBpjs').html(data.persentase_punya_bpjs);
                            $('#persentasePunyaBpjsPercent').removeClass('d-none');
                            $('#persentaseTidakPunya').html(data.persentase_tidak_punya);
                            $('#persentaseTidakPunyaPercent').removeClass('d-none');
                            $('#rasioKepemilikan').html(data.rasio_kepemilikan);
                            $('#rasioKepemilikanSuffix').removeClass('d-none');
                        }
                    }
                });

                // 3. Distribusi Jenis BPJS
                $.ajax({
                    url: '{{ route('kecamatan.bpjs.jenis') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderDoughnutChart('chartJenisBpjs', 'Jenis BPJS', response.data, colors
                                .mixed);
                        }
                    }
                });

                // 4. Distribusi Pembayaran
                $.ajax({
                    url: '{{ route('kecamatan.bpjs.pembayaran') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderPieChart('chartPembayaran', 'Metode Pembayaran', response.data, colors
                                .primary);
                        }
                    }
                });

                // 5. Distribusi Jenis Kelamin
                $.ajax({
                    url: '{{ route('kecamatan.bpjs.jenkel') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderPieChart('chartJenkel', 'Jenis Kelamin', response.data, ['#007bff',
                                '#e83e8c'
                            ]);
                        }
                    }
                });

                // 6. Distribusi Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.bpjs.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartDesa', 'Per Desa', response.data, colors.mixed);
                        }
                    }
                });

                // 7. Distribusi Kelompok Umur
                $.ajax({
                    url: '{{ route('kecamatan.bpjs.umur') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartUmur', 'Kelompok Umur', response.data, colors.warning);
                        }
                    }
                });

                // 8. BPJS Umur dan Jenis Kelamin
                $.ajax({
                    url: '{{ route('kecamatan.bpjs.umur.jenkel') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderGroupedBarChart('chartUmurJenkel', response.data);
                        }
                    }
                });

                // 9. Detail Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.bpjs.detail.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderTableDetailDesa(response.data);
                        }
                    }
                });

                // 10. Jenis BPJS Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.bpjs.jenis.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderStackedBarChart('chartBpjsDesa', response.data);
                        }
                    }
                });

                // 11. Data Abnormal
                $.ajax({
                    url: '{{ route('kecamatan.bpjs.abnormal') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartAbnormal', 'Data Abnormal', response.data, colors
                                .danger);

                            // Update info boxes
                            $('#abnormalJenis').text(formatNumber(response.data[
                                'Punya BPJS Tanpa Jenis'] || 0));
                            $('#abnormalBayar').text(formatNumber(response.data[
                                'Punya BPJS Tanpa Metode Bayar'] || 0));
                            $('#abnormalTidakPunyaJenis').text(formatNumber(response.data[
                                'Tidak Punya BPJS Ada Jenis'] || 0));
                        }
                    }
                });

                // 12. Load List Desa
                $.ajax({
                    url: '{{ route('kecamatan.bpjs.list.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let options = '<option value="">-- Semua Desa --</option>';
                            response.data.forEach(function(desa) {
                                options += `<option value="${desa.code}">${desa.name}</option>`;
                            });
                            $('#filterDesa, #filterDesaAbnormal').html(options);

                            $('#filterDesa, #filterDesaAbnormal, #filterStatusBpjs, #filterJenkel, #filterKategoriAbnormal')
                                .select2({
                                    theme: 'bootstrap4',
                                    allowClear: true
                                });
                        }
                    }
                });
            }

            // Initialize DataTables
            initDataTableAbnormal();
            initDataTablePenduduk();

            // Event handlers untuk filter Penduduk
            $('#btnFilter').on('click', function() {
                tablePenduduk.ajax.reload();
            });

            $('#btnResetFilter').on('click', function() {
                $('#filterDesa').val('').trigger('change');
                $('#filterStatusBpjs').val('').trigger('change');
                $('#filterJenkel').val('').trigger('change');
                tablePenduduk.ajax.reload();
            });

            // Event handlers untuk filter Abnormal
            $('#btnFilterAbnormal').on('click', function() {
                if (tableAbnormal) {
                    tableAbnormal.ajax.reload();
                }
            });

            $('#btnResetFilterAbnormal').on('click', function() {
                $('#filterKategoriAbnormal').val('').trigger('change');
                $('#filterDesaAbnormal').val('').trigger('change');
                if (tableAbnormal) {
                    tableAbnormal.ajax.reload();
                }
            });

            // Load all data
            loadAllData();
        });
    </script>
@endpush
