@extends('admin.layout.main')
@section('title', 'Statistik Kepemilikan Rumah')
@section('content-header', 'Statistik Kepemilikan Rumah Kecamatan')

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
                                    <i class="fas fa-home"></i>
                                </div>

                                <div class="ml-3">
                                    <h5 class="font-weight-bold mb-1">Ringkasan Statistik Kepemilikan Rumah</h5>
                                    <p class="stat-sublabel-premium mb-0">
                                        Data kepemilikan rumah kepala keluarga di seluruh desa
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

                <!-- Total Kepala Keluarga -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-primary text-white">
                                    <i class="fas fa-users"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalKK">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Total Kepala Keluarga
                                        <i class="fas fa-users stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Seluruh KK</p>
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
                                    <p class="stat-number-premium" id="totalLakiLaki">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Kepala KK Laki-laki
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
                                        Kepala KK Perempuan
                                        <i class="fas fa-female stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Jumlah Perempuan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Milik Sendiri -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-home"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="milikSendiri">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Milik Sendiri
                                        <i class="fas fa-home stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Rumah Sendiri</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orang Tua -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-primary text-white">
                                    <i class="fas fa-user-friends"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="orangTua">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Orang Tua
                                        <i class="fas fa-user-friends stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Rumah Orang Tua</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ngontrak -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-key"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="ngontrak">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Ngontrak
                                        <i class="fas fa-key stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Rumah Kontrak</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lainnya -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-secondary text-white"
                                    style="background: linear-gradient(135deg, #6c757d 0%, #545b62 100%);">
                                    <i class="fas fa-ellipsis-h"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="lainnya">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Lainnya
                                        <i class="fas fa-ellipsis-h stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Status Lainnya</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tidak Ada Data -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="tidakAdaData">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Tidak Ada Data
                                        <i class="fas fa-exclamation-triangle stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Belum Diisi</p>
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

                <!-- Persentase Milik Sendiri -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-percentage"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentaseMilikSendiri">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentaseMilikSendiriPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        % Milik Sendiri
                                        <i class="fas fa-percentage stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Dari total KK</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Persentase Tidak Milik Sendiri -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-chart-line"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentaseTidakMilikSendiri">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentaseTidakMilikSendiriPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        % Tidak Milik Sendiri
                                        <i class="fas fa-chart-line stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Dari total KK</p>
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

                                    <p class="stat-sublabel-premium mb-0">Milik : Tidak Milik</p>
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

                <!-- Distribusi Kepemilikan -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Status Kepemilikan</h3>
                                <p class="card-subtitle-premium">Status kepemilikan rumah</p>
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
                            <canvas id="chartKepemilikan" style="display:none; max-height: 400px;"></canvas>
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
                                <p class="card-subtitle-premium">Kepala keluarga berdasarkan gender</p>
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
                                <p class="card-subtitle-premium">Jumlah KK per desa</p>
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
                                <p class="card-subtitle-premium">Kepala KK per kelompok umur</p>
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

                <!-- Kepemilikan Berdasarkan Umur dan Jenis Kelamin -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Kepala KK per Umur & Gender</h3>
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

                <!-- Kepemilikan Berdasarkan Pendapatan -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Kepemilikan vs Pendapatan</h3>
                                <p class="card-subtitle-premium">Hubungan kepemilikan dengan pendapatan</p>
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
                            <canvas id="chartPendapatan" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Kepemilikan Per Desa (Stacked) -->
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Status Kepemilikan Per Desa</h3>
                                <p class="card-subtitle-premium">Perbandingan status kepemilikan di setiap desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartKepemilikanDesa" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartKepemilikanDesa" style="display:none; max-height: 400px;"></canvas>
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
                                <h3 class="card-title-premium">Detail Kepemilikan Rumah Per Desa</h3>
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
                                                <th width="8%" class="text-center">Total KK</th>
                                                <th width="8%" class="text-center">Laki-laki</th>
                                                <th width="8%" class="text-center">Perempuan</th>
                                                <th width="10%" class="text-center">Milik Sendiri</th>
                                                <th width="10%" class="text-center">Orang Tua</th>
                                                <th width="10%" class="text-center">Ngontrak</th>
                                                <th width="10%" class="text-center">Lainnya</th>
                                                <th width="10%" class="text-center">Tidak Ada Data</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableDetailDesa" class="nowrap">
                                            <tr class="nowrap">
                                                <td colspan="10" class="py-4 text-center">
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
                            pengisian data kepemilikan rumah yang perlu <strong>diverifikasi dan diperbaiki</strong> untuk
                            akurasi data.
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
                            <div class="stat-card-premium elevation-3 border-danger">
                                <div class="stat-card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon-premium icon-danger text-white">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                        <div class="flex-grow-1 ml-3">
                                            <p class="stat-number-premium text-danger" id="abnormalKepemilikanKosong">0
                                            </p>
                                            <p class="stat-label-premium mb-0">Kepemilikan Tidak Diisi</p>
                                            <p class="stat-sublabel-premium text-danger mb-0">Perlu dilengkapi status
                                                kepemilikan</p>
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
                                            <i class="fas fa-user-friends"></i>
                                        </div>
                                        <div class="flex-grow-1 ml-3">
                                            <p class="stat-number-premium text-warning" id="abnormalKepalaOrangTua">0</p>
                                            <p class="stat-label-premium mb-0">Kepala KK Status "Orang Tua"</p>
                                            <p class="stat-sublabel-premium text-warning mb-0">Status tidak valid</p>
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
                                            <i class="fas fa-child"></i>
                                        </div>
                                        <div class="flex-grow-1 ml-3">
                                            <p class="stat-number-premium text-danger" id="abnormalUmurMuda">0</p>
                                            <p class="stat-label-premium mb-0">Kepala KK Umur < 18 Tahun</p>
                                                    <p class="stat-sublabel-premium text-danger mb-0">Data tidak masuk akal
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
                                            <i class="fas fa-money-bill"></i>
                                        </div>
                                        <div class="flex-grow-1 ml-3">
                                            <p class="stat-number-premium text-warning" id="abnormalPendapatanKosong">0
                                            </p>
                                            <p class="stat-label-premium mb-0">Pendapatan Tidak Diisi</p>
                                            <p class="stat-sublabel-premium text-warning mb-0">Perlu dilengkapi pendapatan
                                            </p>
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
                                            <option value="Kepemilikan Tidak Diisi">Kepemilikan Tidak Diisi</option>
                                            <option value="Kepala KK Status Orang Tua">Kepala KK Status "Orang Tua"
                                            </option>
                                            <option value="Kepala KK Umur < 18 Tahun">Kepala KK Umur < 18 Tahun</option>
                                            <option value="Pendapatan Tidak Diisi">Pendapatan Tidak Diisi</option>
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

            <!-- DataTable Lengkap Kepala Keluarga -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Data Lengkap Kepala Keluarga</h3>
                                <p class="card-subtitle-premium">Daftar detail seluruh kepala keluarga dengan informasi
                                    kepemilikan rumah</p>
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
                                        <label for="filterKepemilikan">
                                            <i class="fas fa-home mr-1"></i> Status Kepemilikan
                                        </label>
                                        <select class="form-control select2" id="filterKepemilikan" style="width: 100%;">
                                            <option value="">-- Semua Status --</option>
                                            <option value="Milik Sendiri">Milik Sendiri</option>
                                            <option value="Orang Tua">Orang Tua</option>
                                            <option value="Ngontrak">Ngontrak</option>
                                            <option value="Lainnya">Lainnya</option>
                                            <option value="kosong">Tidak Ada Data</option>
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
                                        <label for="filterPendapatan">
                                            <i class="fas fa-money-bill mr-1"></i> Pendapatan
                                        </label>
                                        <select class="form-control select2" id="filterPendapatan" style="width: 100%;">
                                            <option value="">-- Semua Pendapatan --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-primary flex-grow-1 mr-2" id="btnFilter">
                                            <i class="fas fa-search mr-1"></i> Filter
                                        </button>
                                        <button type="button" class="btn btn-secondary flex-grow-1" id="btnResetFilter">
                                            <i class="fas fa-redo mr-1"></i> Reset
                                        </button>
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
                                            <th width="8%" class="text-center">Jenis Kelamin</th>
                                            <th width="6%" class="text-center">Umur</th>
                                            <th width="10%" class="text-center">Tgl Lahir</th>
                                            <th width="8%" class="text-center">RT/RW</th>
                                            <th width="12%">Kepemilikan</th>
                                            <th width="10%">Pendapatan</th>
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
            let tableKepalaKeluarga;

            const colors = {
                primary: ['#007bff', '#0056b3', '#004085', '#6610f2', '#6f42c1'],
                success: ['#28a745', '#20c997', '#17a2b8', '#138496', '#117a8b'],
                warning: ['#ffc107', '#ff9800', '#ff5722', '#e91e63', '#f44336'],
                info: ['#17a2b8', '#20c997', '#6610f2', '#007bff', '#6c757d'],
                danger: ['#dc3545', '#c82333', '#bd2130', '#a71d2a', '#8b0000'],
                purple: ['#6f42c1', '#5a32a3', '#452586', '#563d7c', '#6610f2'],
                mixed: ['#28a745', '#007bff', '#ffc107', '#6c757d', '#dc3545', '#fd7e14', '#20c997', '#e83e8c',
                    '#6610f2', '#343a40'
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
                                        return 'Jumlah: ' + formatNumber(context.parsed.y) + ' KK';
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
                                            .parsed.y) + ' KK';
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
                                            .parsed.y) + ' KK';
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
                                <span class="badge badge-${badgeColor} badge-stat">${formatNumber(item.total_kk)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info badge-stat">${formatNumber(item.laki_laki)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-danger badge-stat">${formatNumber(item.perempuan)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success badge-stat">${formatNumber(item.milik_sendiri)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary badge-stat">${formatNumber(item.orang_tua)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-warning badge-stat">${formatNumber(item.ngontrak)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary badge-stat">${formatNumber(item.lainnya)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-danger badge-stat">${formatNumber(item.tidak_ada_data)}</span>
                            </td>
                        </tr>
                    `;
                });

                if (html === '') {
                    html = '<tr><td colspan="10" class="text-center text-muted py-4">Tidak ada data</td></tr>';
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
                        url: '{{ route('kecamatan.kepemilikan.rumah.datatable.abnormal') }}',
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

            // Initialize DataTable Kepala Keluarga
            function initDataTableKepalaKeluarga() {
                if ($.fn.DataTable.isDataTable('#tableKepalaKeluarga')) {
                    $('#tableKepalaKeluarga').DataTable().destroy();
                }

                tableKepalaKeluarga = $('#tableKepalaKeluarga').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('kecamatan.kepemilikan.rumah.datatable.kepala-keluarga') }}',
                        data: function(d) {
                            d.desa = $('#filterDesa').val();
                            d.kepemilikan = $('#filterKepemilikan').val();
                            d.jenkel = $('#filterJenkel').val();
                            d.pendapatan = $('#filterPendapatan').val();
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
                            data: 'kepemilikan_display',
                            name: 'kepemilikan_rumah'
                        },
                        {
                            data: 'pendapatan_display',
                            name: 'pendapatan_perbulan'
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
                    url: '{{ route('kecamatan.kepemilikan.rumah.jumlah') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            animateNumber('#totalKK', data.total_kk);
                            animateNumber('#totalLakiLaki', data.total_laki_laki);
                            animateNumber('#totalPerempuan', data.total_perempuan);
                            animateNumber('#milikSendiri', data.milik_sendiri);
                            animateNumber('#orangTua', data.orang_tua);
                            animateNumber('#ngontrak', data.ngontrak);
                            animateNumber('#lainnya', data.lainnya);
                            animateNumber('#tidakAdaData', data.tidak_ada_data);
                        }
                    }
                });

                // 2. Statistik Rasio
                $.ajax({
                    url: '{{ route('kecamatan.kepemilikan.rumah.rasio') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            $('#persentaseMilikSendiri').html(data.persentase_milik_sendiri);
                            $('#persentaseMilikSendiriPercent').removeClass('d-none');
                            $('#persentaseTidakMilikSendiri').html(data.persentase_tidak_milik_sendiri);
                            $('#persentaseTidakMilikSendiriPercent').removeClass('d-none');
                            $('#rasioKepemilikan').html(data.rasio_kepemilikan);
                            $('#rasioKepemilikanSuffix').removeClass('d-none');
                        }
                    }
                });

                // 3. Distribusi Kepemilikan
                $.ajax({
                    url: '{{ route('kecamatan.kepemilikan.rumah.distribusi') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderDoughnutChart('chartKepemilikan', 'Kepemilikan', response.data, colors
                                .mixed);
                        }
                    }
                });

                // 4. Distribusi Jenis Kelamin
                $.ajax({
                    url: '{{ route('kecamatan.kepemilikan.rumah.jenkel') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderPieChart('chartJenkel', 'Jenis Kelamin', response.data, ['#007bff',
                                '#e83e8c'
                            ]);
                        }
                    }
                });

                // 5. Distribusi Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.kepemilikan.rumah.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartDesa', 'Per Desa', response.data, colors.mixed);
                        }
                    }
                });

                // 6. Distribusi Kelompok Umur
                $.ajax({
                    url: '{{ route('kecamatan.kepemilikan.rumah.umur') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartUmur', 'Kelompok Umur', response.data, colors.warning);
                        }
                    }
                });

                // 7. Kepemilikan Umur dan Jenis Kelamin
                $.ajax({
                    url: '{{ route('kecamatan.kepemilikan.rumah.umur.jenkel') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderGroupedBarChart('chartUmurJenkel', response.data);
                        }
                    }
                });

                // 8. Kepemilikan Berdasarkan Pendapatan
                $.ajax({
                    url: '{{ route('kecamatan.kepemilikan.rumah.pendapatan') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderStackedBarChart('chartPendapatan', response.data);
                        }
                    }
                });

                // 9. Detail Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.kepemilikan.rumah.detail.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderTableDetailDesa(response.data);
                        }
                    }
                });

                // 10. Kepemilikan Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.kepemilikan.rumah.kepemilikan.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderStackedBarChart('chartKepemilikanDesa', response.data);
                        }
                    }
                });

                // 11. Data Abnormal
                $.ajax({
                    url: '{{ route('kecamatan.kepemilikan.rumah.abnormal') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartAbnormal', 'Data Abnormal', response.data, colors
                                .danger);

                            // Update info boxes
                            $('#abnormalKepemilikanKosong').text(formatNumber(response.data[
                                'Kepemilikan Tidak Diisi'] || 0));
                            $('#abnormalKepalaOrangTua').text(formatNumber(response.data[
                                'Kepala KK Status Orang Tua'] || 0));
                            $('#abnormalUmurMuda').text(formatNumber(response.data[
                                'Kepala KK Umur < 18 Tahun'] || 0));
                            $('#abnormalPendapatanKosong').text(formatNumber(response.data[
                                'Pendapatan Tidak Diisi'] || 0));
                        }
                    }
                });

                // 12. Load List Desa dan Pendapatan
                $.ajax({
                    url: '{{ route('kecamatan.kepemilikan.rumah.list.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let options = '<option value="">-- Semua Desa --</option>';
                            response.data.forEach(function(desa) {
                                options += `<option value="${desa.code}">${desa.name}</option>`;
                            });
                            $('#filterDesa, #filterDesaAbnormal').html(options);
                        }
                    }
                });

                $.ajax({
                    url: '{{ route('kecamatan.kepemilikan.rumah.list.pendapatan') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let options = '<option value="">-- Semua Pendapatan --</option>';
                            response.data.forEach(function(pendapatan) {
                                options +=
                                    `<option value="${pendapatan}">${pendapatan}</option>`;
                            });
                            $('#filterPendapatan').html(options);

                            // Initialize select2
                            $('#filterDesa, #filterDesaAbnormal, #filterKepemilikan, #filterJenkel, #filterPendapatan, #filterKategoriAbnormal')
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
            initDataTableKepalaKeluarga();

            // Event handlers untuk filter Kepala Keluarga
            $('#btnFilter').on('click', function() {
                tableKepalaKeluarga.ajax.reload();
            });

            $('#btnResetFilter').on('click', function() {
                $('#filterDesa').val('').trigger('change');
                $('#filterKepemilikan').val('').trigger('change');
                $('#filterJenkel').val('').trigger('change');
                $('#filterPendapatan').val('').trigger('change');
                tableKepalaKeluarga.ajax.reload();
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
