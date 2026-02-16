@extends('admin.layout.main')
@section('title', 'Statistik Pendapatan')
@section('content-header', 'Statistik Pendapatan Kecamatan')

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

        .badge-indigo {
            background-color: #6610f2;
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
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>

                                <div class="ml-3">
                                    <h5 class="font-weight-bold mb-1">Ringkasan Statistik Pendapatan</h5>
                                    <p class="stat-sublabel-premium mb-0">
                                        Data pendapatan penduduk, pekerjaan, dan analisis ekonomi di seluruh desa
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

                <!-- Total Kepala Keluarga -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalKepalaKeluarga">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        Kepala Keluarga
                                        <i class="fas fa-home stat-mini-icon"></i>
                                    </p>
                                    <p class="stat-sublabel-premium mb-0">Total KK</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pekerja -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalPekerja">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        Bekerja
                                        <i class="fas fa-briefcase stat-mini-icon"></i>
                                    </p>
                                    <p class="stat-sublabel-premium mb-0">Total Pekerja</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Tidak Bekerja -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-secondary text-white">
                                    <i class="fas fa-user-slash"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalTidakBekerja">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        Tidak Bekerja
                                        <i class="fas fa-user-slash stat-mini-icon"></i>
                                    </p>
                                    <p class="stat-sublabel-premium mb-0">Belum/Tidak Produktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan 0-1 Juta -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="pendapatan01">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        0-1 Juta
                                        <i class="fas fa-coins stat-mini-icon"></i>
                                    </p>
                                    <p class="stat-sublabel-premium mb-0">Kategori Rendah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan 1-5 Juta -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-money-bill"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="pendapatan15">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        1-5 Juta
                                        <i class="fas fa-money-bill stat-mini-icon"></i>
                                    </p>
                                    <p class="stat-sublabel-premium mb-0">Kategori Menengah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan 5-10 Juta -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-money-check-alt"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="pendapatan510">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        5-10 Juta
                                        <i class="fas fa-money-check-alt stat-mini-icon"></i>
                                    </p>
                                    <p class="stat-sublabel-premium mb-0">Kategori Tinggi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan >10 Juta -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-gem"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="pendapatan10Plus">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        >10 Juta
                                        <i class="fas fa-gem stat-mini-icon"></i>
                                    </p>
                                    <p class="stat-sublabel-premium mb-0">Kategori Sangat Tinggi</p>
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

                <!-- Persentase Pekerja -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentasePekerja">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentasePekerjaPercent">%</span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        % Bekerja
                                        <i class="fas fa-percentage stat-mini-icon"></i>
                                    </p>
                                    <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Persentase Tidak Bekerja -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentaseTidakBekerja">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentaseTidakBekerjaPercent">%</span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        % Tidak Bekerja
                                        <i class="fas fa-chart-line stat-mini-icon"></i>
                                    </p>
                                    <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rasio Pekerja -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-balance-scale"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="rasioPekerja">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="rasioPekerjaSuffix">:1</span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        Rasio Pekerja
                                        <i class="fas fa-balance-scale stat-mini-icon"></i>
                                    </p>
                                    <p class="stat-sublabel-premium mb-0">Bekerja : Tidak Bekerja</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Pendapatan -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" style="font-size: 1.5rem;">
                                        <span id="rataRataPendapatan">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        Rata-rata Pendapatan
                                        <i class="fas fa-wallet stat-mini-icon"></i>
                                    </p>
                                    <p class="stat-sublabel-premium mb-0">Per Keluarga/Bulan</p>
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

                <!-- Distribusi Pendapatan -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Pendapatan</h3>
                                <p class="card-subtitle-premium">Kategori pendapatan per bulan</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartPendapatan" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartPendapatan" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Pekerjaan -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Pekerjaan (Top 10)</h3>
                                <p class="card-subtitle-premium">Jenis pekerjaan terbanyak</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartPekerjaan" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartPekerjaan" style="display:none; max-height: 400px;"></canvas>
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
                                <p class="card-subtitle-premium">Perbandingan gender</p>
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
                                <p class="card-subtitle-premium">Jumlah penduduk per desa</p>
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
                                <p class="card-subtitle-premium">Penduduk per kelompok umur</p>
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

                <!-- Pendapatan Berdasarkan Umur dan Gender -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Penduduk per Umur & Gender</h3>
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

                <!-- Top 10 Pekerjaan Pendapatan Tertinggi -->
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Top 10 Pekerjaan dengan Pendapatan Tertinggi</h3>
                                <p class="card-subtitle-premium">Berdasarkan rata-rata pendapatan</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartTopPekerjaan" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartTopPekerjaan" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan Tertinggi Per Desa -->
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Rata-rata Pendapatan Per Desa</h3>
                                <p class="card-subtitle-premium">Dalam jutaan rupiah per bulan</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartPendapatanDesa" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartPendapatanDesa" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan Berdasarkan Kelompok Umur - Stacked -->
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-warning">
                            <div class="card-header-icon">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Pendapatan Berdasarkan Kelompok Umur</h3>
                                <p class="card-subtitle-premium">Distribusi kategori pendapatan per kelompok umur</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartPendapatanUmur" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartPendapatanUmur" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan Per Desa - Stacked -->
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-info">
                            <div class="card-header-icon">
                                <i class="fas fa-chart-area"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Kategori Pendapatan Per Desa</h3>
                                <p class="card-subtitle-premium">Distribusi kategori pendapatan di setiap desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartPendapatanPerDesa" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartPendapatanPerDesa" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pekerjaan Berdasarkan Gender -->
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Top 10 Pekerjaan Berdasarkan Gender</h3>
                                <p class="card-subtitle-premium">Distribusi pekerjaan laki-laki dan perempuan</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartPekerjaanGender" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartPekerjaanGender" style="display:none; max-height: 400px;"></canvas>
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
                                <h3 class="card-title-premium">Detail Statistik Per Desa</h3>
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
                                                <th width="8%" class="text-center">Kepala KK</th>
                                                <th width="10%" class="text-center">Bekerja</th>
                                                <th width="10%" class="text-center">Tidak Bekerja</th>
                                                <th width="15%" class="text-center">Rata Pendapatan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableDetailDesa" class="nowrap">
                                            <tr class="nowrap">
                                                <td colspan="9" class="py-4 text-center">
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

            <!-- DataTable Kepala Keluarga -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Data Lengkap Kepala Keluarga</h3>
                                <p class="card-subtitle-premium">Daftar detail kepala keluarga dengan pendapatan</p>
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
                                        <label for="filterPendapatan">
                                            <i class="fas fa-money-bill mr-1"></i> Pendapatan
                                        </label>
                                        <select class="form-control select2" id="filterPendapatan" style="width: 100%;">
                                            <option value="">-- Semua Kategori --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filterPekerjaan">
                                            <i class="fas fa-briefcase mr-1"></i> Pekerjaan
                                        </label>
                                        <select class="form-control select2" id="filterPekerjaan" style="width: 100%;">
                                            <option value="">-- Semua Pekerjaan --</option>
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
                                <table class="table-bordered table-hover table" id="tableKepalaKeluarga"
                                    style="width:100%">
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
                                            <th width="12%">Pendapatan</th>
                                            <th width="15%">Pekerjaan</th>
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
            let tableKepalaKeluarga;

            const colors = {
                primary: ['#007bff', '#0056b3', '#004085', '#6610f2', '#6f42c1'],
                success: ['#28a745', '#20c997', '#17a2b8', '#138496', '#117a8b'],
                warning: ['#ffc107', '#ff9800', '#ff5722', '#e91e63', '#f44336'],
                info: ['#17a2b8', '#20c997', '#6610f2', '#007bff', '#6c757d'],
                danger: ['#dc3545', '#c82333', '#bd2130', '#a71d2a', '#8b0000'],
                purple: ['#6f42c1', '#5a32a3', '#452586', '#563d7c', '#6610f2'],
                mixed: ['#28a745', '#20c997', '#17a2b8', '#007bff', '#6f42c1', '#fd7e14', '#ffc107',
                    '#dc3545', '#e83e8c'
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

            function showEmptyChart(chartId, message) {
                const loadingId = 'loading' + chartId.charAt(0).toUpperCase() + chartId.slice(1);
                $('#' + loadingId).html(`
                    <div class="text-center py-4">
                        <i class="fas fa-info-circle text-muted fa-3x mb-3"></i>
                        <h5 class="text-muted">${message}</h5>
                        <p class="text-muted">Data belum tersedia</p>
                    </div>
                `);
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
                                        if (canvasId === 'chartPendapatanDesa') {
                                            return 'Rata-rata: Rp ' + formatNumber(context.parsed.y *
                                                1000000);
                                        }
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
                                        if (canvasId === 'chartPendapatanDesa') {
                                            return value + ' Jt';
                                        }
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
                                <span class="badge badge-warning badge-stat">${formatNumber(item.kepala_keluarga)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success badge-stat">${formatNumber(item.pekerja)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary badge-stat">${formatNumber(item.tidak_bekerja)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary badge-stat">${item.rata_rata_pendapatan}</span>
                            </td>
                        </tr>
                    `;
                });

                if (html === '') {
                    html = '<tr><td colspan="9" class="text-center text-muted py-4">Tidak ada data</td></tr>';
                }

                $('#tableDetailDesa').html(html);
            }

            // Initialize DataTable
            function initDataTableKepalaKeluarga() {
                if ($.fn.DataTable.isDataTable('#tableKepalaKeluarga')) {
                    $('#tableKepalaKeluarga').DataTable().destroy();
                }

                tableKepalaKeluarga = $('#tableKepalaKeluarga').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('kecamatan.pendapatan.datatable.kepala-keluarga') }}',
                        data: function(d) {
                            d.desa = $('#filterDesa').val();
                            d.pendapatan = $('#filterPendapatan').val();
                            d.pekerjaan = $('#filterPekerjaan').val();
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
                            data: 'pendapatan_badge',
                            name: 'pendapatan_perbulan',
                            className: 'text-center'
                        },
                        {
                            data: 'pekerjaan_display',
                            name: 'jenis_pekerjaan'
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
                    url: '{{ route('kecamatan.pendapatan.jumlah') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const d = response.data;

                            // Gunakan parseInt() agar tidak terjadi string concatenation
                            const p01 = parseInt(d.pendapatan_0_1) || 0;
                            const p12 = parseInt(d.pendapatan_1_2) || 0;
                            const p23 = parseInt(d.pendapatan_2_3) || 0;
                            const p35 = parseInt(d.pendapatan_3_5) || 0;
                            const p510 = parseInt(d.pendapatan_5_10) || 0;
                            const p10p = parseInt(d.pendapatan_10_plus) || 0;

                            animateNumber('#totalPenduduk', parseInt(d.total_penduduk) || 0);
                            animateNumber('#totalLaki', parseInt(d.total_laki) || 0);
                            animateNumber('#totalPerempuan', parseInt(d.total_perempuan) || 0);
                            animateNumber('#totalKepalaKeluarga', parseInt(d.total_kepala_keluarga) ||
                                0);
                            animateNumber('#totalPekerja', parseInt(d.total_pekerja) || 0);
                            animateNumber('#totalTidakBekerja', parseInt(d.total_tidak_bekerja) || 0);

                            // Kategori pendapatan — jumlah eksplisit dengan parseInt
                            animateNumber('#pendapatan01', p01);
                            animateNumber('#pendapatan15', p12 + p23 + p35); // FIX: sudah integer
                            animateNumber('#pendapatan510', p510);
                            animateNumber('#pendapatan10Plus', p10p);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error statistik jumlah:', xhr.responseJSON);
                    }
                });

                // 2. Statistik Rasio
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.rasio') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            $('#persentasePekerja').html(data.persentase_pekerja);
                            $('#persentasePekerjaPercent').removeClass('d-none');
                            $('#persentaseTidakBekerja').html(data.persentase_tidak_bekerja);
                            $('#persentaseTidakBekerjaPercent').removeClass('d-none');
                            $('#rasioPekerja').html(data.rasio_pekerja);
                            $('#rasioPekerjaSuffix').removeClass('d-none');
                            $('#rataRataPendapatan').html(data.rata_rata_pendapatan_keluarga);
                        }
                    }
                });

                // 3. Distribusi Pendapatan
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.distribusi') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderPieChart('chartPendapatan', 'Distribusi Pendapatan', response.data,
                                colors.mixed);
                        }
                    }
                });

                // 4. Distribusi Pekerjaan
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.pekerjaan.distribusi') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            if (Object.keys(response.data).length > 0) {
                                renderPieChart('chartPekerjaan', 'Distribusi Pekerjaan', response.data,
                                    colors.mixed);
                            } else {
                                showEmptyChart('chartPekerjaan', 'Tidak ada data pekerjaan');
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading pekerjaan distribution:', xhr);
                        showEmptyChart('chartPekerjaan', 'Error memuat data');
                    }
                });

                // 5. Distribusi Jenis Kelamin
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.jenkel') }}',
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
                    url: '{{ route('kecamatan.pendapatan.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartDesa', 'Per Desa', response.data, colors.mixed);
                        }
                    }
                });

                // 7. Distribusi Kelompok Umur
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.umur') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartUmur', 'Kelompok Umur', response.data, colors.warning);
                        }
                    }
                });

                // 8. Pendapatan Umur dan Jenis Kelamin
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.umur.jenkel') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderGroupedBarChart('chartUmurJenkel', response.data);
                        }
                    }
                });

                // 9. Top 10 Pekerjaan Pendapatan Tertinggi
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.top10.pekerjaan') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            if (Object.keys(response.data).length > 0) {
                                renderBarChart('chartTopPekerjaan', 'Top 10 Pekerjaan', response.data,
                                    colors
                                    .success);
                            } else {
                                showEmptyChart('chartTopPekerjaan', 'Tidak ada data pekerjaan');
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading top pekerjaan:', xhr);
                        showEmptyChart('chartTopPekerjaan', 'Error memuat data');
                    }
                });

                // 10. Pendapatan Tertinggi Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.tertinggi.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartPendapatanDesa', 'Pendapatan Per Desa', response.data,
                                colors.primary);
                        }
                    }
                });

                // 11. Pendapatan Berdasarkan Umur
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.berdasarkan.umur') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderStackedBarChart('chartPendapatanUmur', response.data);
                        }
                    }
                });

                // 12. Pendapatan Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.per.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderStackedBarChart('chartPendapatanPerDesa', response.data);
                        }
                    }
                });

                // 13. Detail Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.detail.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderTableDetailDesa(response.data);
                        }
                    }
                });

                // 14. Pekerjaan Berdasarkan Gender
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.pekerjaan.gender') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            if (Object.keys(response.data).length > 0) {
                                renderGroupedBarChart('chartPekerjaanGender', response.data);
                            } else {
                                showEmptyChart('chartPekerjaanGender', 'Tidak ada data pekerjaan');
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading pekerjaan gender:', xhr);
                        showEmptyChart('chartPekerjaanGender', 'Error memuat data');
                    }
                });

                // 15. Load List Desa
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.list.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let options = '<option value="">-- Semua Desa --</option>';
                            response.data.forEach(function(desa) {
                                options += `<option value="${desa.code}">${desa.name}</option>`;
                            });
                            $('#filterDesa').html(options);
                            $('#filterDesa').select2({
                                theme: 'bootstrap4',
                                allowClear: true
                            });
                        }
                    }
                });

                // 16. Load List Pendapatan
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.list.pendapatan') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let options = '<option value="">-- Semua Kategori --</option>';
                            response.data.forEach(function(item) {
                                options += `<option value="${item}">${item}</option>`;
                            });
                            $('#filterPendapatan').html(options);
                            $('#filterPendapatan').select2({
                                theme: 'bootstrap4',
                                allowClear: true
                            });
                        }
                    }
                });

                // 17. Load List Pekerjaan
                $.ajax({
                    url: '{{ route('kecamatan.pendapatan.list.pekerjaan') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let options = '<option value="">-- Semua Pekerjaan --</option>';
                            response.data.forEach(function(item) {
                                options += `<option value="${item}">${item}</option>`;
                            });
                            $('#filterPekerjaan').html(options);
                            $('#filterPekerjaan').select2({
                                theme: 'bootstrap4',
                                allowClear: true
                            });
                        }
                    }
                });
            }

            // Initialize DataTable
            initDataTableKepalaKeluarga();

            // Event handlers untuk filter
            $('#btnFilter').on('click', function() {
                tableKepalaKeluarga.ajax.reload();
            });

            $('#btnResetFilter').on('click', function() {
                $('#filterDesa').val('').trigger('change');
                $('#filterPendapatan').val('').trigger('change');
                $('#filterPekerjaan').val('').trigger('change');
                tableKepalaKeluarga.ajax.reload();
            });

            // Load all data
            loadAllData();
        });
    </script>
@endpush
