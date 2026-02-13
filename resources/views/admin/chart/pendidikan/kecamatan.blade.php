@extends('admin.layout.main')
@section('title', 'Statistik Pendidikan')
@section('content-header', 'Statistik Pendidikan Kecamatan')

@push('styles')
    <style>
        /* DataTables Custom Style */
        #tableTidakSekolahWajibBelajar {
            font-size: 0.9rem;
        }

        #tableTidakSekolahWajibBelajar thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        #tableTidakSekolahWajibBelajar tbody tr:hover {
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
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-12">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-2">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-primary text-white">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>

                                <div class="ml-3">
                                    <h5 class="font-weight-bold mb-1">Ringkasan Statistik Pendidikan</h5>
                                    <p class="stat-sublabel-premium mb-0">
                                        Data diperbarui secara otomatis berdasarkan database terkini
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


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

                <!-- Tidak/Belum Sekolah -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-secondary text-white">
                                    <i class="fas fa-times-circle"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="tidakSekolah">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Tidak/Belum Sekolah
                                        <i class="fas fa-times-circle stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Belum Bersekolah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendidikan Dasar -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-book"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="pendidikanDasar">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Pendidikan Dasar
                                        <i class="fas fa-book stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">SD/Sederajat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendidikan Menengah -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-school"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="pendidikanMenengah">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Pendidikan Menengah
                                        <i class="fas fa-school stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">SMP/SMA</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendidikan Tinggi -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-university"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="pendidikanTinggi">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Pendidikan Tinggi
                                        <i class="fas fa-university stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Diploma/Sarjana</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Putus Sekolah -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="putusSekolah">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Putus Sekolah
                                        <i class="fas fa-exclamation-triangle stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Drop Out</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- STATISTIK STATUS SEDANG SEKOLAH -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h4 class="section-title text-success">
                        <i class="fas fa-user-graduate mr-2"></i> Status Sedang Bersekolah
                    </h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Data penduduk yang sedang menempuh pendidikan
                    </p>
                </div>

                <!-- Sedang TK/PAUD -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-purple text-white">
                                    <i class="fas fa-child"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="sedangTK">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Sedang TK/PAUD
                                        <i class="fas fa-child stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Anak Usia Dini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sedang SD -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-book-reader"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="sedangSD">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Sedang SD
                                        <i class="fas fa-book-reader stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Sekolah Dasar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sedang SMP -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-user-graduate"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="sedangSMP">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Sedang SMP
                                        <i class="fas fa-user-graduate stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Sekolah Menengah Pertama</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sedang SMA -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-primary text-white">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="sedangSMA">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Sedang SMA
                                        <i class="fas fa-graduation-cap stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Sekolah Menengah Atas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sedang Kuliah -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-user-tie"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="sedangKuliah">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Sedang Kuliah
                                        <i class="fas fa-user-tie stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Perguruan Tinggi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row mb-4">

                <div class="col-12 mb-3">
                    <h4 class="section-title">
                        <i class="fas fa-chart-pie mr-2"></i> Statistik Rasio
                    </h4>
                </div>

                <!-- Persentase Pendidikan Tinggi -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-percentage"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentasePendidikanTinggi">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentasePendidikanTinggiPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        % Pendidikan Tinggi
                                        <i class="fas fa-percentage stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Persentase Putus Sekolah -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-chart-line"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentasePutusSekolah">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentasePutusSekolahPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        % Putus Sekolah
                                        <i class="fas fa-chart-line stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Persentase Tidak Sekolah -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-tasks"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentaseTidakSekolah">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentaseTidakSekolahPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        % Tidak Sekolah
                                        <i class="fas fa-tasks stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ANALISIS KEWAJARAN USIA SEKOLAH -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h4 class="section-title text-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i> Analisis Kewajaran Usia Sekolah (Wajib Belajar 9
                        Tahun)
                    </h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Analisis kesesuaian antara usia dan jenjang pendidikan
                        sesuai program wajib belajar
                    </p>
                </div>

                <!-- Usia SD (7-12 tahun) -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-warning">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-child"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-warning" id="usiaSDTotal">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Usia SD (7-12 th)
                                        <i class="fas fa-child stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">
                                        <span id="usiaSDSekolah">0</span> sedang sekolah
                                        (<span id="persentaseSDSekolah">0</span>%)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usia SMP (13-15 tahun) -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-info">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-user-graduate"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-info" id="usiaSMPTotal">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Usia SMP (13-15 th)
                                        <i class="fas fa-user-graduate stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">
                                        <span id="usiaSMPSekolah">0</span> sedang sekolah
                                        (<span id="persentaseSMPSekolah">0</span>%)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usia SMA (16-18 tahun) -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-primary">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-primary text-white">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-primary" id="usiaSMATotal">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Usia SMA (16-18 th)
                                        <i class="fas fa-graduation-cap stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">
                                        <span id="usiaSMASekolah">0</span> sedang sekolah
                                        (<span id="persentaseSMASekolah">0</span>%)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tidak Sekolah Usia Wajib Belajar -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-danger">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-danger" id="wajibBelajarTidakSekolah">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Tidak Sekolah
                                        <i class="fas fa-exclamation-triangle stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium text-danger mb-0">Usia 7-15 th (Wajib Belajar)</p>
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
                        <i class="fas fa-chart-bar mr-2"></i> Statistik Distribusi
                    </h4>
                </div>
                <!-- Kesesuaian Usia Sekolah Per Desa -->
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Kesesuaian Usia Sekolah Per Desa</h3>
                                <p class="card-subtitle-premium">Monitoring anak usia sekolah yang bersekolah per desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartKesesuaianUsia" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartKesesuaianUsia" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Distribusi Tingkat Pendidikan -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Tingkat Pendidikan</h3>
                                <p class="card-subtitle-premium">Berdasarkan jenjang pendidikan</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartTingkat" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartTingkat" style="display:none; max-height: 350px;"></canvas>
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
                        <div class="card-header-premium bg-gradient-success">
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

                <!-- Distribusi Berdasarkan Umur -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-warning">
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

                <!-- Status Sedang Sekolah -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Status Sedang Sekolah</h3>
                                <p class="card-subtitle-premium">Berdasarkan jenjang yang sedang ditempuh</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartSedangSekolah" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartSedangSekolah" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pendidikan Non Formal -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-purple">
                            <div class="card-header-icon">
                                <i class="fas fa-mosque"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Pendidikan Non Formal</h3>
                                <p class="card-subtitle-premium">Pendidikan keagamaan dan lainnya</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartNonFormal" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartNonFormal" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pendidikan Berdasarkan Umur dan Jenis Kelamin -->
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

            </div>

            <!-- Tabel Detail Tidak Sekolah di Usia Wajib Belajar -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Detail Anak Tidak Sekolah di Usia Wajib Belajar (7-15 Tahun)
                                </h3>
                                <p class="card-subtitle-premium">Daftar lengkap anak yang tidak bersekolah di usia wajib
                                    belajar 9 tahun</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <!-- Summary Cards -->
                            <div class="row mb-3">
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3 id="summaryTotal">
                                                <span class="spinner-border spinner-border-sm"></span>
                                            </h3>
                                            <p>Total Tidak Sekolah</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3 id="summaryUsiaSD">
                                                <span class="spinner-border spinner-border-sm"></span>
                                            </h3>
                                            <p>Usia SD (7-12 th)</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-child"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3 id="summaryUsiaSMP">
                                                <span class="spinner-border spinner-border-sm"></span>
                                            </h3>
                                            <p>Usia SMP (13-15 th)</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-user-graduate"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="alert alert-danger">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Perhatian:</strong> Data ini menampilkan anak usia 7-15 tahun yang tidak bersekolah.
                                Perlu pendampingan dan intervensi khusus sesuai program wajib belajar 9 tahun.
                            </div>

                            <!-- Filter Section -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="filterDesa">
                                            <i class="fas fa-map-marker-alt mr-1"></i> Filter Berdasarkan Desa
                                        </label>
                                        <select class="form-control select2" id="filterDesa" style="width: 100%;">
                                            <option value="">-- Semua Desa --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-primary btn-block" id="btnFilter">
                                            <i class="fas fa-search mr-1"></i> Terapkan Filter
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-secondary btn-block" id="btnResetFilter">
                                            <i class="fas fa-redo mr-1"></i> Reset Filter
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- DataTable -->
                            <div class="table-responsive">
                                <table class="table-bordered table-hover table" id="tableTidakSekolahWajibBelajar"
                                    style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="12%">Desa</th>
                                            <th width="13%">NIK</th>
                                            <th width="18%">Nama</th>
                                            <th width="10%" class="text-center">Jenis Kelamin</th>
                                            <th width="8%" class="text-center">Umur</th>
                                            <th width="10%" class="text-center">Tgl Lahir</th>
                                            <th width="12%" class="text-center">Kategori Usia</th>
                                            <th width="8%" class="text-center">RT/RW</th>
                                            <th width="14%">Status Pendidikan</th>
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

            <!-- Tabel Detail Per Desa -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon">
                                <i class="fas fa-table"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Detail Pendidikan Per Desa</h3>
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
                                                <th width="9%" class="text-center">Tidak Sekolah</th>
                                                <th width="8%" class="text-center">SD</th>
                                                <th width="8%" class="text-center">SMP</th>
                                                <th width="8%" class="text-center">SMA</th>
                                                <th width="8%" class="text-center">Diploma</th>
                                                <th width="9%" class="text-center">Sarjana</th>
                                                <th width="8%" class="text-center">Putus Sekolah</th>
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
                danger: ['#dc3545', '#c82333', '#bd2130', '#a71d2a', '#8b0000'],
                purple: ['#6f42c1', '#5a32a3', '#452586', '#563d7c', '#6610f2'],
                mixed: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2', '#fd7e14', '#20c997',
                    '#e83e8c', '#6c757d', '#343a40'
                ],
                desa: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2', '#fd7e14', '#20c997',
                    '#e83e8c', '#6c757d', '#343a40'
                ]
            };

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

            // PARALLEL LOADING - Semua request jalan bersamaan!
            function loadAllData() {
                // 1. Load Statistik Jumlah
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.jumlah') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            animateNumber('#totalPenduduk', data.total_penduduk);
                            animateNumber('#totalLaki', data.total_laki);
                            animateNumber('#totalPerempuan', data.total_perempuan);
                            animateNumber('#tidakSekolah', data.tidak_sekolah);
                            animateNumber('#pendidikanDasar', data.pendidikan_dasar);
                            animateNumber('#pendidikanMenengah', data.pendidikan_menengah);
                            animateNumber('#pendidikanTinggi', data.pendidikan_tinggi);
                            animateNumber('#sedangSD', data.sedang_sekolah_sd);
                            animateNumber('#sedangSMP', data.sedang_sekolah_smp);
                            animateNumber('#sedangSMA', data.sedang_sekolah_sma);
                            animateNumber('#sedangKuliah', data.sedang_kuliah);
                            animateNumber('#putusSekolah', data.putus_sekolah);
                        }
                    }
                });

                // 2. Load Statistik Rasio
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.rasio') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            $('#persentasePendidikanTinggi').html(data.persentase_pendidikan_tinggi);
                            $('#persentasePendidikanTinggiPercent').removeClass('d-none');
                            $('#persentasePutusSekolah').html(data.persentase_putus_sekolah);
                            $('#persentasePutusSekolahPercent').removeClass('d-none');
                            $('#persentaseTidakSekolah').html(data.persentase_tidak_sekolah);
                            $('#persentaseTidakSekolahPercent').removeClass('d-none');
                        }
                    }
                });

                // 3. Load Chart Tingkat Pendidikan
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.distribusi.tingkat') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartTingkat', 'Tingkat Pendidikan', response.data, colors
                                .mixed);
                        }
                    }
                });

                // 4. Load Chart Jenis Kelamin
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.distribusi.jenkel') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderPieChart('chartJenkel', 'Jenis Kelamin', response.data, ['#007bff',
                                '#e83e8c'
                            ]);
                        }
                    }
                });

                // 5. Load Chart Desa
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.distribusi.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartDesa', 'Distribusi Per Desa', response.data, colors
                                .desa);
                        }
                    }
                });

                // 6. Load Chart Umur
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.distribusi.umur') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartUmur', 'Kelompok Umur', response.data, colors.warning);
                        }
                    }
                });

                // 7. Load Chart Status Sedang Sekolah
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.status.sedang.sekolah') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderDoughnutChart('chartSedangSekolah', 'Status Sedang Sekolah', response
                                .data, colors.success);

                            // Update card numbers untuk sedang sekolah
                            if (response.data['Sedang TK/PAUD']) {
                                animateNumber('#sedangTK', response.data['Sedang TK/PAUD']);
                            }
                        }
                    }
                });

                // 8. Load Chart Pendidikan Non Formal
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.distribusi.non.formal') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderDoughnutChart('chartNonFormal', 'Pendidikan Non Formal', response
                                .data, colors.purple);
                        }
                    }
                });

                // 9. Load Chart Umur dan Jenis Kelamin
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.umur.jenkel') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderUmurJenkelChart(response.data);
                        }
                    }
                });

                // 10. Load Table Detail Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.detail.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderTableDetailDesa(response.data);
                        }
                    }
                });

                // 11. Load Analisa Usia Sekolah
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.analisa.usia.sekolah') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            animateNumber('#usiaSDTotal', data.usia_sd_total);
                            $('#usiaSDSekolah').text(formatNumber(data.usia_sd_sekolah));
                            $('#persentaseSDSekolah').text(data.persentase_sd_sekolah);

                            animateNumber('#usiaSMPTotal', data.usia_smp_total);
                            $('#usiaSMPSekolah').text(formatNumber(data.usia_smp_sekolah));
                            $('#persentaseSMPSekolah').text(data.persentase_smp_sekolah);

                            animateNumber('#usiaSMATotal', data.usia_sma_total);
                            $('#usiaSMASekolah').text(formatNumber(data.usia_sma_sekolah));
                            $('#persentaseSMASekolah').text(data.persentase_sma_sekolah);

                            animateNumber('#wajibBelajarTidakSekolah', data
                                .wajib_belajar_tidak_sekolah);
                        }
                    }
                });

                // 12. Load Chart Kesesuaian Usia Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.kesesuaian.usia.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderKesesuaianUsiaChart(response.data);
                        }
                    }
                });

                // 13. Load Summary Tidak Sekolah
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.summary.tidak.sekolah.wajib.belajar') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            $('#summaryTotal').text(formatNumber(data.total));
                            $('#summaryUsiaSD').text(formatNumber(data.usia_sd));
                            $('#summaryUsiaSMP').text(formatNumber(data.usia_smp));
                        }
                    }
                });

                // 14. Load List Desa untuk Filter
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.list.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let options = '<option value="">-- Semua Desa --</option>';
                            response.data.forEach(function(desa) {
                                options += `<option value="${desa.code}">${desa.name}</option>`;
                            });
                            $('#filterDesa').html(options);

                            // Initialize Select2
                            $('#filterDesa').select2({
                                theme: 'bootstrap4',
                                placeholder: '-- Semua Desa --',
                                allowClear: true
                            });
                        }
                    }
                });
            }

            // Initialize DataTable Tidak Sekolah Wajib Belajar
            let tableTidakSekolah;

            function initDataTableTidakSekolah() {
                if ($.fn.DataTable.isDataTable('#tableTidakSekolahWajibBelajar')) {
                    $('#tableTidakSekolahWajibBelajar').DataTable().destroy();
                }

                tableTidakSekolah = $('#tableTidakSekolahWajibBelajar').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('kecamatan.pendidikan.datatable.tidak.sekolah.wajib.belajar') }}',
                        data: function(d) {
                            d.desa = $('#filterDesa').val();
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
                            data: 'kategori_usia_display',
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
                            data: 'status_pendidikan',
                            name: 'status_pendidikan'
                        }
                    ],
                    order: [
                        [1, 'asc'],
                        [6, 'asc']
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
                        zeroRecords: '<div class="text-center"><i class="fas fa-check-circle text-success fa-3x mb-3"></i><h5 class="text-success">Tidak ada anak tidak sekolah</h5><p class="text-muted">Semua anak usia wajib belajar sudah bersekolah</p></div>',
                        emptyTable: '<div class="text-center"><i class="fas fa-check-circle text-success fa-3x mb-3"></i><h5 class="text-success">Tidak ada data</h5></div>',
                        paginate: {
                            first: '<i class="fas fa-angle-double-left"></i>',
                            last: '<i class="fas fa-angle-double-right"></i>',
                            next: '<i class="fas fa-angle-right"></i>',
                            previous: '<i class="fas fa-angle-left"></i>'
                        }
                    },
                    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    responsive: true,
                    autoWidth: false
                });
            }

            initDataTableTidakSekolah();

            // Event handler untuk filter
            $('#btnFilter').on('click', function() {
                tableTidakSekolah.ajax.reload();
            });

            $('#btnResetFilter').on('click', function() {
                $('#filterDesa').val('').trigger('change');
                tableTidakSekolah.ajax.reload();

                // Reset summary ke data awal
                $.ajax({
                    url: '{{ route('kecamatan.pendidikan.summary.tidak.sekolah.wajib.belajar') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            $('#summaryTotal').text(formatNumber(data.total));
                            $('#summaryUsiaSD').text(formatNumber(data.usia_sd));
                            $('#summaryUsiaSMP').text(formatNumber(data.usia_smp));
                        }
                    }
                });
            });

            // Filter saat tekan Enter di select2
            $('#filterDesa').on('select2:select', function() {
                tableTidakSekolah.ajax.reload();
            });

            // Chart render functions
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

            function renderUmurJenkelChart(data) {
                const ctx = document.getElementById('chartUmurJenkel');
                if (charts['chartUmurJenkel']) charts['chartUmurJenkel'].destroy();

                const labels = Object.values(data).map(item => item.label);
                const dataLaki = Object.values(data).map(item => item.laki);
                const dataPerempuan = Object.values(data).map(item => item.perempuan);

                charts['chartUmurJenkel'] = new Chart(ctx, {
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
                hideChartLoading('chartUmurJenkel');
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
                            <span class="badge badge-secondary badge-stat">${formatNumber(item.tidak_sekolah)}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-warning badge-stat">${formatNumber(item.sd)}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-info badge-stat">${formatNumber(item.smp)}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-primary badge-stat">${formatNumber(item.sma)}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-success badge-stat">${formatNumber(item.diploma)}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-success badge-stat">${formatNumber(item.sarjana)}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-danger badge-stat">${formatNumber(item.putus_sekolah)}</span>
                        </td>
                    </tr>
                `;
                });

                if (html === '') {
                    html = '<tr><td colspan="12" class="text-center text-muted py-4">Tidak ada data</td></tr>';
                }

                $('#tableDetailDesa').html(html);
            }

            function renderKesesuaianUsiaChart(data) {
                const ctx = document.getElementById('chartKesesuaianUsia');
                if (charts['chartKesesuaianUsia']) charts['chartKesesuaianUsia'].destroy();

                const labels = data.map(item => item.desa);
                const dataSD = data.map(item => item.usia_sd_sekolah);
                const dataSMP = data.map(item => item.usia_smp_sekolah);
                const dataSMA = data.map(item => item.usia_sma_sekolah);
                const dataTidakSekolah = data.map(item => item.tidak_sekolah_wajib_belajar);

                charts['chartKesesuaianUsia'] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Usia SD Sekolah (7-12 th)',
                                data: dataSD,
                                backgroundColor: '#ffc107',
                                borderColor: '#ffc107',
                                borderWidth: 1
                            },
                            {
                                label: 'Usia SMP Sekolah (13-15 th)',
                                data: dataSMP,
                                backgroundColor: '#17a2b8',
                                borderColor: '#17a2b8',
                                borderWidth: 1
                            },
                            {
                                label: 'Usia SMA Sekolah (16-18 th)',
                                data: dataSMA,
                                backgroundColor: '#007bff',
                                borderColor: '#007bff',
                                borderWidth: 1
                            },
                            {
                                label: 'Tidak Sekolah (Wajib Belajar)',
                                data: dataTidakSekolah,
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
                hideChartLoading('chartKesesuaianUsia');
            }

            // INITIALIZE - Load semua data secara parallel
            loadAllData();
        });
    </script>
@endpush
