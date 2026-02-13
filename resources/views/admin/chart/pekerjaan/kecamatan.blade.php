@extends('admin.layout.main')
@section('title', 'Statistik Pekerjaan')
@section('content-header', 'Statistik Pekerjaan Kecamatan')

@push('styles')
    <style>
        /* DataTables Custom Style */
        #tablePendudukPekerjaan {
            font-size: 0.9rem;
        }

        #tablePendudukPekerjaan thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        #tablePendudukPekerjaan tbody tr:hover {
            background-color: #f8f9fa;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.375rem 0.75rem;
            margin: 0 0.125rem;
            border-radius: 0.25rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(to bottom, #007bff 0%, #0056b3 100%);
            color: white !important;
            border: 1px solid #0056b3;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(to bottom, #0069d9 0%, #0056b3 100%);
            color: white !important;
            border: 1px solid #0056b3;
        }

        .small-box {
            border-radius: 0.25rem;
            position: relative;
            display: block;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .12), 0 1px 2px rgba(0, 0, 0, .24);
        }

        .small-box>.inner {
            padding: 10px;
        }

        .small-box>.small-box-footer {
            position: relative;
            text-align: center;
            padding: 3px 0;
            color: #fff;
            color: rgba(255, 255, 255, .8);
            display: block;
            z-index: 10;
            background: rgba(0, 0, 0, .1);
            text-decoration: none;
        }

        .small-box>.small-box-footer:hover {
            color: #fff;
            background: rgba(0, 0, 0, .15);
        }

        .small-box h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0 0 10px 0;
            white-space: nowrap;
            padding: 0;
        }

        .small-box p {
            font-size: 1rem;
        }

        .small-box .icon {
            transition: all .3s linear;
            position: absolute;
            top: -10px;
            right: 10px;
            z-index: 0;
            font-size: 90px;
            color: rgba(0, 0, 0, .15);
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
                                    <i class="fas fa-briefcase"></i>
                                </div>

                                <div class="ml-3">
                                    <h5 class="font-weight-bold mb-1">Ringkasan Statistik Pekerjaan</h5>
                                    <p class="stat-sublabel-premium mb-0">
                                        Data diperbarui secara otomatis berdasarkan database terkini
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

                <!-- Belum/Tidak Bekerja -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-user-times"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="belumBekerja">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Belum/Tidak Bekerja
                                        <i class="fas fa-user-times stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Menganggur</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mengurus Rumah Tangga -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-home"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="mengurusRumahTangga">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Mengurus Rumah Tangga
                                        <i class="fas fa-home stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">IRT</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pelajar/Mahasiswa -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-user-graduate"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="pelajarMahasiswa">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Pelajar/Mahasiswa
                                        <i class="fas fa-user-graduate stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Masih Belajar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bekerja -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-briefcase"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="bekerja">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Bekerja
                                        <i class="fas fa-briefcase stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Memiliki Pekerjaan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PNS/TNI/POLRI -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-primary text-white">
                                    <i class="fas fa-id-badge"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="pnsTniPolri">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        PNS/TNI/POLRI
                                        <i class="fas fa-id-badge stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">ASN</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Karyawan -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-user-tie"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="karyawan">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Karyawan
                                        <i class="fas fa-user-tie stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Swasta/BUMN/BUMD</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wiraswasta -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-store"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="wiraswasta">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Wiraswasta
                                        <i class="fas fa-store stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Pedagang/Usaha</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Petani -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-seedling"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="petani">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Petani
                                        <i class="fas fa-seedling stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Petani/Buruh Tani</p>
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

                <!-- Persentase Bekerja -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-percentage"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentaseBekerja">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentaseBekerjaPercent">%</span>
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

                <!-- Tingkat Partisipasi Kerja -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-tasks"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="tingkatPartisipasi">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="tingkatPartisipasiPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Tingkat Partisipasi
                                        <i class="fas fa-tasks stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Usia Produktif Bekerja</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tingkat Pengangguran -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="tingkatPengangguran">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="tingkatPengangguranPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Tingkat Pengangguran
                                        <i class="fas fa-exclamation-triangle stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Usia Produktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ANALISIS USIA PRODUKTIF -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h4 class="section-title text-success">
                        <i class="fas fa-users-cog mr-2"></i> Analisis Usia Produktif (15-64 Tahun)
                    </h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Analisis penduduk usia produktif dan status pekerjaan
                    </p>
                </div>

                <!-- Total Usia Produktif -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-success">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-users"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-success" id="usiaProduktifTotal">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Total Usia Produktif
                                        <i class="fas fa-users stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">
                                        15-64 tahun
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usia Produktif Bekerja -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-primary">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-primary text-white">
                                    <i class="fas fa-briefcase"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-primary" id="usiaProduktifBekerja">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Bekerja
                                        <i class="fas fa-briefcase stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">
                                        <span id="persenUsiaProduktifBekerja">0</span>% dari usia produktif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usia Produktif Tidak Bekerja -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-danger">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-user-times"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-danger" id="usiaProduktifTidakBekerja">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Tidak Bekerja
                                        <i class="fas fa-user-times stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium text-danger mb-0">
                                        <span id="persenUsiaProduktifTidakBekerja">0</span>% dari usia produktif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gender Ratio Usia Produktif -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-info">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-venus-mars"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-sublabel-premium mb-2">
                                        <i class="fas fa-male text-info mr-1"></i>
                                        <span id="usiaProduktifLaki">0</span> Laki-laki
                                    </p>
                                    <p class="stat-sublabel-premium mb-0">
                                        <i class="fas fa-female text-danger mr-1"></i>
                                        <span id="usiaProduktifPerempuan">0</span> Perempuan
                                    </p>
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

                <!-- Top 10 Pekerjaan -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Top 10 Pekerjaan Terbanyak</h3>
                                <p class="card-subtitle-premium">Jenis pekerjaan dengan jumlah terbanyak</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartTop10" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartTop10" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Status Pekerjaan -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Status Pekerjaan</h3>
                                <p class="card-subtitle-premium">Kategori status pekerjaan</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartStatus" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartStatus" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Jenis Kelamin -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-info">
                            <div class="card-header-icon">
                                <i class="fas fa-venus-mars"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Jenis Kelamin</h3>
                                <p class="card-subtitle-premium">Perbandingan laki-laki dan perempuan</p>
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

                <!-- Distribusi Per Desa -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-warning">
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

                <!-- Distribusi Kelompok Umur -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-purple">
                            <div class="card-header-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Kelompok Umur</h3>
                                <p class="card-subtitle-premium">Berdasarkan rentang usia</p>
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

                <!-- Pekerjaan Berdasarkan Kelompok Umur -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Pekerjaan vs Kelompok Umur</h3>
                                <p class="card-subtitle-premium">Status bekerja per kelompok umur produktif</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartPekerjaanUmur" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartPekerjaanUmur" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Penduduk Berdasarkan Umur dan Jenis Kelamin -->
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-info">
                            <div class="card-header-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Penduduk Berdasarkan Kelompok Umur dan Jenis Kelamin</h3>
                                <p class="card-subtitle-premium">Distribusi umur berdasarkan gender</p>
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
                            <canvas id="chartUmurJenkel" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Status Pekerjaan Per Desa -->
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Status Pekerjaan Per Desa</h3>
                                <p class="card-subtitle-premium">Perbandingan status pekerjaan di setiap desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartPekerjaanDesa" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartPekerjaanDesa" style="display:none; max-height: 400px;"></canvas>
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
                                <h3 class="card-title-premium">Detail Pekerjaan Per Desa</h3>
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
                                                <th width="12%">Desa</th>
                                                <th width="8%" class="text-center">Total</th>
                                                <th width="8%" class="text-center">Laki-laki</th>
                                                <th width="8%" class="text-center">Perempuan</th>
                                                <th width="8%" class="text-center">Tidak Bekerja</th>
                                                <th width="8%" class="text-center">Bekerja</th>
                                                <th width="9%" class="text-center">PNS/TNI/POLRI</th>
                                                <th width="8%" class="text-center">Karyawan</th>
                                                <th width="8%" class="text-center">Wiraswasta</th>
                                                <th width="8%" class="text-center">Petani</th>
                                                <th width="8%" class="text-center">IRT</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableDetailDesa" class="nowrap">
                                            <tr class="nowrap">
                                                <td colspan="12" class="py-4 text-center">
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


            <!-- ANALISIS PERLINDUNGAN ANAK & PEKERJA ANAK -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <div class="alert alert-warning border-left-warning">
                        <h5 class="alert-heading">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Analisis Perlindungan Anak & Identifikasi Pekerja Anak
                        </h5>
                        <p class="mb-0">
                            <strong>Catatan Penting:</strong> Data ini ditampilkan untuk <strong>identifikasi
                                masalah</strong> dan
                            <strong>tindak lanjut perlindungan anak</strong>, BUKAN untuk melegitimasi pekerja anak.
                            Setiap anak yang tercatat bekerja memerlukan pendampingan dan intervensi sesuai peraturan
                            perlindungan anak dan wajib belajar 12 tahun.
                        </p>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <h4 class="section-title text-danger">
                        <i class="fas fa-child mr-2"></i> Analisis Pekerja Anak (Usia < 15 Tahun) </h4>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Identifikasi anak di bawah usia 15 tahun yang
                                tercatat memiliki pekerjaan
                            </p>
                </div>

                <!-- Total Pekerja Anak -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-danger">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-danger" id="totalPekerjaAnak">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Total Pekerja Anak
                                        <i class="fas fa-exclamation-circle stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium text-danger mb-0">
                                        <span id="persenPekerjaAnak">0</span>% dari total anak
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usia < 10 Tahun (Prioritas Tinggi) -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-danger">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-baby"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-danger" id="pekerjaAnakDibawah10">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Usia < 10 Tahun <i class="fas fa-baby stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium text-danger mb-0">
                                        Prioritas Intervensi Tertinggi
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usia 10-14 Tahun -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-warning">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-child"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-warning" id="pekerjaAnak1014">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Usia 10-14 Tahun
                                        <i class="fas fa-child stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium text-warning mb-0">
                                        Perlu Pendampingan
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Indikator -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3" id="statusPekerjaAnakCard">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white" id="statusIcon">
                                    <i class="fas fa-check-circle"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-label-premium mb-2">
                                        Status Indikator
                                    </p>
                                    <h5 class="text-success mb-0" id="statusText">
                                        <span class="skeleton-premium skeleton-text-premium"></span>
                                    </h5>
                                    <p class="stat-sublabel-premium mb-0" id="statusDesc">
                                        Memuat data...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KESEJAHTERAAN ANAK PER KELOMPOK UMUR -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h4 class="section-title text-info">
                        <i class="fas fa-chart-line mr-2"></i> Kesejahteraan Anak per Kelompok Umur
                    </h4>
                </div>

                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-info">
                            <div class="card-header-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Analisis Kesejahteraan Anak</h3>
                                <p class="card-subtitle-premium">Status sekolah vs bekerja per kelompok umur</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartKesejahteraanAnak" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartKesejahteraanAnak" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JENIS PEKERJAAN YANG DILAKUKAN ANAK-ANAK -->
            <div class="row mb-4" id="sectionJenisPekerjaanAnak" style="display: none;">
                <div class="col-12 mb-3">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Perhatian:</strong> Ditemukan anak-anak yang tercatat bekerja. Data jenis pekerjaan di bawah
                        ini untuk keperluan <strong>analisis dan tindak lanjut perlindungan anak</strong>.
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Jenis Pekerjaan Anak-anak</h3>
                                <p class="card-subtitle-premium">Untuk identifikasi sektor yang perlu intervensi</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartJenisPekerjaanAnak" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartJenisPekerjaanAnak" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-warning">
                            <div class="card-header-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Pekerja Anak Per Desa</h3>
                                <p class="card-subtitle-premium">Identifikasi wilayah prioritas intervensi</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartPekerjaAnakDesa" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartPekerjaAnakDesa" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INDIKATOR KESEJAHTERAAN ANAK PER DESA -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon">
                                <i class="fas fa-table"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Indikator Kesejahteraan Anak Per Desa</h3>
                                <p class="card-subtitle-premium">Scoring untuk identifikasi wilayah yang perlu perhatian
                                </p>
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
                                                <th width="10%" class="text-center">Total Anak<br />(7-15 th)</th>
                                                <th width="10%" class="text-center">Sekolah</th>
                                                <th width="10%" class="text-center">Pekerja Anak</th>
                                                <th width="12%" class="text-center">Partisipasi<br />Sekolah</th>
                                                <th width="12%" class="text-center">% Pekerja<br />Anak</th>
                                                <th width="10%" class="text-center">Score</th>
                                                <th width="18%" class="text-center">Kategori</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableIndikatorKesejahteraanAnak" class="nowrap">
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

            <!-- DATATABLE DETAIL PEKERJA ANAK UNTUK TINDAK LANJUT -->
            <div class="row mb-4" id="sectionDataTablePekerjaAnak" style="display: none;">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-list-alt"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Data Lengkap Pekerja Anak untuk Tindak Lanjut</h3>
                                <p class="card-subtitle-premium">Daftar anak yang perlu pendampingan dan intervensi segera
                                </p>
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
                                    <li>Koordinasi dengan Dinas Sosial & P3A</li>
                                    <li>Pendampingan kembali ke sekolah</li>
                                    <li>Bantuan ekonomi keluarga jika diperlukan</li>
                                    <li>Monitoring berkala</li>
                                </ul>
                            </div>

                            <!-- Filter Section -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filterDesaPekerjaAnak">
                                            <i class="fas fa-map-marker-alt mr-1"></i> Filter Desa
                                        </label>
                                        <select class="form-control select2" id="filterDesaPekerjaAnak"
                                            style="width: 100%;">
                                            <option value="">-- Semua Desa --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filterJenkelPekerjaAnak">
                                            <i class="fas fa-venus-mars mr-1"></i> Jenis Kelamin
                                        </label>
                                        <select class="form-control select2" id="filterJenkelPekerjaAnak"
                                            style="width: 100%;">
                                            <option value="">-- Semua --</option>
                                            <option value="1">Laki-laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filterKelompokUmurAnak">
                                            <i class="fas fa-calendar mr-1"></i> Kelompok Umur
                                        </label>
                                        <select class="form-control select2" id="filterKelompokUmurAnak"
                                            style="width: 100%;">
                                            <option value="">-- Semua Umur --</option>
                                            <option value="0-9">0-9 Tahun (Prioritas Tinggi)</option>
                                            <option value="10-14">10-14 Tahun</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-danger flex-grow-1 mr-2"
                                                id="btnFilterPekerjaAnak">
                                                <i class="fas fa-search mr-1"></i> Filter
                                            </button>
                                            <button type="button" class="btn btn-secondary flex-grow-1"
                                                id="btnResetFilterPekerjaAnak">
                                                <i class="fas fa-redo mr-1"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- DataTable -->
                            <div class="table-responsive">
                                <table class="table-bordered table-hover table" id="tablePekerjaAnak" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="10%">Desa</th>
                                            <th width="12%">NIK</th>
                                            <th width="15%">Nama</th>
                                            <th width="8%" class="text-center">JK</th>
                                            <th width="7%" class="text-center">Umur</th>
                                            <th width="10%" class="text-center">Tgl Lahir</th>
                                            <th width="8%" class="text-center">RT/RW</th>
                                            <th width="15%">Pekerjaan</th>
                                            <th width="10%" class="text-center">Tingkat Bahaya</th>
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
                                <h3 class="card-title-premium">Data Lengkap Penduduk dan Pekerjaan</h3>
                                <p class="card-subtitle-premium">Daftar detail seluruh penduduk dengan informasi pekerjaan
                                </p>
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
                                        <label for="filterStatusPekerjaan">
                                            <i class="fas fa-briefcase mr-1"></i> Status Pekerjaan
                                        </label>
                                        <select class="form-control select2" id="filterStatusPekerjaan"
                                            style="width: 100%;">
                                            <option value="">-- Semua Status --</option>
                                            <option value="bekerja">Bekerja</option>
                                            <option value="tidak_bekerja">Tidak Bekerja</option>
                                            <option value="irt">Mengurus Rumah Tangga</option>
                                            <option value="pelajar">Pelajar/Mahasiswa</option>
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
                                <table class="table-bordered table-hover table" id="tablePendudukPekerjaan"
                                    style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="10%">Desa</th>
                                            <th width="13%">NIK</th>
                                            <th width="18%">Nama</th>
                                            <th width="10%" class="text-center">Jenis Kelamin</th>
                                            <th width="8%" class="text-center">Umur</th>
                                            <th width="10%" class="text-center">Tgl Lahir</th>
                                            <th width="10%" class="text-center">Kategori Usia</th>
                                            <th width="8%" class="text-center">RT/RW</th>
                                            <th width="18%">Pekerjaan</th>
                                            <th width="10%" class="text-center">Status</th>
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
            let tablePekerjaAnak;
            let tablePenduduk;

            const colors = {
                primary: ['#007bff', '#0056b3', '#004085', '#6610f2', '#6f42c1'],
                success: ['#28a745', '#20c997', '#17a2b8', '#138496', '#117a8b'],
                warning: ['#ffc107', '#ff9800', '#ff5722', '#e91e63', '#f44336'],
                info: ['#17a2b8', '#20c997', '#6610f2', '#007bff', '#6c757d'],
                danger: ['#dc3545', '#c82333', '#bd2130', '#a71d2a', '#8b0000'],
                purple: ['#6f42c1', '#5a32a3', '#452586', '#563d7c', '#6610f2'],
                mixed: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2', '#fd7e14', '#20c997',
                    '#e83e8c', '#6c757d', '#343a40'
                ],
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

            function renderPekerjaanUmurChart(data) {
                const ctx = document.getElementById('chartPekerjaanUmur');
                if (charts['chartPekerjaanUmur']) charts['chartPekerjaanUmur'].destroy();

                const labels = data.map(item => item.label);
                const dataBekerja = data.map(item => item.bekerja);
                const dataTidakBekerja = data.map(item => item.tidak_bekerja);

                charts['chartPekerjaanUmur'] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Bekerja',
                                data: dataBekerja,
                                backgroundColor: '#28a745',
                                borderColor: '#28a745',
                                borderWidth: 1
                            },
                            {
                                label: 'Tidak Bekerja',
                                data: dataTidakBekerja,
                                backgroundColor: '#dc3545',
                                borderColor: '#dc3545',
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
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
                hideChartLoading('chartPekerjaanUmur');
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
                                <span class="badge badge-secondary badge-stat">${formatNumber(item.tidak_bekerja)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success badge-stat">${formatNumber(item.bekerja)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary badge-stat">${formatNumber(item.pns_tni_polri)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info badge-stat">${formatNumber(item.karyawan)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-warning badge-stat">${formatNumber(item.wiraswasta)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success badge-stat">${formatNumber(item.petani)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info badge-stat">${formatNumber(item.irt)}</span>
                            </td>
                        </tr>
                    `;
                });

                if (html === '') {
                    html = '<tr><td colspan="12" class="text-center text-muted py-4">Tidak ada data</td></tr>';
                }

                $('#tableDetailDesa').html(html);
            }

            function renderChartKesejahteraanAnak(data) {
                const ctx = document.getElementById('chartKesejahteraanAnak');
                if (charts['chartKesejahteraanAnak']) charts['chartKesejahteraanAnak'].destroy();

                const labels = data.map(item => item.label);
                const dataSekolah = data.map(item => item.sekolah);
                const dataBekerja = data.map(item => item.bekerja);
                const dataTidakSekolahTidakBekerja = data.map(item => item.tidak_bekerja_tidak_sekolah);

                charts['chartKesejahteraanAnak'] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Sekolah (Normal)',
                                data: dataSekolah,
                                backgroundColor: '#28a745',
                                borderColor: '#28a745',
                                borderWidth: 1
                            },
                            {
                                label: 'Bekerja (Perlu Intervensi)',
                                data: dataBekerja,
                                backgroundColor: '#dc3545',
                                borderColor: '#dc3545',
                                borderWidth: 1
                            },
                            {
                                label: 'Tidak Sekolah & Tidak Bekerja',
                                data: dataTidakSekolahTidakBekerja,
                                backgroundColor: '#ffc107',
                                borderColor: '#ffc107',
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
                                        const dataIndex = context.dataIndex;
                                        const item = data[dataIndex];
                                        let label = context.dataset.label + ': ' + formatNumber(context
                                            .parsed.y) + ' anak';

                                        if (context.datasetIndex === 0) {
                                            label += ' (' + item.persen_sekolah + '%)';
                                        } else if (context.datasetIndex === 1 && item.persen_bekerja) {
                                            label += ' (' + item.persen_bekerja + '%)';
                                        }

                                        return label;
                                    },
                                    afterLabel: function(context) {
                                        const dataIndex = context.dataIndex;
                                        const item = data[dataIndex];

                                        if (item.status === 'perlu_perhatian') {
                                            return '⚠️ PERLU PERHATIAN';
                                        }
                                        return '';
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
                                }
                            }
                        }
                    }
                });
                hideChartLoading('chartKesejahteraanAnak');
            }

            function renderChartPekerjaAnakPerDesa(data) {
                const ctx = document.getElementById('chartPekerjaAnakDesa');
                if (charts['chartPekerjaAnakDesa']) charts['chartPekerjaAnakDesa'].destroy();

                const dataFiltered = data.filter(item => item.pekerja_anak > 0);

                if (dataFiltered.length === 0) {
                    $('#chartPekerjaAnakDesa').parent().html(
                        '<div class="text-center py-4"><i class="fas fa-check-circle text-success fa-3x mb-3"></i><h5 class="text-success">Tidak ada pekerja anak terdeteksi</h5><p class="text-muted">Semua desa dalam kondisi aman</p></div>'
                    );
                    return;
                }

                const labels = dataFiltered.map(item => item.desa);
                const dataPekerjaAnak = dataFiltered.map(item => item.pekerja_anak);
                const backgroundColors = dataFiltered.map(item => {
                    if (item.tingkat_risiko === 'Tinggi') return '#dc3545';
                    if (item.tingkat_risiko === 'Sedang') return '#ffc107';
                    return '#17a2b8';
                });

                charts['chartPekerjaAnakDesa'] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Pekerja Anak',
                            data: dataPekerjaAnak,
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
                                callbacks: {
                                    label: function(context) {
                                        const index = context.dataIndex;
                                        const item = dataFiltered[index];
                                        return [
                                            'Pekerja Anak: ' + formatNumber(item.pekerja_anak) +
                                            ' anak',
                                            'Total Anak: ' + formatNumber(item.total_anak),
                                            'Tingkat Risiko: ' + item.tingkat_risiko
                                        ];
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
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45
                                }
                            }
                        }
                    }
                });
                hideChartLoading('chartPekerjaAnakDesa');
            }

            function renderTableIndikatorKesejahteraanAnak(data) {
                let html = '';

                data.forEach((item, index) => {
                    html += `
                        <tr>
                            <td class="font-weight-bold">${index + 1}</td>
                            <td>
                                <i class="fas fa-map-marker-alt text-${item.warna} mr-2"></i>
                                <strong>${item.desa}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary badge-stat">${formatNumber(item.total_anak_wajib_belajar)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success badge-stat">${formatNumber(item.sekolah)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-danger badge-stat">${formatNumber(item.pekerja_anak)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-${item.angka_partisipasi_sekolah >= 95 ? 'success' : item.angka_partisipasi_sekolah >= 90 ? 'warning' : 'danger'} badge-stat">
                                    ${item.angka_partisipasi_sekolah}%
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-${item.pekerja_anak == 0 ? 'success' : 'danger'} badge-stat">
                                    ${item.angka_pekerja_anak}%
                                </span>
                            </td>
                            <td class="text-center">
                                <strong class="text-${item.warna}">${item.score}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-${item.warna} badge-lg">
                                    ${item.kategori}
                                </span>
                            </td>
                        </tr>
                    `;
                });

                if (html === '') {
                    html = '<tr><td colspan="9" class="text-center text-muted py-4">Tidak ada data</td></tr>';
                }

                $('#tableIndikatorKesejahteraanAnak').html(html);
            }

            // Initialize DataTable Pekerja Anak
            function initDataTablePekerjaAnak() {
                if ($.fn.DataTable.isDataTable('#tablePekerjaAnak')) {
                    $('#tablePekerjaAnak').DataTable().destroy();
                }

                tablePekerjaAnak = $('#tablePekerjaAnak').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('kecamatan.pekerjaan.datatable.pekerja.anak') }}',
                        type: 'GET',
                        data: function(d) {
                            d.desa = $('#filterDesaPekerjaAnak').val();
                            d.jenkel = $('#filterJenkelPekerjaAnak').val();
                            d.kelompok_umur = $('#filterKelompokUmurAnak').val();
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
                            data: 'pekerjaan',
                            name: 'pekerjaan'
                        },
                        {
                            data: 'tingkat_bahaya',
                            name: 'tingkat_bahaya',
                            orderable: false,
                            className: 'text-center'
                        }
                    ],
                    order: [
                        [5, 'asc']
                    ],
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "Semua"]
                    ],
                    language: {
                        processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
                        search: '<i class="fas fa-search"></i>',
                        searchPlaceholder: 'Cari data...',
                        lengthMenu: 'Tampilkan _MENU_ data',
                        info: 'Menampilkan _START_ - _END_ dari _TOTAL_ anak',
                        infoEmpty: 'Tidak ada data',
                        infoFiltered: '(difilter dari _MAX_ total)',
                        zeroRecords: '<div class="alert alert-success"><i class="fas fa-check-circle fa-3x mb-3"></i><h5>Tidak ada pekerja anak</h5><p>Semua anak dalam kondisi normal</p></div>',
                        emptyTable: '<div class="alert alert-info"><i class="fas fa-info-circle fa-3x mb-3"></i><h5>Tidak ada data</h5></div>',
                        paginate: {
                            first: '<<',
                            last: '>>',
                            next: '>',
                            previous: '<'
                        }
                    },
                    responsive: false,
                    autoWidth: false,
                    drawCallback: function(settings) {
                        console.log('DataTable drawn with ' + settings.json.recordsTotal + ' records');
                    }
                });
            }

            // Initialize DataTable Penduduk
            function initDataTablePenduduk() {
                if ($.fn.DataTable.isDataTable('#tablePendudukPekerjaan')) {
                    $('#tablePendudukPekerjaan').DataTable().destroy();
                }

                tablePenduduk = $('#tablePendudukPekerjaan').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('kecamatan.pekerjaan.datatable') }}',
                        data: function(d) {
                            d.desa = $('#filterDesa').val();
                            d.status_pekerjaan = $('#filterStatusPekerjaan').val();
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
                            data: 'kategori_usia',
                            name: 'kategori_usia',
                            orderable: false,
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
                            data: 'pekerjaan',
                            name: 'pekerjaan'
                        },
                        {
                            data: 'status_bekerja',
                            name: 'status_bekerja',
                            orderable: false,
                            className: 'text-center'
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

            // Load Filter Desa Pekerja Anak
            function loadFilterDesaPekerjaAnak() {
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.list.desa.pekerja.anak') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let options = '<option value="">-- Semua Desa --</option>';
                            response.data.forEach(function(desa) {
                                options += `<option value="${desa.code}">${desa.name}</option>`;
                            });
                            $('#filterDesaPekerjaAnak').html(options);
                        }
                    }
                });
            }

            // PARALLEL LOADING - Load All Data
            function loadAllData() {
                // 1. Load Statistik Jumlah
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.jumlah') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            animateNumber('#totalPenduduk', data.total_penduduk);
                            animateNumber('#totalLaki', data.total_laki);
                            animateNumber('#totalPerempuan', data.total_perempuan);
                            animateNumber('#belumBekerja', data.belum_bekerja);
                            animateNumber('#mengurusRumahTangga', data.mengurus_rumah_tangga);
                            animateNumber('#pelajarMahasiswa', data.pelajar_mahasiswa);
                            animateNumber('#bekerja', data.bekerja);
                            animateNumber('#pnsTniPolri', data.pns_tni_polri);
                            animateNumber('#karyawan', data.karyawan);
                            animateNumber('#wiraswasta', data.wiraswasta);
                            animateNumber('#petani', data.petani);
                        }
                    }
                });

                // 2. Load Statistik Rasio
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.rasio') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            $('#persentaseBekerja').html(data.persentase_bekerja);
                            $('#persentaseBekerjaPercent').removeClass('d-none');
                            $('#persentaseTidakBekerja').html(data.persentase_tidak_bekerja);
                            $('#persentaseTidakBekerjaPercent').removeClass('d-none');
                            $('#tingkatPartisipasi').html(data.tingkat_partisipasi_kerja);
                            $('#tingkatPartisipasiPercent').removeClass('d-none');
                            $('#tingkatPengangguran').html(data.tingkat_pengangguran);
                            $('#tingkatPengangguranPercent').removeClass('d-none');
                        }
                    }
                });

                // 3. Load Top 10 Pekerjaan
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.top10') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const chartData = {};
                            response.data.forEach(function(item) {
                                chartData[item.pekerjaan] = item.jumlah;
                            });
                            renderBarChart('chartTop10', 'Top 10 Pekerjaan', chartData, colors.mixed);
                        }
                    }
                });

                // 4. Load Status Pekerjaan
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.status') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderDoughnutChart('chartStatus', 'Status Pekerjaan', response.data, colors
                                .mixed);
                        }
                    }
                });

                // 5. Load Chart Jenis Kelamin
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.jenkel') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderPieChart('chartJenkel', 'Jenis Kelamin', response.data, ['#007bff',
                                '#e83e8c'
                            ]);
                        }
                    }
                });

                // 6. Load Chart Desa
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartDesa', 'Distribusi Per Desa', response.data, colors
                                .mixed);
                        }
                    }
                });

                // 7. Load Chart Umur
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.umur') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartUmur', 'Kelompok Umur', response.data, colors.warning);
                        }
                    }
                });

                // 8. Load Chart Umur dan Jenis Kelamin
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.umur.jenkel') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderGroupedBarChart('chartUmurJenkel', response.data);
                        }
                    }
                });

                // 9. Load Table Detail Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.detail.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderTableDetailDesa(response.data);
                        }
                    }
                });

                // 10. Load Analisa Usia Produktif
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.analisa.usia.produktif') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            animateNumber('#usiaProduktifTotal', data.total_usia_produktif);
                            animateNumber('#usiaProduktifBekerja', data.bekerja);
                            animateNumber('#usiaProduktifTidakBekerja', data.tidak_bekerja);

                            $('#persenUsiaProduktifBekerja').text(data.persentase_bekerja);
                            $('#persenUsiaProduktifTidakBekerja').text(data.persentase_tidak_bekerja);
                            $('#usiaProduktifLaki').text(formatNumber(data.laki_laki));
                            $('#usiaProduktifPerempuan').text(formatNumber(data.perempuan));
                        }
                    }
                });

                // 11. Load Chart Pekerjaan Berdasarkan Umur
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.umur.kerja') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderPekerjaanUmurChart(response.data);
                        }
                    }
                });

                // 12. Load Chart Pekerjaan Per Desa (Stacked)
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.desa.stacked') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderStackedBarChart('chartPekerjaanDesa', response.data);
                        }
                    }
                });

                // 13. Load List Desa untuk Filter Penduduk
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.list.desa') }}',
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
                                placeholder: '-- Semua Desa --',
                                allowClear: true
                            });
                        }
                    }
                });

                // 14. Load Analisis Pekerja Anak
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.analisis.pekerja.anak') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;

                            animateNumber('#totalPekerjaAnak', data.total_pekerja_anak);
                            animateNumber('#pekerjaAnakDibawah10', data.usia_di_bawah_10);
                            animateNumber('#pekerjaAnak1014', data.usia_10_14);
                            $('#persenPekerjaAnak').text(data.persentase);

                            const statusCard = $('#statusPekerjaAnakCard');
                            const statusIcon = $('#statusIcon');
                            const statusText = $('#statusText');
                            const statusDesc = $('#statusDesc');

                            if (data.status === 'aman') {
                                statusCard.removeClass('border-danger border-warning').addClass(
                                    'border-success');
                                statusIcon.removeClass('icon-danger icon-warning').addClass(
                                    'icon-success');
                                statusIcon.find('i').removeClass(
                                    'fa-exclamation-triangle fa-exclamation-circle').addClass(
                                    'fa-check-circle');
                                statusText.removeClass('text-danger text-warning').addClass(
                                    'text-success');
                                statusText.text('Aman');
                                statusDesc.text('Tidak ada pekerja anak terdeteksi');
                            } else {
                                statusCard.removeClass('border-success border-warning').addClass(
                                    'border-danger');
                                statusIcon.removeClass('icon-success icon-warning').addClass(
                                    'icon-danger');
                                statusIcon.find('i').removeClass(
                                    'fa-check-circle fa-exclamation-triangle').addClass(
                                    'fa-exclamation-circle');
                                statusText.removeClass('text-success text-warning').addClass(
                                    'text-danger');
                                statusText.text('Perlu Perhatian');
                                statusDesc.text('Ada anak yang tercatat bekerja');

                                $('#sectionJenisPekerjaanAnak').show();
                                $('#sectionDataTablePekerjaAnak').show();

                                setTimeout(function() {
                                    initDataTablePekerjaAnak();
                                    loadFilterDesaPekerjaAnak();
                                }, 500);
                            }
                        }
                    }
                });

                // 15. Load Chart Kesejahteraan Anak
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.kesejahteraan.anak') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderChartKesejahteraanAnak(response.data);
                        }
                    }
                });

                // 16. Load Jenis Pekerjaan Anak
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.jenis.pekerjaan.anak') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success && Object.keys(response.data).length > 0) {
                            renderBarChart('chartJenisPekerjaanAnak', 'Jenis Pekerjaan Anak', response
                                .data, colors.danger);
                        }
                    }
                });

                // 17. Load Pekerja Anak Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.pekerja.anak.per.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderChartPekerjaAnakPerDesa(response.data);
                        }
                    }
                });

                // 18. Load Indikator Kesejahteraan Anak
                $.ajax({
                    url: '{{ route('kecamatan.pekerjaan.indikator.kesejahteraan.anak') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderTableIndikatorKesejahteraanAnak(response.data);
                        }
                    }
                });

                // Initialize Select2 untuk filter lainnya
                $('#filterStatusPekerjaan').select2({
                    theme: 'bootstrap4',
                    placeholder: '-- Semua Status --',
                    allowClear: true
                });

                $('#filterJenkel').select2({
                    theme: 'bootstrap4',
                    placeholder: '-- Semua --',
                    allowClear: true
                });

                $('#filterDesaPekerjaAnak').select2({
                    theme: 'bootstrap4',
                    placeholder: '-- Semua Desa --',
                    allowClear: true
                });

                $('#filterJenkelPekerjaAnak, #filterKelompokUmurAnak').select2({
                    theme: 'bootstrap4',
                    placeholder: '-- Semua --',
                    allowClear: true
                });
            }

            // Initialize DataTable Penduduk
            initDataTablePenduduk();

            // Event handlers untuk filter Penduduk
            $('#btnFilter').on('click', function() {
                tablePenduduk.ajax.reload();
            });

            $('#btnResetFilter').on('click', function() {
                $('#filterDesa').val('').trigger('change');
                $('#filterStatusPekerjaan').val('').trigger('change');
                $('#filterJenkel').val('').trigger('change');
                tablePenduduk.ajax.reload();
            });

            // Event handlers untuk filter Pekerja Anak
            $('#btnFilterPekerjaAnak').on('click', function() {
                if (tablePekerjaAnak) {
                    tablePekerjaAnak.ajax.reload();
                }
            });

            $('#btnResetFilterPekerjaAnak').on('click', function() {
                $('#filterDesaPekerjaAnak').val('').trigger('change');
                $('#filterJenkelPekerjaAnak').val('').trigger('change');
                $('#filterKelompokUmurAnak').val('').trigger('change');
                if (tablePekerjaAnak) {
                    tablePekerjaAnak.ajax.reload();
                }
            });

            // Load all data
            loadAllData();
        });
    </script>
@endpush
