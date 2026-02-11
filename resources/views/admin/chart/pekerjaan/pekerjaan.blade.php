@extends('admin.layout.main')
@section('title', 'Statistik Pekerjaan')
@section('content-header', 'Statistik Pekerjaan')

@section('content')
    <!-- Header Info Card -->
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
                        <div class="stat-icon-premium icon-info text-white">
                            <i class="fas fa-users"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="total_penduduk">
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

        <!-- Usia Kerja -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-user-check"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="usia_kerja">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Usia Kerja
                                <i class="fas fa-user-check stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">15-64 Tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pekerja Aktif -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-success text-white">
                            <i class="fas fa-briefcase"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="pekerja_aktif">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Pekerja Aktif
                                <i class="fas fa-briefcase stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Total Bekerja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengangguran -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-danger text-white">
                            <i class="fas fa-user-times"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="pengangguran">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Pengangguran
                                <i class="fas fa-user-times stat-mini-icon"></i>
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

        <!-- Distribusi Pekerjaan -->
        <div class="col-lg-8 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Pekerjaan</h3>
                        <p class="card-subtitle-premium">10 Jenis Pekerjaan Terbanyak (Usia Kerja ≥15 Tahun)</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-pekerjaan" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="container-pekerjaan">
                        <canvas id="chartDistribusiPekerjaan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribusi Pendapatan -->
        <div class="col-lg-4 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-success">
                    <div class="card-header-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Pendapatan</h3>
                        <p class="card-subtitle-premium">Kategori Pendapatan Per Bulan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-pendapatan" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="pendapatanChartWrapper">
                        <canvas id="chartDistribusiPendapatan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Row 2: Pekerjaan vs Pendapatan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-info">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Analisis Pekerjaan vs Pendapatan</h3>
                        <p class="card-subtitle-premium">Distribusi Pendapatan Berdasarkan Jenis Pekerjaan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-cross" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="crossChartWrapper">
                        <canvas id="chartPekerjaanVsPendapatan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Row 3: Status & Analisis -->
    <div class="row mb-4">
        <div class="col-lg-5 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium" style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Status Pekerjaan</h3>
                        <p class="card-subtitle-premium">Usia Kerja (15-64 Tahun)</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-status" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="statusChartWrapper">
                        <canvas id="chartStatusPekerjaan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium" style="background: linear-gradient(135deg, #20c997 0%, #17a085 100%);">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Rata-rata Pendapatan Per Usia</h3>
                        <p class="card-subtitle-premium">Usia Produktif (15-64 Tahun)</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-analisis" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="analisisChartWrapper">
                        <canvas id="chartAnalisisPendapatan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 4: Gender & Usia -->
    <div class="row mb-4">
        <div class="col-lg-12 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-warning">
                    <div class="card-header-icon">
                        <i class="fas fa-venus-mars"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Pekerjaan Berdasarkan Gender</h3>
                        <p class="card-subtitle-premium">Perbandingan Laki-Laki & Perempuan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-gender" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="genderChartWrapper">
                        <canvas id="chartPekerjaanGender"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-12 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-secondary">
                    <div class="card-header-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Pekerjaan Berdasarkan Usia</h3>
                        <p class="card-subtitle-premium">Standar BPS: Anak s/d Lansia</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-usia" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="usiaChartWrapper">
                        <canvas id="chartPekerjaanUsia"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Row 5: Piramida Penduduk -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-dark">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-area"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Piramida Penduduk Berdasarkan Usia</h3>
                        <p class="card-subtitle-premium">Distribusi Laki-Laki dan Perempuan Per Kategori Usia</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-piramida" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="piramidaChartWrapper">
                        <canvas id="chartPiramidaPenduduk"></canvas>
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
                        <h3 class="card-title-premium">Data Detail Pekerjaan</h3>
                        <p class="card-subtitle-premium">Eksplorasi data berdasarkan kategori pekerjaan</p>
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
                                <a class="nav-link-premium active" id="pekerjaan-tab" data-toggle="pill"
                                    href="#pekerjaan-kategori">
                                    <div class="pill-icon"><i class="fas fa-briefcase"></i></div>
                                    <div class="pill-text">
                                        <span class="pill-title">Pekerjaan</span>
                                        <span class="pill-subtitle">Jenis pekerjaan</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item-premium">
                                <a class="nav-link-premium" id="pendapatan-tab" data-toggle="pill"
                                    href="#pendapatan-kategori">
                                    <div class="pill-icon"><i class="fas fa-money-bill-wave"></i></div>
                                    <div class="pill-text">
                                        <span class="pill-title">Pendapatan</span>
                                        <span class="pill-subtitle">Kategori pendapatan</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item-premium">
                                <a class="nav-link-premium" id="status-tab" data-toggle="pill" href="#status-kategori">
                                    <div class="pill-icon"><i class="fas fa-user-check"></i></div>
                                    <div class="pill-text">
                                        <span class="pill-title">Status Pekerjaan</span>
                                        <span class="pill-subtitle">Status ketenagakerjaan</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item-premium">
                                <a class="nav-link-premium" id="gender-tab" data-toggle="pill" href="#gender-kategori">
                                    <div class="pill-icon"><i class="fas fa-venus-mars"></i></div>
                                    <div class="pill-text">
                                        <span class="pill-title">Gender</span>
                                        <span class="pill-subtitle">Per jenis kelamin</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item-premium">
                                <a class="nav-link-premium" id="usia-tab" data-toggle="pill" href="#usia-kategori">
                                    <div class="pill-icon"><i class="fas fa-users"></i></div>
                                    <div class="pill-text">
                                        <span class="pill-title">Kategori Usia</span>
                                        <span class="pill-subtitle">Kelompok umur</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content-premium" id="categoryTabContent">
                        <!-- Tab Pekerjaan -->
                        <div class="tab-pane fade show active" id="pekerjaan-kategori">
                            <div class="filter-section-premium">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="filter-label">Filter Jenis Pekerjaan:</label>
                                        <select class="form-control select2-premium" id="filter-pekerjaan">
                                            <option value="">Semua Pekerjaan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button class="btn btn-primary btn-block btn-filter"
                                            onclick="applyFilter('pekerjaan')">
                                            <i class="fas fa-filter mr-1"></i> Terapkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-container-premium">
                                <div class="table-responsive">
                                    <table id="table-pekerjaan" class="table-premium">
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Usia</th>
                                                <th>JK</th>
                                                <th>Pekerjaan</th>
                                                <th>Pendapatan</th>
                                                <th>Alamat</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Pendapatan -->
                        <div class="tab-pane fade" id="pendapatan-kategori">
                            <div class="filter-section-premium">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="filter-label">Filter Kategori Pendapatan:</label>
                                        <select class="form-control filter-select" id="filter-pendapatan">
                                            <option value="">Semua Kategori</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                            <option value="0-1 Juta">0 - 1 Juta</option>
                                            <option value="1-2 Juta">1 - 2 Juta</option>
                                            <option value="2-5 Juta">2 - 5 Juta</option>
                                            <option value=">5 Juta">&gt; 5 Juta</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button class="btn btn-primary btn-block btn-filter"
                                            onclick="applyFilter('pendapatan')">
                                            <i class="fas fa-filter mr-1"></i> Terapkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-container-premium">
                                <table id="table-pendapatan" class="table-premium">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Usia</th>
                                            <th>JK</th>
                                            <th>Pekerjaan</th>
                                            <th>Pendapatan</th>
                                            <th>Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Status -->
                        <div class="tab-pane fade" id="status-kategori">
                            <div class="filter-section-premium">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="filter-label">Filter Status Pekerjaan:</label>
                                        <select class="form-control filter-select" id="filter-status">
                                            <option value="">Semua Status</option>
                                            <option value="Bekerja">Bekerja</option>
                                            <option value="Pengangguran">Pengangguran</option>
                                            <option value="Mengurus Rumah Tangga">Mengurus Rumah Tangga</option>
                                            <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button class="btn btn-primary btn-block btn-filter"
                                            onclick="applyFilter('status')">
                                            <i class="fas fa-filter mr-1"></i> Terapkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-container-premium">
                                <table id="table-status" class="table-premium">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Usia</th>
                                            <th>JK</th>
                                            <th>Pekerjaan</th>
                                            <th>Status Pekerjaan</th>
                                            <th>Pendapatan</th>
                                            <th>Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Gender -->
                        <div class="tab-pane fade" id="gender-kategori">
                            <div class="filter-section-premium">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="filter-label">Filter Jenis Kelamin:</label>
                                        <select class="form-control filter-select" id="filter-gender">
                                            <option value="">Semua</option>
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="filter-label">Filter Pekerjaan:</label>
                                        <select class="form-control filter-select" id="filter-gender-pekerjaan">
                                            <option value="">Semua Pekerjaan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button class="btn btn-primary btn-block btn-filter"
                                            onclick="applyFilter('gender')">
                                            <i class="fas fa-filter mr-1"></i> Terapkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-container-premium">
                                <table id="table-gender" class="table-premium">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Usia</th>
                                            <th>JK</th>
                                            <th>Pekerjaan</th>
                                            <th>Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Usia -->
                        <div class="tab-pane fade" id="usia-kategori">
                            <div class="filter-section-premium">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="filter-label">Filter Kategori Usia:</label>
                                        <select class="form-control filter-select" id="filter-usia">
                                            <option value="">Semua Kategori</option>
                                            <option value="Anak (<15)">Anak (<15)< /option>
                                            <option value="Usia Sekolah (15-17)">Usia Sekolah (15-17)</option>
                                            <option value="Produktif Awal (18-24)">Produktif Awal (18-24)</option>
                                            <option value="Produktif Utama (25-44)">Produktif Utama (25-44)</option>
                                            <option value="Produktif Akhir (45-59)">Produktif Akhir (45-59)</option>
                                            <option value="Lansia (≥60)">Lansia (≥60)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button class="btn btn-primary btn-block btn-filter"
                                            onclick="applyFilter('usia')">
                                            <i class="fas fa-filter mr-1"></i> Terapkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-container-premium">
                                <table id="table-usia" class="table-premium">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Usia</th>
                                            <th>Kategori Usia</th>
                                            <th>JK</th>
                                            <th>Pekerjaan</th>
                                            <th>Alamat</th>
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
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 with premium theme
            $('.select2-primary').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Pilih RT/RW'
            });

            $('.select2-premium').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            $('.select2-success').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Pilih Kampung'
            });

            $('.select2-info').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Pilih Jenis Kelamin'
            });

            // Chart instances
            let charts = {
                pekerjaan: null,
                pendapatan: null,
                cross: null,
                gender: null,
                usia: null,
                piramida: null,
                status: null,
                analisis: null
            };

            // DataTable instances
            let dataTables = {
                pekerjaan: null,
                pendapatan: null,
                status: null,
                gender: null,
                usia: null
            };

            // Color schemes
            const colors = {
                primary: ['#007bff', '#0056b3', '#004085', '#003d82', '#003366'],
                success: ['#28a745', '#20c997', '#17a2b8', '#138496', '#0e6e7e'],
                info: ['#17a2b8', '#138496', '#117a8b', '#0c6980', '#0a5875'],
                warm: ['#fd7e14', '#ffc107', '#28a745', '#20c997', '#17a2b8'],
                multi: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#20c997', '#fd7e14', '#e83e8c'],
                status: ['#28a745', '#dc3545', '#ff6b6b', '#ffc107']
            };

            // Load KPI Data
            function loadKPIData() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.kpi') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#total_penduduk').html(data.total_penduduk.toLocaleString('id-ID'));
                        $('#usia_kerja').html(
                            data.usia_kerja.toLocaleString('id-ID') +
                            ' <small style="font-size: 0.75rem; opacity: 0.9;">(' +
                            ((data.usia_kerja / data.total_penduduk) * 100).toFixed(1) +
                            '%)</small>'
                        );
                        $('#pekerja_aktif').html(
                            data.pekerja_aktif.toLocaleString('id-ID') +
                            ' <small style="font-size: 0.75rem; opacity: 0.9;">(TPAK: ' +
                            data.tpak + '%)</small>'
                        );
                        $('#pengangguran').html(
                            data.persentase_pengangguran + '% ' +
                            '<small style="font-size: 0.75rem; opacity: 0.9;">(' +
                            data.pengangguran.toLocaleString('id-ID') + ' orang)</small>'
                        );
                    }
                });
            }

            // Load Distribusi Pekerjaan
            function loadDistribusiPekerjaan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.distribusi.pekerjaan') }}',
                    method: 'GET',
                    success: function(data) {
                        // Populate filter dropdown
                        $('#filter-pekerjaan, #filter-gender-pekerjaan').html(
                            '<option value="">Semua Pekerjaan</option>');
                        data.forEach(item => {
                            $('#filter-pekerjaan, #filter-gender-pekerjaan').append(
                                `<option value="${item.pekerjaan}">${item.pekerjaan} (${item.jumlah})</option>`
                            );
                        });

                        $('#loading-pekerjaan').fadeOut(300, function() {
                            $('#container-pekerjaan').fadeIn(400);

                            const ctx = document.getElementById('chartDistribusiPekerjaan')
                                .getContext('2d');
                            if (charts.pekerjaan) charts.pekerjaan.destroy();

                            charts.pekerjaan = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: data.map(item => item.pekerjaan),
                                    datasets: [{
                                        label: 'Jumlah Penduduk',
                                        data: data.map(item => item.jumlah),
                                        backgroundColor: colors.primary[0],
                                        borderColor: colors.primary[1],
                                        borderWidth: 1,
                                        borderRadius: 10,
                                        barThickness: 25
                                    }]
                                },
                                options: {
                                    indexAxis: 'y',
                                    responsive: true,
                                    maintainAspectRatio: false,
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
                                                    return 'Jumlah: ' + context
                                                        .parsed.x
                                                        .toLocaleString() +
                                                        ' orang';
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
                                                font: {
                                                    size: 12
                                                },
                                                callback: function(value) {
                                                    return value.toLocaleString();
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
                                                },
                                                autoSkip: false,
                                                maxRotation: 0,
                                                minRotation: 0
                                            }
                                        }
                                    },
                                    layout: {
                                        padding: {
                                            left: 10,
                                            right: 20,
                                            top: 10,
                                            bottom: 10
                                        }
                                    }
                                }
                            });
                        });
                    }
                });
            }

            // Load Distribusi Pendapatan
            function loadDistribusiPendapatan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.distribusi.pendapatan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-pendapatan').fadeOut(300, function() {
                            $('#pendapatanChartWrapper').fadeIn(400);

                            const ctx = document.getElementById('chartDistribusiPendapatan')
                                .getContext('2d');
                            if (charts.pendapatan) charts.pendapatan.destroy();

                            charts.pendapatan = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: data.map(item => item.kategori),
                                    datasets: [{
                                        data: data.map(item => item.jumlah),
                                        backgroundColor: colors.success,
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
                                                    const total = context.dataset
                                                        .data.reduce((
                                                            a, b) => a + b, 0);
                                                    const percentage = ((context
                                                        .parsed /
                                                        total) * 100).toFixed(1);
                                                    return context.label + ': ' +
                                                        context.parsed
                                                        .toLocaleString() + ' (' +
                                                        percentage +
                                                        '%)';
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    }
                });
            }

            // Load Pekerjaan vs Pendapatan
            function loadPekerjaanVsPendapatan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.pekerjaan.pendapatan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-cross').fadeOut(300, function() {
                            $('#crossChartWrapper').fadeIn(400);

                            const ctx = document.getElementById('chartPekerjaanVsPendapatan')
                                .getContext('2d');
                            if (charts.cross) charts.cross.destroy();

                            const datasets = data.datasets.map((dataset, index) => ({
                                label: dataset.label,
                                data: dataset.data,
                                backgroundColor: colors.info[index % colors.info
                                    .length],
                                borderWidth: 0,
                                borderRadius: 8
                            }));

                            charts.cross = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: data.labels,
                                    datasets: datasets
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                            labels: {
                                                padding: 15,
                                                font: {
                                                    size: 13,
                                                    weight: '600'
                                                },
                                                usePointStyle: true,
                                                pointStyle: 'circle'
                                            }
                                        },
                                        tooltip: {
                                            mode: 'index',
                                            intersect: false,
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
                                                footer: function(tooltipItems) {
                                                    let sum = 0;
                                                    tooltipItems.forEach(function(
                                                        tooltipItem) {
                                                        sum += tooltipItem
                                                            .parsed.y;
                                                    });
                                                    return 'Total: ' + sum
                                                        .toLocaleString() +
                                                        ' orang';
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            stacked: true,
                                            grid: {
                                                display: false
                                            },
                                            ticks: {
                                                font: {
                                                    size: 11,
                                                    weight: 'bold'
                                                }
                                            }
                                        },
                                        y: {
                                            stacked: true,
                                            beginAtZero: true,
                                            grid: {
                                                color: 'rgba(0,0,0,0.03)'
                                            },
                                            ticks: {
                                                font: {
                                                    size: 12
                                                },
                                                callback: function(value) {
                                                    return value.toLocaleString();
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    }
                });
            }

            // Load Status Pekerjaan
            function loadStatusPekerjaan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.status.pekerjaan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-status').fadeOut(300, function() {
                            $('#statusChartWrapper').fadeIn(400);

                            const ctx = document.getElementById('chartStatusPekerjaan')
                                .getContext('2d');
                            if (charts.status) charts.status.destroy();

                            charts.status = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: data.map(item => item.status),
                                    datasets: [{
                                        data: data.map(item => item.jumlah),
                                        backgroundColor: colors.status,
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
                                                    const total = context.dataset
                                                        .data.reduce((
                                                            a, b) => a + b, 0);
                                                    const percentage = ((context
                                                        .parsed /
                                                        total) * 100).toFixed(1);
                                                    return context.label + ': ' +
                                                        context.parsed
                                                        .toLocaleString() + ' (' +
                                                        percentage +
                                                        '%)';
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    }
                });
            }

            // Load Analisis Pendapatan
            function loadAnalisisPendapatan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.analisis.pendapatan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-analisis').fadeOut(300, function() {
                            $('#analisisChartWrapper').fadeIn(400);

                            const ctx = document.getElementById('chartAnalisisPendapatan')
                                .getContext('2d');
                            if (charts.analisis) charts.analisis.destroy();

                            charts.analisis = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: data.map(item => item.kategori_usia),
                                    datasets: [{
                                        label: 'Rata-rata Pendapatan',
                                        data: data.map(item => item
                                            .rata_pendapatan),
                                        backgroundColor: '#20c997',
                                        borderColor: '#17a085',
                                        borderWidth: 1,
                                        borderRadius: 10,
                                        barThickness: 40
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
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
                                                    return 'Rata-rata: Rp ' +
                                                        context.parsed.y
                                                        .toLocaleString('id-ID');
                                                },
                                                afterLabel: function(context) {
                                                    const index = context.dataIndex;
                                                    return [
                                                        'Min: Rp ' + data[index]
                                                        .min_pendapatan
                                                        .toLocaleString(
                                                            'id-ID'),
                                                        'Max: Rp ' + data[index]
                                                        .max_pendapatan
                                                        .toLocaleString(
                                                            'id-ID'),
                                                        'Jumlah: ' + data[index]
                                                        .jumlah
                                                        .toLocaleString() +
                                                        ' orang'
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
                                                font: {
                                                    size: 12
                                                },
                                                callback: function(value) {
                                                    return value.toLocaleString();
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
                        });
                    }
                });
            }

            // Load Pekerjaan by Gender
            function loadPekerjaanByGender() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.pekerjaan.gender') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-gender').fadeOut(300, function() {
                            $('#genderChartWrapper').fadeIn(400);

                            const ctx = document.getElementById('chartPekerjaanGender')
                                .getContext('2d');
                            if (charts.gender) charts.gender.destroy();

                            charts.gender = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: data.labels,
                                    datasets: [{
                                            label: 'Laki-Laki',
                                            data: data.datasets[0].data,
                                            backgroundColor: '#007bff',
                                            borderWidth: 0,
                                            borderRadius: 10,
                                            barThickness: 30
                                        },
                                        {
                                            label: 'Perempuan',
                                            data: data.datasets[1].data,
                                            backgroundColor: '#e83e8c',
                                            borderWidth: 0,
                                            borderRadius: 10,
                                            barThickness: 30
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                            labels: {
                                                padding: 15,
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
                                                footer: function(tooltipItems) {
                                                    let sum = 0;
                                                    tooltipItems.forEach(function(
                                                        tooltipItem) {
                                                        sum += tooltipItem
                                                            .parsed.y;
                                                    });
                                                    return 'Total: ' + sum
                                                        .toLocaleString() +
                                                        ' orang';
                                                }
                                            }
                                        }
                                    },
                                    scales: {
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
                                        },
                                        y: {
                                            beginAtZero: true,
                                            grid: {
                                                color: 'rgba(0,0,0,0.03)'
                                            },
                                            ticks: {
                                                font: {
                                                    size: 12
                                                },
                                                callback: function(value) {
                                                    return value.toLocaleString();
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    }
                });
            }

            // Load Pekerjaan by Usia
            function loadPekerjaanByUsia() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.pekerjaan.usia') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-usia').fadeOut(300, function() {
                            $('#usiaChartWrapper').fadeIn(400);

                            const ctx = document.getElementById('chartPekerjaanUsia')
                                .getContext('2d');
                            if (charts.usia) charts.usia.destroy();

                            const usiaColors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4',
                                '#ffeaa7',
                                '#dfe6e9'
                            ];
                            const datasets = data.datasets.map((dataset, index) => ({
                                label: dataset.label,
                                data: dataset.data,
                                backgroundColor: usiaColors[index],
                                borderWidth: 0,
                                borderRadius: 8
                            }));

                            charts.usia = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: data.labels,
                                    datasets: datasets
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                            labels: {
                                                font: {
                                                    size: 11,
                                                    weight: '600'
                                                },
                                                padding: 12,
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
                                                footer: function(tooltipItems) {
                                                    let sum = 0;
                                                    tooltipItems.forEach(function(
                                                        tooltipItem) {
                                                        sum += tooltipItem
                                                            .parsed.y;
                                                    });
                                                    return 'Total: ' + sum
                                                        .toLocaleString() +
                                                        ' orang';
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            stacked: true,
                                            grid: {
                                                display: false
                                            },
                                            ticks: {
                                                font: {
                                                    size: 10,
                                                    weight: 'bold'
                                                }
                                            }
                                        },
                                        y: {
                                            stacked: true,
                                            beginAtZero: true,
                                            grid: {
                                                color: 'rgba(0,0,0,0.03)'
                                            },
                                            ticks: {
                                                font: {
                                                    size: 12
                                                },
                                                callback: function(value) {
                                                    return value.toLocaleString();
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    }
                });
            }

            // Load Piramida Penduduk
            function loadPiramidaPenduduk() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.distribusi.usia') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-piramida').fadeOut(300, function() {
                            $('#piramidaChartWrapper').fadeIn(400);

                            const ctx = document.getElementById('chartPiramidaPenduduk')
                                .getContext('2d');
                            if (charts.piramida) charts.piramida.destroy();

                            charts.piramida = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: data.labels,
                                    datasets: [{
                                            label: 'Laki-Laki',
                                            data: data.datasets[0].data,
                                            backgroundColor: '#007bff',
                                            borderWidth: 0,
                                            borderRadius: 8,
                                            barThickness: 20
                                        },
                                        {
                                            label: 'Perempuan',
                                            data: data.datasets[1].data,
                                            backgroundColor: '#e83e8c',
                                            borderWidth: 0,
                                            borderRadius: 8,
                                            barThickness: 20
                                        }
                                    ]
                                },
                                options: {
                                    indexAxis: 'y',
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                            labels: {
                                                padding: 15,
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
                                                    const value = Math.abs(context
                                                        .parsed.x);
                                                    return context.dataset.label +
                                                        ': ' + value
                                                        .toLocaleString() +
                                                        ' orang';
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            grid: {
                                                color: 'rgba(0,0,0,0.03)'
                                            },
                                            ticks: {
                                                font: {
                                                    size: 12
                                                },
                                                callback: function(value) {
                                                    return Math.abs(value)
                                                        .toLocaleString();
                                                }
                                            }
                                        },
                                        y: {
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
                        });
                    }
                });
            }

            // Initialize DataTable Pekerjaan
            function initTablePekerjaan() {
                if (dataTables.pekerjaan) {
                    dataTables.pekerjaan.destroy();
                }

                dataTables.pekerjaan = $('#table-pekerjaan').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
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
                        url: '{{ route('pekerjaan.dt.detail.pekerjaan') }}',
                        data: function(d) {
                            d.pekerjaan = $('#filter-pekerjaan').val();
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
                            data: 'nik',
                            name: 'nik',
                            className: 'text-center'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'usia',
                            name: 'usia',
                            className: 'text-center'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'jenis_kelamin',
                            className: 'text-center'
                        },
                        {
                            data: 'pekerjaan',
                            name: 'pekerjaan',
                            className: 'text-center'
                        },
                        {
                            data: 'kategori_pendapatan',
                            name: 'kategori_pendapatan',
                            className: 'text-center'
                        },
                        {
                            data: 'alamat_kk',
                            name: 'alamat_kk'
                        }
                    ]
                });
            }

            function initTablePendapatan() {
                if (dataTables.pendapatan) {
                    dataTables.pendapatan.destroy();
                }

                dataTables.pendapatan = $('#table-pendapatan').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
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
                        url: '{{ route('pekerjaan.dt.detail.pendapatan') }}',
                        data: function(d) {
                            d.kategori = $('#filter-pendapatan').val();
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
                            data: 'nik',
                            name: 'nik',
                            className: 'text-center'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'usia',
                            name: 'usia',
                            className: 'text-center'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'jenis_kelamin',
                            className: 'text-center'
                        },
                        {
                            data: 'pekerjaan',
                            name: 'pekerjaan',
                            className: 'text-center'
                        },
                        {
                            data: 'pendapatan_perbulan',
                            name: 'pendapatan_perbulan',
                            className: 'text-center'
                        },
                        {
                            data: 'alamat_kk',
                            name: 'alamat_kk'
                        }
                    ]
                });
            }

            function initTableStatus() {
                if (dataTables.status) {
                    dataTables.status.destroy();
                }

                dataTables.status = $('#table-status').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
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
                        url: '{{ route('pekerjaan.dt.detail.status') }}',
                        data: function(d) {
                            d.status = $('#filter-status').val();
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
                            data: 'nik',
                            name: 'nik',
                            className: 'text-center'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'usia',
                            name: 'usia',
                            className: 'text-center'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'jenis_kelamin',
                            className: 'text-center'
                        },
                        {
                            data: 'pekerjaan',
                            name: 'pekerjaan',
                            className: 'text-center'
                        },
                        {
                            data: 'status_pekerjaan',
                            name: 'status_pekerjaan',
                            className: 'text-center'
                        },
                        {
                            data: 'pendapatan_perbulan',
                            name: 'pendapatan_perbulan',
                            className: 'text-center'
                        },
                        {
                            data: 'alamat_kk',
                            name: 'alamat_kk'
                        }
                    ]
                });
            }

            function initTableGender() {
                if (dataTables.gender) {
                    dataTables.gender.destroy();
                }

                dataTables.gender = $('#table-gender').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
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
                        url: '{{ route('pekerjaan.dt.detail.gender') }}',
                        data: function(d) {
                            d.gender = $('#filter-gender').val();
                            d.pekerjaan = $('#filter-gender-pekerjaan').val();
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
                            data: 'nik',
                            name: 'nik',
                            className: 'text-center'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'usia',
                            name: 'usia',
                            className: 'text-center'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'jenis_kelamin',
                            className: 'text-center'
                        },
                        {
                            data: 'pekerjaan',
                            name: 'pekerjaan',
                            className: 'text-center'
                        },
                        {
                            data: 'alamat_kk',
                            name: 'alamat_kk'
                        }
                    ]
                });
            }

            function initTableUsia() {
                if (dataTables.usia) {
                    dataTables.usia.destroy();
                }

                dataTables.usia = $('#table-usia').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
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
                        url: '{{ route('pekerjaan.dt.detail.usia') }}',
                        data: function(d) {
                            d.kategori_usia = $('#filter-usia').val();
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
                            data: 'nik',
                            name: 'nik',
                            className: 'text-center'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'tgl_lahir',
                            name: 'tgl_lahir',
                            className: 'text-center'
                        },
                        {
                            data: 'usia',
                            name: 'usia',
                            className: 'text-center'
                        },
                        {
                            data: 'kategori_usia',
                            name: 'kategori_usia',
                            className: 'text-center'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'jenis_kelamin',
                            className: 'text-center'
                        },
                        {
                            data: 'pekerjaan',
                            name: 'pekerjaan',
                            className: 'text-center'
                        },
                        {
                            data: 'alamat_kk',
                            name: 'alamat_kk'
                        }
                    ]
                });
            }

            // Tab change handler
            $('#categoryTab a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                const target = $(e.target).attr('href');

                // Scroll to card
                $('html, body').animate({
                    scrollTop: $('.card-widget-premium:last').offset().top - 100
                }, 300);

                switch (target) {
                    case '#pekerjaan-kategori':
                        if (!dataTables.pekerjaan) initTablePekerjaan();
                        break;
                    case '#pendapatan-kategori':
                        if (!dataTables.pendapatan) initTablePendapatan();
                        break;
                    case '#status-kategori':
                        if (!dataTables.status) initTableStatus();
                        break;
                    case '#gender-kategori':
                        if (!dataTables.gender) initTableGender();
                        break;
                    case '#usia-kategori':
                        if (!dataTables.usia) initTableUsia();
                        break;
                }
            });

            // Apply Filter Function
            window.applyFilter = function(type) {
                switch (type) {
                    case 'pekerjaan':
                        if (dataTables.pekerjaan) dataTables.pekerjaan.ajax.reload();
                        break;
                    case 'pendapatan':
                        if (dataTables.pendapatan) dataTables.pendapatan.ajax.reload();
                        break;
                    case 'status':
                        if (dataTables.status) dataTables.status.ajax.reload();
                        break;
                    case 'gender':
                        if (dataTables.gender) dataTables.gender.ajax.reload();
                        break;
                    case 'usia':
                        if (dataTables.usia) dataTables.usia.ajax.reload();
                        break;
                }
            }

            // Initialize all charts
            loadKPIData();
            loadDistribusiPekerjaan();
            loadDistribusiPendapatan();
            loadPekerjaanVsPendapatan();
            loadStatusPekerjaan();
            loadAnalisisPendapatan();
            loadPekerjaanByGender();
            loadPekerjaanByUsia();
            loadPiramidaPenduduk();

            // Initialize first table
            initTablePekerjaan();
        });
    </script>
@endpush
