@extends('admin.layout.main')
@section('title', 'Statistik Pekerjaan')
@section('content-header', 'Statistik Pekerjaan')

@section('content')
    <div class="row">
        <div class="col-sm">

            <!-- KPI Cards Section -->
            <div id="kpi-section" class="kpi-grid mb-4">
                <div class="col-12">
                    <div class="py-5 text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="text-muted mt-2">Memuat data KPI...</p>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1: Distribusi Pekerjaan & Pendapatan -->
            <div class="row mb-4">
                <!-- Distribusi Pekerjaan -->
                <div class="col-lg-8 col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-briefcase mr-2"></i>Distribusi Pekerjaan</h5>
                            <small>10 Jenis Pekerjaan Terbanyak (Usia Kerja ≥15 Tahun)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-pekerjaan" class="py-5 text-center">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="text-muted mt-2">Memuat data pekerjaan...</p>
                            </div>
                            <canvas id="chartDistribusiPekerjaan" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Pendapatan -->
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-money-bill-wave mr-2"></i>Distribusi Pendapatan</h5>
                            <small>Kategori Pendapatan Per Bulan (Usia Kerja)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-pendapatan" class="py-5 text-center">
                                <div class="spinner-border text-success" role="status"></div>
                                <p class="text-muted mt-2">Memuat data pendapatan...</p>
                            </div>
                            <canvas id="chartDistribusiPendapatan" style="display:none;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row 2: Pekerjaan vs Pendapatan (UTAMA) -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-bar mr-2"></i>Analisis Pekerjaan vs Pendapatan</h5>
                            <small>Distribusi Pendapatan Berdasarkan Jenis Pekerjaan (Usia Kerja)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-cross" class="py-5 text-center">
                                <div class="spinner-border text-info" role="status"></div>
                                <p class="text-muted mt-2">Memuat analisis data...</p>
                            </div>
                            <canvas id="chartPekerjaanVsPendapatan" style="display:none; height: 450px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row 3: Status Pekerjaan & Analisis Pendapatan -->
            <div class="row mb-4">
                <!-- Status Pekerjaan Usia Kerja -->
                <div class="col-lg-5 col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-purple text-white" style="background-color: #6f42c1 !important;">
                            <h5 class="mb-0"><i class="fas fa-chart-pie mr-2"></i>Status Pekerjaan</h5>
                            <small>Usia Kerja (15-64 Tahun)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-status" class="py-5 text-center">
                                <div class="spinner-border" style="color: #6f42c1;" role="status"></div>
                                <p class="text-muted mt-2">Memuat data status...</p>
                            </div>
                            <canvas id="chartStatusPekerjaan" style="display:none; max-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Analisis Rata-rata Pendapatan -->
                <div class="col-lg-7 col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-teal text-white" style="background-color: #20c997 !important;">
                            <h5 class="mb-0"><i class="fas fa-chart-line mr-2"></i>Rata-rata Pendapatan Per Usia</h5>
                            <small>Usia Produktif (15-64 Tahun) yang Berpendapatan</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-analisis" class="py-5 text-center">
                                <div class="spinner-border text-info" role="status"></div>
                                <p class="text-muted mt-2">Memuat analisis pendapatan...</p>
                            </div>
                            <canvas id="chartAnalisisPendapatan" style="display:none; max-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 4: Gender & Usia -->
            <div class="row mb-4">
                <!-- Pekerjaan by Gender -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="fas fa-venus-mars mr-2"></i>Pekerjaan Berdasarkan Jenis Kelamin
                            </h5>
                            <small>Perbandingan Laki-Laki & Perempuan (Usia Kerja)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-gender" class="py-5 text-center">
                                <div class="spinner-border text-warning" role="status"></div>
                                <p class="text-muted mt-2">Memuat data gender...</p>
                            </div>
                            <canvas id="chartPekerjaanGender" style="display:none; max-height:400px"></canvas>

                        </div>
                    </div>
                </div>

                <!-- Pekerjaan by Usia -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="fas fa-users mr-2"></i>Pekerjaan Berdasarkan Kategori Usia</h5>
                            <small>Standar BPS: Anak s/d Lansia (6 Kategori)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-usia" class="py-5 text-center">
                                <div class="spinner-border text-secondary" role="status"></div>
                                <p class="text-muted mt-2">Memuat data usia...</p>
                            </div>
                            <canvas id="chartPekerjaanUsia" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row 5: Piramida Penduduk -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-area mr-2"></i>Piramida Penduduk Berdasarkan Usia
                            </h5>
                            <small>Distribusi Laki-Laki dan Perempuan Per Kategori Usia (Semua Umur)</small>
                        </div>
                        <div class="card-body">
                            <div id="loading-piramida" class="py-5 text-center">
                                <div class="spinner-border text-dark" role="status"></div>
                                <p class="text-muted mt-2">Memuat piramida penduduk...</p>
                            </div>
                            <canvas id="chartPiramidaPenduduk" style="display:none; height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DataTables Section with Tabs -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-gradient-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-table mr-2"></i>Detail Data Penduduk</h5>
                            <small>Pilih tab untuk melihat detail data berdasarkan kategori</small>
                        </div>
                        <div class="card-body">
                            <!-- Navigation Tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom" id="dataTableTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-pekerjaan" data-toggle="tab"
                                        href="#content-pekerjaan" role="tab">
                                        <i class="fas fa-briefcase mr-1"></i> Pekerjaan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-pendapatan" data-toggle="tab" href="#content-pendapatan"
                                        role="tab">
                                        <i class="fas fa-money-bill-wave mr-1"></i> Pendapatan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-status" data-toggle="tab" href="#content-status"
                                        role="tab">
                                        <i class="fas fa-user-check mr-1"></i> Status Pekerjaan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-gender" data-toggle="tab" href="#content-gender"
                                        role="tab">
                                        <i class="fas fa-venus-mars mr-1"></i> Gender
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-usia" data-toggle="tab" href="#content-usia"
                                        role="tab">
                                        <i class="fas fa-users mr-1"></i> Kategori Usia
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab Contents -->
                            <div class="tab-content mt-3" id="dataTableTabsContent">
                                <!-- Tab Pekerjaan -->
                                <div class="tab-pane fade show active" id="content-pekerjaan" role="tabpanel">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="filter-pekerjaan">Filter Jenis Pekerjaan:</label>
                                            <select class="form-control" id="filter-pekerjaan">
                                                <option value="">Semua Pekerjaan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button class="btn btn-primary btn-block" onclick="applyFilter('pekerjaan')">
                                                <i class="fas fa-filter mr-1"></i> Filter
                                            </button>
                                        </div>
                                        {{--  <div class="col-md-6 d-flex align-items-end justify-content-end">
                                            <button class="btn btn-success" onclick="exportTable('pekerjaan')">
                                                <i class="fas fa-file-excel mr-1"></i> Export Excel
                                            </button>
                                        </div>  --}}
                                    </div>
                                    <div class="table-responsive">
                                        <table id="table-pekerjaan" class="table-bordered table-striped table-hover table"
                                            style="width:100%">
                                            <thead class="thead-dark">
                                                <tr class="nowrap text-center">
                                                    <th style="width: 1%">No</th>
                                                    <th>NIK</th>
                                                    <th>Nama</th>
                                                    <th>Usia</th>
                                                    <th>JK</th>
                                                    <th>Pekerjaan</th>
                                                    <th>Pendapatan</th>
                                                    <th>Alamat</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tab Pendapatan -->
                                <div class="tab-pane fade" id="content-pendapatan" role="tabpanel">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="filter-pendapatan">Filter Kategori Pendapatan:</label>
                                            <select class="form-control" id="filter-pendapatan">
                                                <option value="">Semua Kategori</option>
                                                <option value="Tidak Ada">Tidak Ada</option>
                                                <option value="0-1 Juta">0 - 1 Juta</option>
                                                <option value="1-2 Juta">1 - 2 Juta</option>
                                                <option value="2-5 Juta">2 - 5 Juta</option>
                                                <option value=">5 Juta">&gt; 5 Juta</option>
                                            </select>

                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button class="btn btn-primary btn-block" onclick="applyFilter('pendapatan')">
                                                <i class="fas fa-filter mr-1"></i> Filter
                                            </button>
                                        </div>
                                        {{--  <div class="col-md-6 d-flex align-items-end justify-content-end">
                                            <button class="btn btn-success" onclick="exportTable('pendapatan')">
                                                <i class="fas fa-file-excel mr-1"></i> Export Excel
                                            </button>
                                        </div>  --}}
                                    </div>
                                    <div class="table-responsive">
                                        <table id="table-pendapatan"
                                            class="table-bordered table-striped table-hover table" style="width:100%">
                                            <thead class="thead-dark">
                                                <tr class="nowrap text-center">
                                                    <th style="width: 1%">No</th>
                                                    <th>NIK</th>
                                                    <th>Nama</th>
                                                    <th>Usia</th>
                                                    <th>JK</th>
                                                    <th>Pekerjaan</th>
                                                    <th>Pendapatan</th>
                                                    <th>Alamat</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tab Status -->
                                <div class="tab-pane fade" id="content-status" role="tabpanel">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="filter-status">Filter Status Pekerjaan:</label>
                                            <select class="form-control" id="filter-status">
                                                <option value="">Semua Status</option>
                                                <option value="Bekerja">Bekerja</option>
                                                <option value="Pengangguran">Pengangguran</option>
                                                <option value="Mengurus Rumah Tangga">Mengurus Rumah Tangga</option>
                                                <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button class="btn btn-primary btn-block" onclick="applyFilter('status')">
                                                <i class="fas fa-filter mr-1"></i> Filter
                                            </button>
                                        </div>
                                        {{--  <div class="col-md-6 d-flex align-items-end justify-content-end">
                                            <button class="btn btn-success" onclick="exportTable('status')">
                                                <i class="fas fa-file-excel mr-1"></i> Export Excel
                                            </button>
                                        </div>  --}}
                                    </div>
                                    <div class="table-responsive">
                                        <table id="table-status" class="table-bordered table-striped table-hover table"
                                            style="width:100%">
                                            <thead class="thead-dark">
                                                <tr class="nowrap text-center">
                                                    <th style="width: 1%">No</th>
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
                                        </table>
                                    </div>
                                </div>

                                <!-- Tab Gender -->
                                <div class="tab-pane fade" id="content-gender" role="tabpanel">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="filter-gender">Filter Jenis Kelamin:</label>
                                            <select class="form-control" id="filter-gender">
                                                <option value="">Semua</option>
                                                <option value="L">Laki-Laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="filter-gender-pekerjaan">Filter Pekerjaan:</label>
                                            <select class="form-control" id="filter-gender-pekerjaan">
                                                <option value="">Semua Pekerjaan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button class="btn btn-primary btn-block" onclick="applyFilter('gender')">
                                                <i class="fas fa-filter mr-1"></i> Filter
                                            </button>
                                        </div>
                                        {{--  <div class="col-md-4 d-flex align-items-end justify-content-end">
                                            <button class="btn btn-success" onclick="exportTable('gender')">
                                                <i class="fas fa-file-excel mr-1"></i> Export Excel
                                            </button>
                                        </div>  --}}
                                    </div>
                                    <div class="table-responsive">
                                        <table id="table-gender" class="table-bordered table-striped table-hover table"
                                            style="width:100%">
                                            <thead class="thead-dark">
                                                <tr class="nowrap text-center">
                                                    <th style="width: 1%">No</th>
                                                    <th>NIK</th>
                                                    <th>Nama</th>
                                                    <th>Usia</th>
                                                    <th>JK</th>
                                                    <th>Pekerjaan</th>
                                                    <th>Alamat</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tab Usia -->
                                <div class="tab-pane fade" id="content-usia" role="tabpanel">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="filter-usia">Filter Kategori Usia:</label>
                                            <select class="form-control" id="filter-usia">
                                                <option value="">Semua Kategori</option>
                                                <option value="Anak (<15)">Anak (<15) </option>
                                                <option value="Usia Sekolah (15-17)">Usia Sekolah (15-17)</option>
                                                <option value="Produktif Awal (18-24)">Produktif Awal (18-24)</option>
                                                <option value="Produktif Utama (25-44)">Produktif Utama (25-44)</option>
                                                <option value="Produktif Akhir (45-59)">Produktif Akhir (45-59)</option>
                                                <option value="Lansia (≥60)">Lansia (≥60)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button class="btn btn-primary btn-block" onclick="applyFilter('usia')">
                                                <i class="fas fa-filter mr-1"></i> Filter
                                            </button>
                                        </div>
                                        {{--  <div class="col-md-6 d-flex align-items-end justify-content-end">
                                            <button class="btn btn-success" onclick="exportTable('usia')">
                                                <i class="fas fa-file-excel mr-1"></i> Export Excel
                                            </button>
                                        </div>  --}}
                                    </div>
                                    <div class="table-responsive">
                                        <table id="table-usia" class="table-bordered table-striped table-hover table"
                                            style="width:100%">
                                            <thead class="thead-dark">
                                                <tr class="nowrap text-center">
                                                    <th style="width: 1%">No</th>
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
                                        </table>
                                    </div>
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
    <style>
        /* KPI Cards Styling */
        .kpi-card {
            border-left: 4px solid;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .kpi-card.primary {
            border-color: #007bff;
        }

        .kpi-card.success {
            border-color: #28a745;
        }

        .kpi-card.danger {
            border-color: #dc3545;
        }

        .kpi-card.warning {
            border-color: #ffc107;
        }

        .kpi-card.info {
            border-color: #17a2b8;
        }

        .kpi-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }

        .kpi-value {
            font-size: 2rem;
            font-weight: bold;
            margin: 10px 0;
        }

        .kpi-label {
            font-size: 0.9rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kpi-subtitle {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        .kpi-card {
            height: 100%;
        }

        /* Custom Tabs Styling */
        .nav-tabs-custom {
            border-bottom: 2px solid #dee2e6;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #6c757d;
            font-weight: 500;
            padding: 12px 20px;
            transition: all 0.3s;
        }

        .nav-tabs-custom .nav-link:hover {
            border-bottom-color: #007bff;
            color: #007bff;
        }

        .nav-tabs-custom .nav-link.active {
            border-bottom-color: #007bff;
            color: #007bff;
            background-color: transparent;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* DataTables Styling */
        .table-responsive {
            margin-top: 1rem;
        }

        table.dataTable {
            font-size: 0.85rem;
        }

        table.dataTable thead th {
            font-weight: 600;
            white-space: nowrap;
            background-color: #343a40;
            color: white;
        }

        table.dataTable tbody td {
            vertical-align: middle;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.5s ease-out;
        }

        @media (max-width: 768px) {
            .kpi-value {
                font-size: 1.5rem;
            }

            .kpi-icon {
                font-size: 2rem;
            }

            .nav-tabs-custom .nav-link {
                font-size: 0.85rem;
                padding: 8px 12px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
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

            // Store chart data for filters
            let chartDataList = [];

            // Color schemes
            const colors = {
                primary: ['#007bff', '#0056b3', '#004085', '#003d82', '#003366'],
                success: ['#28a745', '#20c997', '#17a2b8', '#138496', '#0e6e7e'],
                info: ['#17a2b8', '#138496', '#117a8b', '#0c6980', '#0a5875'],
                warm: ['#fd7e14', '#ffc107', '#28a745', '#20c997', '#17a2b8'],
                multi: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#20c997', '#fd7e14', '#e83e8c'],
                status: ['#28a745', '#dc3545', '#ff6b6b', '#ffc107']
            };

            // 1. Load KPI Data (Enhanced)
            function loadKPIData() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.kpi') }}',
                    method: 'GET',
                    success: function(data) {
                        const kpiHtml = `
                        <div class="card kpi-card primary shadow-sm animate-fade-in">
                            <div class="card-body text-center">
                                <i class="fas fa-users kpi-icon text-primary"></i>
                                <div class="kpi-value text-primary">${data.total_penduduk.toLocaleString()}</div>
                                <div class="kpi-label">Total Penduduk</div>
                                <div class="kpi-subtitle">Semua Usia</div>
                            </div>
                        </div>

                        <div class="card kpi-card info shadow-sm animate-fade-in">
                            <div class="card-body text-center">
                                <i class="fas fa-user-check kpi-icon text-info"></i>
                                <div class="kpi-value text-info">${data.usia_kerja.toLocaleString()}</div>
                                <div class="kpi-label">Usia Kerja</div>
                                <div class="kpi-subtitle">
                                    15–64 Tahun (${((data.usia_kerja / data.total_penduduk) * 100).toFixed(1)}%)
                                </div>
                            </div>
                        </div>

                        <div class="card kpi-card success shadow-sm animate-fade-in">
                            <div class="card-body text-center">
                                <i class="fas fa-briefcase kpi-icon text-success"></i>
                                <div class="kpi-value text-success">${data.pekerja_aktif.toLocaleString()}</div>
                                <div class="kpi-label">Pekerja Aktif</div>
                                <div class="kpi-subtitle">TPAK: ${data.tpak}%</div>
                            </div>
                        </div>

                        <div class="card kpi-card danger shadow-sm animate-fade-in">
                            <div class="card-body text-center">
                                <i class="fas fa-user-times kpi-icon text-danger"></i>
                                <div class="kpi-value text-danger">${data.persentase_pengangguran}%</div>
                                <div class="kpi-label">Pengangguran</div>
                                <div class="kpi-subtitle">${data.pengangguran.toLocaleString()} orang</div>
                            </div>
                        </div>

                        <div class="card kpi-card warning shadow-sm animate-fade-in">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-line kpi-icon text-warning"></i>
                                <div class="kpi-value text-warning">${data.pendapatan_dominan}</div>
                                <div class="kpi-label">Pendapatan Dominan</div>
                                <div class="kpi-subtitle">Semua Usia</div>
                            </div>
                        </div>
                    `;
                        $('#kpi-section').html(kpiHtml);
                    }
                });
            }


            // 2. Load Distribusi Pekerjaan
            function loadDistribusiPekerjaan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.distribusi.pekerjaan') }}',
                    method: 'GET',
                    success: function(data) {
                        chartDataList = data;

                        // Populate filter dropdown
                        $('#filter-pekerjaan, #filter-gender-pekerjaan').html(
                            '<option value="">Semua Pekerjaan</option>');
                        data.forEach(item => {
                            $('#filter-pekerjaan, #filter-gender-pekerjaan').append(
                                `<option value="${item.pekerjaan}">${item.pekerjaan} (${item.jumlah})</option>`
                            );
                        });

                        $('#loading-pekerjaan').hide();
                        $('#chartDistribusiPekerjaan').show();

                        const ctx = document.getElementById('chartDistribusiPekerjaan').getContext(
                            '2d');

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
                                    borderWidth: 1
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
                                        callbacks: {
                                            label: function(context) {
                                                return 'Jumlah: ' + context.parsed.x
                                                    .toLocaleString() + ' orang';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        $('#loading-pekerjaan').html(
                            '<div class="alert alert-danger">Gagal memuat data</div>');
                    }
                });
            }

            // 3. Load Distribusi Pendapatan
            function loadDistribusiPendapatan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.distribusi.pendapatan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-pendapatan').hide();
                        $('#chartDistribusiPendapatan').show();

                        const ctx = document.getElementById('chartDistribusiPendapatan').getContext(
                            '2d');

                        if (charts.pendapatan) charts.pendapatan.destroy();

                        charts.pendapatan = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: data.map(item => item.kategori),
                                datasets: [{
                                    data: data.map(item => item.jumlah),
                                    backgroundColor: colors.success,
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            padding: 15,
                                            font: {
                                                size: 11
                                            }
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const total = context.dataset.data.reduce((
                                                    a, b) => a + b, 0);
                                                const percentage = ((context.parsed /
                                                    total) * 100).toFixed(1);
                                                return context.label + ': ' + context.parsed
                                                    .toLocaleString() + ' (' + percentage +
                                                    '%)';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        $('#loading-pendapatan').html(
                            '<div class="alert alert-danger">Gagal memuat data</div>');
                    }
                });
            }

            // 4. Load Pekerjaan vs Pendapatan
            function loadPekerjaanVsPendapatan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.pekerjaan.pendapatan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-cross').hide();
                        $('#chartPekerjaanVsPendapatan').show();

                        const ctx = document.getElementById('chartPekerjaanVsPendapatan').getContext(
                            '2d');

                        if (charts.cross) charts.cross.destroy();

                        const datasets = data.datasets.map((dataset, index) => ({
                            label: dataset.label,
                            data: dataset.data,
                            backgroundColor: colors.info[index % colors.info.length],
                            borderWidth: 0
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
                                            padding: 15
                                        }
                                    },
                                    tooltip: {
                                        mode: 'index',
                                        intersect: false,
                                        callbacks: {
                                            footer: function(tooltipItems) {
                                                let sum = 0;
                                                tooltipItems.forEach(function(tooltipItem) {
                                                    sum += tooltipItem.parsed.y;
                                                });
                                                return 'Total: ' + sum.toLocaleString() +
                                                    ' orang';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        stacked: true,
                                        ticks: {
                                            font: {
                                                size: 10
                                            }
                                        }
                                    },
                                    y: {
                                        stacked: true,
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        $('#loading-cross').html(
                            '<div class="alert alert-danger">Gagal memuat data</div>');
                    }
                });
            }

            // 5. Load Status Pekerjaan (NEW)
            function loadStatusPekerjaan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.status.pekerjaan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-status').hide();
                        $('#chartStatusPekerjaan').show();

                        const ctx = document.getElementById('chartStatusPekerjaan').getContext('2d');

                        if (charts.status) charts.status.destroy();

                        charts.status = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: data.map(item => item.status),
                                datasets: [{
                                    data: data.map(item => item.jumlah),
                                    backgroundColor: colors.status,
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            padding: 12
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const total = context.dataset.data.reduce((
                                                    a, b) => a + b, 0);
                                                const percentage = ((context.parsed /
                                                    total) * 100).toFixed(1);
                                                return context.label + ': ' + context.parsed
                                                    .toLocaleString() + ' (' + percentage +
                                                    '%)';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        $('#loading-status').html(
                            '<div class="alert alert-danger">Gagal memuat data</div>');
                    }
                });
            }

            // 6. Load Analisis Pendapatan (NEW)
            function loadAnalisisPendapatan() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.analisis.pendapatan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-analisis').hide();
                        $('#chartAnalisisPendapatan').show();

                        const ctx = document.getElementById('chartAnalisisPendapatan').getContext('2d');

                        if (charts.analisis) charts.analisis.destroy();

                        charts.analisis = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.map(item => item.kategori_usia),
                                datasets: [{
                                    label: 'Rata-rata Pendapatan',
                                    data: data.map(item => item.rata_pendapatan),
                                    backgroundColor: '#20c997',
                                    borderColor: '#17a085',
                                    borderWidth: 1
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
                                        callbacks: {
                                            label: function(context) {
                                                return 'Rata-rata: Rp ' + context.parsed.y
                                                    .toLocaleString('id-ID');
                                            },
                                            afterLabel: function(context) {
                                                const index = context.dataIndex;
                                                return [
                                                    'Min: Rp ' + data[index]
                                                    .min_pendapatan.toLocaleString(
                                                        'id-ID'),
                                                    'Max: Rp ' + data[index]
                                                    .max_pendapatan.toLocaleString(
                                                        'id-ID'),
                                                    'Jumlah: ' + data[index].jumlah
                                                    .toLocaleString() + ' orang'
                                                ];
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading analisis data:', error);
                        $('#loading-analisis').html(
                            '<div class="alert alert-danger">Gagal memuat data: ' + error + '</div>'
                        );
                    }
                });
            }

            // 7. Load Pekerjaan by Gender (FIXED)
            function loadPekerjaanByGender() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.pekerjaan.gender') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-gender').hide();
                        $('#chartPekerjaanGender').show();

                        const ctx = document.getElementById('chartPekerjaanGender').getContext('2d');

                        if (charts.gender) charts.gender.destroy();

                        charts.gender = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                        label: 'Laki-Laki',
                                        data: data.datasets[0].data,
                                        backgroundColor: '#007bff',
                                        borderWidth: 0
                                    },
                                    {
                                        label: 'Perempuan',
                                        data: data.datasets[1].data,
                                        backgroundColor: '#e83e8c',
                                        borderWidth: 0
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            footer: function(tooltipItems) {
                                                let sum = 0;
                                                tooltipItems.forEach(function(tooltipItem) {
                                                    sum += tooltipItem.parsed.y;
                                                });
                                                return 'Total: ' + sum.toLocaleString() +
                                                    ' orang';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        ticks: {
                                            font: {
                                                size: 10
                                            }
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading gender data:', error);
                        $('#loading-gender').html(
                            '<div class="alert alert-danger">Gagal memuat data: ' + error + '</div>'
                        );
                    }
                });
            }

            // 8. Load Pekerjaan by Usia
            function loadPekerjaanByUsia() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.pekerjaan.usia') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-usia').hide();
                        $('#chartPekerjaanUsia').show();

                        const ctx = document.getElementById('chartPekerjaanUsia').getContext('2d');

                        if (charts.usia) charts.usia.destroy();

                        const usiaColors = [
                            '#ff6b6b', '#4ecdc4', '#45b7d1',
                            '#96ceb4', '#ffeaa7', '#dfe6e9'
                        ];

                        const datasets = data.datasets.map((dataset, index) => ({
                            label: dataset.label,
                            data: dataset.data,
                            backgroundColor: usiaColors[index],
                            borderWidth: 0
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
                                                size: 10
                                            },
                                            padding: 10
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            footer: function(tooltipItems) {
                                                let sum = 0;
                                                tooltipItems.forEach(function(tooltipItem) {
                                                    sum += tooltipItem.parsed.y;
                                                });
                                                return 'Total: ' + sum.toLocaleString() +
                                                    ' orang';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        stacked: true,
                                        ticks: {
                                            font: {
                                                size: 9
                                            }
                                        }
                                    },
                                    y: {
                                        stacked: true,
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading usia data:', error);
                        $('#loading-usia').html('<div class="alert alert-danger">Gagal memuat data: ' +
                            error + '</div>');
                    }
                });
            }

            // 9. Load Piramida Penduduk (FIXED)
            function loadPiramidaPenduduk() {
                $.ajax({
                    url: '{{ route('pekerjaan.api.distribusi.usia') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-piramida').hide();
                        $('#chartPiramidaPenduduk').show();

                        const ctx = document.getElementById('chartPiramidaPenduduk').getContext('2d');

                        if (charts.piramida) charts.piramida.destroy();

                        charts.piramida = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                        label: 'Laki-Laki',
                                        data: data.datasets[0].data,
                                        backgroundColor: '#007bff',
                                        borderWidth: 0
                                    },
                                    {
                                        label: 'Perempuan',
                                        data: data.datasets[1].data,
                                        backgroundColor: '#e83e8c',
                                        borderWidth: 0
                                    }
                                ]
                            },
                            options: {
                                indexAxis: 'y',
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const value = Math.abs(context.parsed.x);
                                                return context.dataset.label + ': ' + value
                                                    .toLocaleString() + ' orang';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        ticks: {
                                            callback: function(value) {
                                                return Math.abs(value).toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading piramida data:', error);
                        $('#loading-piramida').html(
                            '<div class="alert alert-danger">Gagal memuat data: ' + error + '</div>'
                        );
                    }
                });
            }

            // Initialize all charts
            function initializeCharts() {
                loadKPIData();
                loadDistribusiPekerjaan();
                loadDistribusiPendapatan();
                loadPekerjaanVsPendapatan();
                loadStatusPekerjaan();
                loadAnalisisPendapatan();
                loadPekerjaanByGender();
                loadPekerjaanByUsia();
                loadPiramidaPenduduk();
            }

            // Run on page load
            initializeCharts();

            // ============= DataTable Functions =============

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
                    ordering: true,
                    paging: true,
                    searching: true,
                    info: true,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
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
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nik',
                            name: 'nik',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            className: 'nowrap'
                        },
                        {
                            data: 'usia',
                            name: 'usia',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'jenis_kelamin',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'pekerjaan',
                            name: 'pekerjaan',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'kategori_pendapatan',
                            name: 'kategori_pendapatan',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'alamat_kk',
                            name: 'alamat_kk',
                            className: 'nowrap'
                        }
                    ],
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
                    ordering: true,
                    paging: true,
                    searching: true,
                    info: true,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
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
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nik',
                            name: 'nik',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            className: 'nowrap'
                        },
                        {
                            data: 'usia',
                            name: 'usia',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'jenis_kelamin',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'pekerjaan',
                            name: 'pekerjaan',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'pendapatan_perbulan',
                            name: 'pendapatan_perbulan',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'alamat_kk',
                            name: 'alamat_kk',
                            className: 'nowrap'
                        }
                    ],
                });
            }

            // Initialize DataTable Status
            function initTableStatus() {
                if (dataTables.status) {
                    dataTables.status.destroy();
                }

                dataTables.status = $('#table-status').DataTable({
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
                        [10, 25, 50, 100, "All"]
                    ],
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
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nik',
                            name: 'nik',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            className: 'nowrap'
                        },
                        {
                            data: 'usia',
                            name: 'usia',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'jenis_kelamin',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'pekerjaan',
                            name: 'pekerjaan',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'status_pekerjaan',
                            name: 'status_pekerjaan',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'pendapatan_perbulan',
                            name: 'pendapatan_perbulan',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'alamat_kk',
                            name: 'alamat_kk',
                            className: 'nowrap'
                        }
                    ],
                });
            }


            // Initialize DataTable Gender
            function initTableGender() {
                if (dataTables.gender) {
                    dataTables.gender.destroy();
                }

                dataTables.gender = $('#table-gender').DataTable({
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
                        [10, 25, 50, 100, "All"]
                    ],
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
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nik',
                            name: 'nik',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            className: 'text-left nowrap'
                        },
                        {
                            data: 'usia',
                            name: 'usia',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'jenis_kelamin',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'pekerjaan',
                            name: 'pekerjaan',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'alamat_kk',
                            name: 'alamat_kk',
                            className: 'text-left nowrap'
                        }
                    ],
                });
            }

            // Initialize DataTable Usia
            function initTableUsia() {
                if (dataTables.usia) {
                    dataTables.usia.destroy();
                }

                dataTables.usia = $('#table-usia').DataTable({
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
                        [10, 25, 50, 100, "All"]
                    ],
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
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nik',
                            name: 'nik',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            className: 'text-left nowrap'
                        },
                        {
                            data: 'tgl_lahir',
                            name: 'tgl_lahir',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'usia',
                            name: 'usia',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'kategori_usia',
                            name: 'kategori_usia',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'jenis_kelamin',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'pekerjaan',
                            name: 'pekerjaan',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'alamat_kk',
                            name: 'alamat_kk',
                            className: 'text-left nowrap'
                        }
                    ],
                });
            }

            // Tab change handler
            $('#dataTableTabs a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                const target = $(e.target).attr('href');

                switch (target) {
                    case '#content-pekerjaan':
                        if (!dataTables.pekerjaan) {
                            initTablePekerjaan();
                        }
                        break;
                    case '#content-pendapatan':
                        if (!dataTables.pendapatan) {
                            initTablePendapatan();
                        }
                        break;
                    case '#content-status':
                        if (!dataTables.status) {
                            initTableStatus();
                        }
                        break;
                    case '#content-gender':
                        if (!dataTables.gender) {
                            initTableGender();
                        }
                        break;
                    case '#content-usia':
                        if (!dataTables.usia) {
                            initTableUsia();
                        }
                        break;
                }
            });

            // Initialize first tab
            initTablePekerjaan();

            // Apply Filter Function
            window.applyFilter = function(type) {
                switch (type) {
                    case 'pekerjaan':
                        if (dataTables.pekerjaan) {
                            dataTables.pekerjaan.ajax.reload();
                        }
                        break;
                    case 'pendapatan':
                        if (dataTables.pendapatan) {
                            dataTables.pendapatan.ajax.reload();
                        }
                        break;
                    case 'status':
                        if (dataTables.status) {
                            dataTables.status.ajax.reload();
                        }
                        break;
                    case 'gender':
                        if (dataTables.gender) {
                            dataTables.gender.ajax.reload();
                        }
                        break;
                    case 'usia':
                        if (dataTables.usia) {
                            dataTables.usia.ajax.reload();
                        }
                        break;
                }
            }

            // Export Function
            window.exportTable = function(type) {
                let table = null;
                let filename = 'Detail_Data_Penduduk_';

                switch (type) {
                    case 'pekerjaan':
                        table = dataTables.pekerjaan;
                        filename += 'Pekerjaan';
                        break;
                    case 'pendapatan':
                        table = dataTables.pendapatan;
                        filename += 'Pendapatan';
                        break;
                    case 'status':
                        table = dataTables.status;
                        filename += 'Status';
                        break;
                    case 'gender':
                        table = dataTables.gender;
                        filename += 'Gender';
                        break;
                    case 'usia':
                        table = dataTables.usia;
                        filename += 'Usia';
                        break;
                }

                if (table) {
                    // Get current filter values
                    let params = new URLSearchParams();

                    switch (type) {
                        case 'pekerjaan':
                            if ($('#filter-pekerjaan').val()) {
                                params.append('pekerjaan', $('#filter-pekerjaan').val());
                            }
                            break;
                        case 'pendapatan':
                            if ($('#filter-pendapatan').val()) {
                                params.append('kategori', $('#filter-pendapatan').val());
                            }
                            break;
                        case 'status':
                            if ($('#filter-status').val()) {
                                params.append('status', $('#filter-status').val());
                            }
                            break;
                        case 'gender':
                            if ($('#filter-gender').val()) {
                                params.append('gender', $('#filter-gender').val());
                            }
                            if ($('#filter-gender-pekerjaan').val()) {
                                params.append('pekerjaan', $('#filter-gender-pekerjaan').val());
                            }
                            break;
                        case 'usia':
                            if ($('#filter-usia').val()) {
                                params.append('kategori_usia', $('#filter-usia').val());
                            }
                            break;
                    }

                    params.append('export', 'excel');

                    // Create download URL
                    let exportUrl = table.ajax.url() + '?' + params.toString();

                    // Simple export using current data
                    alert(
                        'Fitur export Excel akan segera tersedia. Saat ini Anda dapat menggunakan copy/print dari menu DataTables.'
                    );
                }
            }
        });
    </script>
@endpush
