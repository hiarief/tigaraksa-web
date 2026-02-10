@extends('admin.layout.main')
@section('title', 'Statistik Perkawinan')
@section('content-header', 'Statistik Perkawinan')

@section('content')
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
                    <form id="filterForm">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-dark text-sm">
                                        <i class="fas fa-map-marker-alt text-primary mr-1"></i>RT/RW
                                    </label>
                                    <select class="form-control form-control-lg select2-primary" id="filter_rt_rw"
                                        name="rt_rw">
                                        <option value="">Semua RT/RW</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-dark text-sm">
                                        <i class="fas fa-city text-success mr-1"></i>Kampung
                                    </label>
                                    <select class="form-control form-control-lg select2-success" id="filter_kp"
                                        name="kp">
                                        <option value="">Semua Kampung</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-dark text-sm">
                                        <i class="fas fa-venus-mars text-info mr-1"></i>Jenis Kelamin
                                    </label>
                                    <select class="form-control form-control-lg select2-info" id="filter_jenkel"
                                        name="jenkel">
                                        <option value="">Semua</option>
                                        <option value="1">Laki-laki</option>
                                        <option value="2">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-dark d-block text-sm">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block elevation-2">
                                        <i class="fas fa-chart-line mr-2"></i>Analisis Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
                    <span class="info-box-premium-number" id="total_penduduk">
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
                        <i class="fas fa-heart text-success"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Total Status Kawin</span>
                    <span class="info-box-premium-number" id="total_kawin">
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
                        <i class="fas fa-user-circle text-warning"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Total Belum Kawin</span>
                    <span class="info-box-premium-number" id="total_belum_kawin">
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
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Kawin Usia Anak</span>
                    <span class="info-box-premium-number" id="total_usia_anak">
                        <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                    </span>
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
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Komposisi Status Perkawinan</h3>
                        <p class="card-subtitle-premium">Distribusi berdasarkan status</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingStatusPerkawinan" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartStatusPerkawinan" style="display:none; max-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-success">
                    <div class="card-header-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Legalitas Perkawinan</h3>
                        <p class="card-subtitle-premium">Status pencatatan perkawinan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingLegalitas" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartLegalitas" style="display:none; max-height: 320px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-info">
                    <div class="card-header-icon">
                        <i class="fas fa-venus-mars"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Perkawinan Berdasarkan Gender</h3>
                        <p class="card-subtitle-premium">Analisis per jenis kelamin</p>
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
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-warning">
                    <div class="card-header-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Kesiapan Usia Kawin</h3>
                        <p class="card-subtitle-premium">Berdasarkan batasan usia minimal</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingUsiaSiap" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartUsiaSiap" style="display:none; max-height: 320px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Row 3 - Full Width -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-danger">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-area"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Tren Distribusi Usia Perkawinan</h3>
                        <p class="card-subtitle-premium">Pola usia menikah berdasarkan kelompok umur</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingDistribusiUsia" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartDistribusiUsia" style="display:none; max-height: 350px;"></canvas>
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
                        <h3 class="card-title-premium">Data Detail & Analisis Mendalam</h3>
                        <p class="card-subtitle-premium">Eksplorasi data berdasarkan kategori spesifik</p>
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
                                <a class="nav-link-premium active" id="status-tab" data-toggle="pill"
                                    href="#status-kategori">
                                    <div class="pill-icon"><i class="fas fa-ring"></i></div>
                                    <div class="pill-text">
                                        <span class="pill-title">Status Perkawinan</span>
                                        <span class="pill-subtitle">Klasifikasi status</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item-premium">
                                <a class="nav-link-premium" id="legalitas-tab" data-toggle="pill"
                                    href="#legalitas-kategori">
                                    <div class="pill-icon"><i class="fas fa-file-contract"></i></div>
                                    <div class="pill-text">
                                        <span class="pill-title">Legalitas</span>
                                        <span class="pill-subtitle">Status pencatatan</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item-premium">
                                <a class="nav-link-premium" id="usia-tab" data-toggle="pill" href="#usia-kategori">
                                    <div class="pill-icon"><i class="fas fa-calendar-check"></i></div>
                                    <div class="pill-text">
                                        <span class="pill-title">Usia Siap</span>
                                        <span class="pill-subtitle">Kesiapan usia</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item-premium">
                                <a class="nav-link-premium" id="anak-tab" data-toggle="pill" href="#anak-kategori">
                                    <div class="pill-icon"><i class="fas fa-child"></i></div>
                                    <div class="pill-text">
                                        <span class="pill-title">Usia Anak</span>
                                        <span class="pill-subtitle">Di bawah 19 tahun</span>
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
                                <a class="nav-link-premium" id="distribusi-tab" data-toggle="pill"
                                    href="#distribusi-kategori">
                                    <div class="pill-icon"><i class="fas fa-chart-line"></i></div>
                                    <div class="pill-text">
                                        <span class="pill-title">Distribusi</span>
                                        <span class="pill-subtitle">Kelompok usia</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content-premium" id="categoryTabContent">
                        <!-- Status Perkawinan -->
                        <div class="tab-pane fade show active" id="status-kategori">
                            <div class="sub-tabs-container">
                                <ul class="nav nav-tabs-premium" id="statusSubTab">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#"
                                            data-kategori="semua" data-table="table_status">
                                            <i class="fas fa-globe mr-1"></i>Semua Data
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#" data-kategori="belum_kawin"
                                            data-table="table_status">
                                            <i class="fas fa-user mr-1"></i>Belum Kawin
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#" data-kategori="kawin"
                                            data-table="table_status">
                                            <i class="fas fa-heart mr-1"></i>Kawin
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#" data-kategori="cerai_hidup"
                                            data-table="table_status">
                                            <i class="fas fa-user-slash mr-1"></i>Cerai Hidup
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#" data-kategori="cerai_mati"
                                            data-table="table_status">
                                            <i class="fas fa-times-circle mr-1"></i>Cerai Mati
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="table-container-premium">
                                <div class="table-responsive">
                                    <table id="table_status" class="table-premium">
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th>NIK</th>
                                                <th>Nama Lengkap</th>
                                                <th>JK</th>
                                                <th>Umur</th>
                                                <th>Tanggal Lahir</th>
                                                <th>RT/RW</th>
                                                <th>Kampung</th>
                                                <th>Status</th>
                                                <th>Tercatat</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Legalitas Perkawinan -->
                        <div class="tab-pane fade" id="legalitas-kategori">
                            <div class="sub-tabs-container">
                                <ul class="nav nav-tabs-premium">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#"
                                            data-kategori="kawin_tercatat" data-table="table_legalitas">
                                            <i class="fas fa-check-circle mr-1"></i>Tercatat
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#"
                                            data-kategori="kawin_tidak_tercatat" data-table="table_legalitas">
                                            <i class="fas fa-times-circle mr-1"></i>Tidak Tercatat
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="table-container-premium">
                                <table id="table_legalitas" class="table-premium">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>NIK</th>
                                            <th>Nama Lengkap</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Tanggal Lahir</th>
                                            <th>RT/RW</th>
                                            <th>Kampung</th>
                                            <th>Status</th>
                                            <th>Tercatat</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Usia Siap Kawin -->
                        <div class="tab-pane fade" id="usia-kategori">
                            <div class="sub-tabs-container">
                                <ul class="nav nav-tabs-premium">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#"
                                            data-kategori="belum_kawin_siap" data-table="table_usia_siap">
                                            <i class="fas fa-check mr-1"></i>Usia ≥ 19 Tahun
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#"
                                            data-kategori="belum_kawin_belum_siap" data-table="table_usia_siap">
                                            <i class="fas fa-times mr-1"></i>Usia < 19 Tahun </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="table-container-premium">
                                <table id="table_usia_siap" class="table-premium">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>NIK</th>
                                            <th>Nama Lengkap</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Tanggal Lahir</th>
                                            <th>RT/RW</th>
                                            <th>Kampung</th>
                                            <th>Status</th>
                                            <th>Tercatat</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Perkawinan Usia Anak -->
                        <div class="tab-pane fade" id="anak-kategori">
                            <div class="alert-premium alert-warning-premium">
                                <div class="alert-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="alert-content">
                                    <h5 class="alert-title">Perhatian Khusus</h5>
                                    <p class="alert-text">Data berikut menampilkan individu yang menikah di bawah usia 19
                                        tahun dan memerlukan perhatian khusus.</p>
                                </div>
                            </div>
                            <div class="table-container-premium">
                                <table id="table_usia_anak" class="table-premium">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>NIK</th>
                                            <th>Nama Lengkap</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Tanggal Lahir</th>
                                            <th>RT/RW</th>
                                            <th>Kampung</th>
                                            <th>Status</th>
                                            <th>Tercatat</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Perkawinan Gender -->
                        <div class="tab-pane fade" id="gender-kategori">
                            <div class="sub-tabs-container">
                                <ul class="nav nav-tabs-premium">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#"
                                            data-kategori="kawin_laki" data-table="table_gender">
                                            <i class="fas fa-male mr-1"></i>Laki-laki
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#"
                                            data-kategori="kawin_perempuan" data-table="table_gender">
                                            <i class="fas fa-female mr-1"></i>Perempuan
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="table-container-premium">
                                <table id="table_gender" class="table-premium">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>NIK</th>
                                            <th>Nama Lengkap</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Tanggal Lahir</th>
                                            <th>RT/RW</th>
                                            <th>Kampung</th>
                                            <th>Status</th>
                                            <th>Tercatat</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Distribusi Usia -->
                        <div class="tab-pane fade" id="distribusi-kategori">
                            <div class="sub-tabs-container">
                                <ul class="nav nav-tabs-premium">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#"
                                            data-kategori="kawin_usia_19_24" data-table="table_distribusi">
                                            <i class="fas fa-user-graduate mr-1"></i>19-24 Tahun
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#"
                                            data-kategori="kawin_usia_25_34" data-table="table_distribusi">
                                            <i class="fas fa-user-tie mr-1"></i>25-34 Tahun
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#"
                                            data-kategori="kawin_usia_35_49" data-table="table_distribusi">
                                            <i class="fas fa-user-friends mr-1"></i>35-49 Tahun
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#"
                                            data-kategori="kawin_usia_50_plus" data-table="table_distribusi">
                                            <i class="fas fa-user-clock mr-1"></i>≥ 50 Tahun
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="table-container-premium">
                                <table id="table_distribusi" class="table-premium">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>NIK</th>
                                            <th>Nama Lengkap</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Tanggal Lahir</th>
                                            <th>RT/RW</th>
                                            <th>Kampung</th>
                                            <th>Status</th>
                                            <th>Tercatat</th>
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
        let chartStatusPerkawinan, chartLegalitas, chartGender, chartUsiaSiap, chartDistribusiUsia;
        let tables = {};

        $(document).ready(function() {
            // Initialize Select2 with premium theme
            $('.select2-primary').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Pilih RT/RW'
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

            loadFilterOptions();
            loadData();
            loadTableData('table_status', 'semua');

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                loadData();
                reloadAllTables();
            });

            // Main category pills navigation
            // Event listener untuk main category pills
            $('#categoryTab a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                const targetPane = $(e.target).attr('href');

                // TAMBAHKAN: Scroll to top of card
                $('html, body').animate({
                    scrollTop: $('.card-widget-premium:last').offset().top - 100
                }, 300);

                // Load data berdasarkan kategori utama yang dipilih
                if (targetPane === '#status-kategori') {
                    loadTableData('table_status', 'semua');
                } else if (targetPane === '#legalitas-kategori') {
                    loadTableData('table_legalitas', 'kawin_tercatat');
                } else if (targetPane === '#usia-kategori') {
                    loadTableData('table_usia_siap', 'belum_kawin_siap');
                } else if (targetPane === '#anak-kategori') {
                    loadTableData('table_usia_anak', 'usia_anak');
                } else if (targetPane === '#gender-kategori') {
                    loadTableData('table_gender', 'kawin_laki');
                } else if (targetPane === '#distribusi-kategori') {
                    loadTableData('table_distribusi', 'kawin_usia_19_24');
                }
            });

            // TAMBAHKAN: Reset scroll untuk sub-tabs
            $(document).on('click', '[data-kategori]', function(e) {
                e.preventDefault();
                const kategori = $(this).data('kategori');
                const tableId = $(this).data('table');

                $(this).closest('.nav-tabs-premium').find('.nav-link').removeClass('active');
                $(this).addClass('active');

                if (tableId) {
                    loadTableData(tableId, kategori);

                    // Scroll to table
                    setTimeout(function() {
                        $('html, body').animate({
                            scrollTop: $('#' + tableId).offset().top - 150
                        }, 300);
                    }, 100);
                }
            });
        });

        function loadFilterOptions() {
            $.ajax({
                url: '{{ route('perkawinan.index') }}/filter-options',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        response.rt_rw.forEach(function(item) {
                            $('#filter_rt_rw').append(`<option value="${item}">${item}</option>`);
                        });

                        response.kampung.forEach(function(item) {
                            $('#filter_kp').append(`<option value="${item}">${item}</option>`);
                        });
                    }
                }
            });
        }

        function loadData() {
            const filters = {
                rt_rw: $('#filter_rt_rw').val(),
                kp: $('#filter_kp').val(),
                jenkel: $('#filter_jenkel').val()
            };

            $.ajax({
                url: '{{ route('perkawinan.index') }}/get-data',
                method: 'GET',
                data: filters,
                success: function(response) {
                    if (response.success) {
                        updateStatistics(response.statistics);
                        updateCharts(response.statistics);
                    }
                }
            });
        }

        function updateStatistics(stats) {
            $('#total_penduduk').html(stats.total.toLocaleString('id-ID'));
            $('#total_kawin').html(stats.status_perkawinan['KAWIN'].toLocaleString('id-ID'));
            $('#total_belum_kawin').html(stats.status_perkawinan['BELUM KAWIN'].toLocaleString('id-ID'));
            $('#total_usia_anak').html(
                stats.perkawinan_usia_anak.jumlah.toLocaleString('id-ID') +
                ' <small style="font-size: 0.75rem; opacity: 0.9;">(' +
                stats.perkawinan_usia_anak.persentase + '%)</small>'
            );
        }

        function updateCharts(stats) {
            // Status Perkawinan Chart
            const ctxStatus = document.getElementById('chartStatusPerkawinan').getContext('2d');
            $('#loadingStatusPerkawinan').fadeOut(300, function() {
                $('#chartStatusPerkawinan').fadeIn(400);
            });

            if (chartStatusPerkawinan) chartStatusPerkawinan.destroy();

            chartStatusPerkawinan = new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(stats.status_perkawinan),
                    datasets: [{
                        data: Object.values(stats.status_perkawinan),
                        backgroundColor: ['#FFC107', '#28A745', '#DC3545', '#6C757D'],
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

            // Legalitas Chart
            const ctxLegalitas = document.getElementById('chartLegalitas').getContext('2d');
            $('#loadingLegalitas').fadeOut(300, function() {
                $('#chartLegalitas').fadeIn(400);
            });

            if (chartLegalitas) chartLegalitas.destroy();

            chartLegalitas = new Chart(ctxLegalitas, {
                type: 'pie',
                data: {
                    labels: Object.keys(stats.legalitas_perkawinan),
                    datasets: [{
                        data: Object.values(stats.legalitas_perkawinan),
                        backgroundColor: ['#28A745', '#DC3545'],
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

            // Gender Chart
            const ctxGender = document.getElementById('chartGender').getContext('2d');
            $('#loadingGender').fadeOut(300, function() {
                $('#chartGender').fadeIn(400);
            });

            if (chartGender) chartGender.destroy();

            chartGender = new Chart(ctxGender, {
                type: 'bar',
                data: {
                    labels: Object.keys(stats.perkawinan_gender),
                    datasets: [{
                        label: 'Jumlah',
                        data: Object.values(stats.perkawinan_gender),
                        backgroundColor: ['#007BFF', '#E83E8C'],
                        borderRadius: 10,
                        barThickness: 60
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
                                color: 'rgba(0,0,0,0.03)'
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

            // Usia Siap Chart
            const ctxUsiaSiap = document.getElementById('chartUsiaSiap').getContext('2d');
            $('#loadingUsiaSiap').fadeOut(300, function() {
                $('#chartUsiaSiap').fadeIn(400);
            });

            if (chartUsiaSiap) chartUsiaSiap.destroy();

            chartUsiaSiap = new Chart(ctxUsiaSiap, {
                type: 'bar',
                data: {
                    labels: Object.keys(stats.usia_siap_kawin),
                    datasets: [{
                        label: 'Jumlah',
                        data: Object.values(stats.usia_siap_kawin),
                        backgroundColor: ['#28A745', '#FFC107'],
                        borderRadius: 10,
                        barThickness: 40
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
                                color: 'rgba(0,0,0,0.03)'
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

            // Distribusi Usia Chart
            const ctxDistribusi = document.getElementById('chartDistribusiUsia').getContext('2d');
            $('#loadingDistribusiUsia').fadeOut(300, function() {
                $('#chartDistribusiUsia').fadeIn(400);
            });

            if (chartDistribusiUsia) chartDistribusiUsia.destroy();

            chartDistribusiUsia = new Chart(ctxDistribusi, {
                type: 'line',
                data: {
                    labels: Object.keys(stats.distribusi_usia_kawin),
                    datasets: [{
                        label: 'Jumlah Kawin',
                        data: Object.values(stats.distribusi_usia_kawin),
                        borderColor: '#007BFF',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#007BFF',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#007BFF'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
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
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.03)'
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

        function loadTableData(tableId, kategori) {
            const filters = {
                kategori: kategori,
                rt_rw: $('#filter_rt_rw').val(),
                kp: $('#filter_kp').val(),
                jenkel_filter: $('#filter_jenkel').val()
            };

            // PERBAIKAN: Destroy dengan proper cleanup
            if ($.fn.DataTable.isDataTable('#' + tableId)) {
                $('#' + tableId).DataTable().clear().destroy();
                // Bersihkan wrapper DataTables
                $('#' + tableId).empty();
            }

            // Rebuild table structure
            const tableStructure = `
        <thead>
            <tr>
                <th width="50">No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>JK</th>
                <th>Umur</th>
                <th>Tanggal Lahir</th>
                <th>RT/RW</th>
                <th>Kampung</th>
                <th>Status</th>
                <th>Tercatat</th>
            </tr>
        </thead>
        <tbody></tbody>
    `;

            $('#' + tableId).html(tableStructure);

            tables[tableId] = $('#' + tableId).DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                autoWidth: false,
                ordering: true,
                paging: true,
                searching: true,
                info: true,
                destroy: true, // TAMBAHKAN INI
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
                    url: '{{ route('perkawinan.index') }}/datatable',
                    data: filters
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_nik',
                        name: 'no_nik'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin'
                    },
                    {
                        data: 'umur',
                        name: 'umur'
                    },
                    {
                        data: 'tgl_lahir',
                        name: 'tgl_lahir'
                    },
                    {
                        data: 'rt_rw',
                        name: 'rt_rw'
                    },
                    {
                        data: 'kp',
                        name: 'kp'
                    },
                    {
                        data: 'badge_status',
                        name: 'badge_status'
                    },
                    {
                        data: 'status_tercatat',
                        name: 'status_tercatat'
                    }
                ]
            });
        }

        function reloadAllTables() {
            Object.keys(tables).forEach(function(tableId) {
                if (tables[tableId]) {
                    tables[tableId].ajax.reload();
                }
            });
        }
    </script>
@endpush
