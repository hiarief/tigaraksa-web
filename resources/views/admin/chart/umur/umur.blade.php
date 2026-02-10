@extends('admin.layout.main')
@section('title', 'Statistik Umur')
@section('content-header', 'Statistik Umur')

@section('content')

    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card-premium elevation-2">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-users"></i>
                        </div>

                        <div class="ml-3">
                            <h5 class="font-weight-bold mb-1">Ringkasan Statistik Umur</h5>
                            <p class="stat-sublabel-premium mb-0">
                                Data diperbarui secara otomatis berdasarkan database terkini
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium Tabs Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3" style="margin-bottom: 0;">
                <div class="pills-container-premium">
                    <ul class="nav nav-pills-premium" id="umurTab" role="tablist">
                        <li class="nav-item-premium">
                            <a class="nav-link-premium active" id="semua-tab" data-toggle="pill" href="#semua">
                                <div class="pill-icon"><i class="fas fa-users"></i></div>
                                <div class="pill-text">
                                    <span class="pill-title">Semua Penduduk</span>
                                    <span class="pill-subtitle">Data lengkap populasi</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item-premium">
                            <a class="nav-link-premium" id="pemilih-tab" data-toggle="pill" href="#pemilih">
                                <div class="pill-icon"><i class="fas fa-vote-yea"></i></div>
                                <div class="pill-text">
                                    <span class="pill-title">Pemilih (17+ Tahun)</span>
                                    <span class="pill-subtitle">Pemilih potensial</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <!-- Tab Content -->
    <div class="tab-content" id="umurTabContent">
        <!-- Tab Semua Penduduk -->
        <div class="tab-pane fade show active" id="semua" role="tabpanel">
            <!-- Statistik Cards -->
            <div class="row">

                <!-- Total Penduduk -->
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="stat-card-premium elevation-2">
                        <div class="stat-card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-primary text-white" style="width: 50px; height: 50px;">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium mb-0" id="totalPenduduk">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        Total Penduduk
                                        <i class="fas fa-users stat-mini-icon"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Laki-laki -->
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="stat-card-premium elevation-2">
                        <div class="stat-card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white" style="width: 50px; height: 50px;">
                                    <i class="fas fa-male"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium mb-0" id="totalLaki">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        Laki-laki
                                        <i class="fas fa-male stat-mini-icon"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Perempuan -->
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="stat-card-premium elevation-2">
                        <div class="stat-card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white" style="width: 50px; height: 50px;">
                                    <i class="fas fa-female"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium mb-0" id="totalPerempuan">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        Perempuan
                                        <i class="fas fa-female stat-mini-icon"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="stat-card-premium elevation-2">
                        <div class="stat-card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white" style="width: 50px; height: 50px;">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium mb-0" id="rasio">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>
                                    <p class="stat-label-premium mb-0">
                                        Rasio Jenis Kelamin
                                        <i class="fas fa-chart-line stat-mini-icon"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-6 col-12 mb-4">
                    <!-- Note Rasio -->
                    <div class="alert-premium-info mt-2">
                        <div class="alert-icon-premium">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="alert-content-premium">
                            <small id="noteRasio" class="text-muted">-</small>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <!-- Card Piramida Penduduk -->
                <div class="col-12 mb-4">
                    <div class="card card-widget-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Piramida Penduduk</h3>
                                <p class="card-subtitle-premium">Distribusi penduduk berdasarkan umur dan jenis kelamin</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingPiramida" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <div style="display:none; position: relative; height: 500px;" id="piramidaContainer">
                                <canvas id="piramidaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Distribusi Kelompok Umur -->
                <div class="col-lg-6 mb-4">
                    <div class="card card-widget-premium elevation-3">
                        <div class="card-header-premium bg-gradient-info">
                            <div class="card-header-icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Kelompok Umur</h3>
                                <p class="card-subtitle-premium">Proporsi kelompok usia</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingDistribusi" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="distribusiChart" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Card Data Detail Semua Penduduk -->
                <div class="col-12 mb-4">
                    <div class="card card-widget-premium elevation-3">
                        <div class="card-header-premium bg-gradient-dark">
                            <div class="card-header-icon">
                                <i class="fas fa-table"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Data Detail Semua Penduduk</h3>
                                <p class="card-subtitle-premium">Daftar lengkap penduduk dengan filter</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <!-- Filter Section Premium -->
                            <div class="filter-section-premium mb-4">
                                <div class="row">
                                    <div class="col-md-3 mb-md-0 mb-3">
                                        <label class="filter-label-premium">
                                            <i class="fas fa-map-marked-alt mr-1"></i>Filter RW
                                        </label>
                                        <select id="filterRWSemua" class="form-control-premium select2-premium">
                                            <option value="">Semua RW</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-md-0 mb-3">
                                        <label class="filter-label-premium">
                                            <i class="fas fa-map-marker-alt mr-1"></i>Filter RT
                                        </label>
                                        <select id="filterRTSemua" class="form-control-premium select2-premium">
                                            <option value="">Semua RT</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-md-0 mb-3">
                                        <label class="filter-label-premium">&nbsp;</label>
                                        <button type="button" id="btnFilterSemua"
                                            class="btn btn-filter-premium btn-block">
                                            <i class="fas fa-filter mr-2"></i>Terapkan Filter
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="filter-label-premium">&nbsp;</label>
                                        <button type="button" id="btnResetSemua"
                                            class="btn btn-reset-premium btn-block">
                                            <i class="fas fa-redo mr-2"></i>Reset Filter
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabs RW Premium -->
                            <div class="sub-tabs-container">
                                <ul class="nav nav-tabs-premium" id="rwTabsSemua" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#" data-rw="">
                                            <i class="fas fa-list mr-1"></i>Semua
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- DataTable Container -->
                            <div class="table-container-premium">
                                <div class="table-responsive">
                                    <table class="table-premium" id="detailTableSemuaPenduduk" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="1%">NO</th>
                                                <th>NIK</th>
                                                <th>NAMA</th>
                                                <th>KK</th>
                                                <th>JK</th>
                                                <th>TANGGAL LAHIR</th>
                                                <th>UMUR</th>
                                                <th>ALAMAT</th>
                                                <th>RT/RW</th>
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

        <!-- Tab Pemilih -->
        <div class="tab-pane fade" id="pemilih" role="tabpanel">
            <!-- Statistik Pemilih -->
            <div class="row">

                <!-- Total Pemilih -->
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="stat-card-premium elevation-2">
                        <div class="stat-card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white" style="width:50px;height:50px;">
                                    <i class="fas fa-users"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium mb-0" id="totalPemilih">-</p>
                                    <p class="stat-label-premium mb-0">
                                        Total Pemilih
                                        <i class="fas fa-users stat-mini-icon"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pemilih Laki -->
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="stat-card-premium elevation-2">
                        <div class="stat-card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white" style="width:50px;height:50px;">
                                    <i class="fas fa-male"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium mb-0" id="pemilihLaki">-</p>
                                    <p class="stat-label-premium mb-0">
                                        Laki-laki
                                        <i class="fas fa-male stat-mini-icon"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pemilih Perempuan -->
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="stat-card-premium elevation-2">
                        <div class="stat-card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white" style="width:50px;height:50px;">
                                    <i class="fas fa-female"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium mb-0" id="pemilihPerempuan">-</p>
                                    <p class="stat-label-premium mb-0">
                                        Perempuan
                                        <i class="fas fa-female stat-mini-icon"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rasio -->
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="stat-card-premium elevation-2">
                        <div class="stat-card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white" style="width:50px;height:50px;">
                                    <i class="fas fa-percentage"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium mb-0" id="persenPemilih">-</p>
                                    <p class="stat-label-premium mb-0">
                                        Rasio (L : 100P)
                                        <i class="fas fa-percentage stat-mini-icon"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <!-- Card Piramida Pemilih -->
                <div class="col-12 mb-4">
                    <div class="card card-widget-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Piramida Pemilih (17+ Tahun)</h3>
                                <p class="card-subtitle-premium">Distribusi pemilih potensial berdasarkan umur dan jenis
                                    kelamin</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingPiramidaPemilih" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <div style="display:none; position: relative; height: 500px;" id="piramidaPemilihContainer">
                                <canvas id="piramidaPemilihChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Card Data Pemilih (DataTables) -->
                <div class="col-12 mb-4">
                    <div class="card card-widget-premium elevation-3">
                        <div class="card-header-premium bg-gradient-purple">
                            <div class="card-header-icon">
                                <i class="fas fa-table"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Data Detail Pemilih</h3>
                                <p class="card-subtitle-premium">Daftar lengkap pemilih dengan filter</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <!-- Filter Section Premium -->
                            <div class="filter-section-premium mb-4">
                                <div class="row">
                                    <div class="col-md-3 mb-md-0 mb-3">
                                        <label class="filter-label-premium">
                                            <i class="fas fa-map-marked-alt mr-1"></i>Filter RW
                                        </label>
                                        <select id="filterRWPemilih" class="form-control-premium select2-premium">
                                            <option value="">Semua RW</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-md-0 mb-3">
                                        <label class="filter-label-premium">
                                            <i class="fas fa-map-marker-alt mr-1"></i>Filter RT
                                        </label>
                                        <select id="filterRTPemilih" class="form-control-premium select2-premium">
                                            <option value="">Semua RT</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-md-0 mb-3">
                                        <label class="filter-label-premium">&nbsp;</label>
                                        <button type="button" id="btnFilterPemilih"
                                            class="btn btn-filter-premium btn-block">
                                            <i class="fas fa-filter mr-2"></i>Terapkan Filter
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="filter-label-premium">&nbsp;</label>
                                        <button type="button" id="btnResetPemilih"
                                            class="btn btn-reset-premium btn-block">
                                            <i class="fas fa-redo mr-2"></i>Reset Filter
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabs RW Premium -->
                            <div class="sub-tabs-container">
                                <ul class="nav nav-tabs-premium" id="rwTabsPemilih" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#" data-rw="">
                                            <i class="fas fa-list mr-1"></i>Semua
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- DataTable Container -->
                            <div class="table-container-premium">
                                <div class="table-responsive">
                                    <table class="table-premium" id="detailTable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="1%">NO</th>
                                                <th>NIK</th>
                                                <th>NAMA</th>
                                                <th>KK</th>
                                                <th>JK</th>
                                                <th>TANGGAL LAHIR</th>
                                                <th>UMUR</th>
                                                <th>ALAMAT</th>
                                                <th>RT/RW</th>
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
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        let piramidaChart = null;
        let distribusiChart = null;
        let piramidaPemilihChart = null;
        let detailTable = null;
        let detailTableSemua = null;

        let currentRWSemua = '';
        let currentRTSemua = '';
        let currentRWPemilih = '';
        let currentRTPemilih = '';

        $(document).ready(function() {
            // Initialize Select2 with premium theme
            $('.select2-premium').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            loadData();
            loadRWList();

            initDataTableSemuaPenduduk();

            // Tab switching handler
            $('#umurTab a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                if (piramidaChart) piramidaChart.resize();
                if (distribusiChart) distribusiChart.resize();
                if (piramidaPemilihChart) piramidaPemilihChart.resize();

                if ($(e.target).attr('href') === '#pemilih' && !detailTable) {
                    initDataTable();
                }
            });

            // Filter untuk Tab Semua Penduduk
            $('#filterRWSemua').on('change', function() {
                loadRTList($(this).val(), 'semua');
            });

            $('#btnFilterSemua').on('click', function() {
                currentRWSemua = $('#filterRWSemua').val();
                currentRTSemua = $('#filterRTSemua').val();
                if (detailTableSemua) detailTableSemua.ajax.reload();
            });

            $('#btnResetSemua').on('click', function() {
                currentRWSemua = '';
                currentRTSemua = '';
                $('#filterRWSemua').val('').trigger('change');
                $('#filterRTSemua').val('').trigger('change');
                loadRTList('', 'semua');
                if (detailTableSemua) detailTableSemua.ajax.reload();
            });

            // Filter untuk Tab Pemilih
            $('#filterRWPemilih').on('change', function() {
                loadRTList($(this).val(), 'pemilih');
            });

            $('#btnFilterPemilih').on('click', function() {
                currentRWPemilih = $('#filterRWPemilih').val();
                currentRTPemilih = $('#filterRTPemilih').val();
                if (detailTable) detailTable.ajax.reload();
            });

            $('#btnResetPemilih').on('click', function() {
                currentRWPemilih = '';
                currentRTPemilih = '';
                $('#filterRWPemilih').val('').trigger('change');
                $('#filterRTPemilih').val('').trigger('change');
                loadRTList('', 'pemilih');
                if (detailTable) detailTable.ajax.reload();
            });

            // Tab RW untuk Semua Penduduk
            $(document).on('click', '#rwTabsSemua .nav-link', function(e) {
                e.preventDefault();
                $('#rwTabsSemua .nav-link').removeClass('active');
                $(this).addClass('active');

                currentRWSemua = $(this).data('rw');
                currentRTSemua = '';
                loadRTList(currentRWSemua, 'semua');

                if (detailTableSemua) detailTableSemua.ajax.reload();
            });

            // Tab RW untuk Pemilih
            $(document).on('click', '#rwTabsPemilih .nav-link', function(e) {
                e.preventDefault();
                $('#rwTabsPemilih .nav-link').removeClass('active');
                $(this).addClass('active');

                currentRWPemilih = $(this).data('rw');
                currentRTPemilih = '';
                loadRTList(currentRWPemilih, 'pemilih');

                if (detailTable) detailTable.ajax.reload();
            });
        });

        /* =========================
           LOAD DATA UTAMA
        ========================= */
        function loadData() {
            $.get('{{ route('umur.data') }}', function(res) {
                renderPiramida(res.kelompok_umur);
                renderDistribusi(res.kelompok_umur);
                renderStatistik(res.kelompok_umur);

                renderPiramidaPemilih(res.pemilih);
                renderStatistikPemilih(res.pemilih);
            });
        }

        /* =========================
           RW & RT
        ========================= */
        function loadRWList() {
            $.get('{{ route('umur.rw.list') }}', function(data) {
                let rwSelectSemua = $('#filterRWSemua');
                let rwSelectPemilih = $('#filterRWPemilih');
                let rwTabsSemua = $('#rwTabsSemua');
                let rwTabsPemilih = $('#rwTabsPemilih');

                data.forEach(rw => {
                    rwSelectSemua.append(`<option value="${rw}">RW ${rw}</option>`);
                    rwSelectPemilih.append(`<option value="${rw}">RW ${rw}</option>`);

                    rwTabsSemua.append(`
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-rw="${rw}">RW ${rw}</a>
                        </li>
                    `);

                    rwTabsPemilih.append(`
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-rw="${rw}">RW ${rw}</a>
                        </li>
                    `);
                });
            });
        }

        function loadRTList(rw, type) {
            $.get('{{ route('umur.rt.list') }}', {
                rw
            }, function(data) {
                let rtSelect = type === 'semua' ? $('#filterRTSemua') : $('#filterRTPemilih');
                rtSelect.html('<option value="">Semua RT</option>');
                data.forEach(rt => {
                    rtSelect.append(`<option value="${rt}">RT ${rt}</option>`);
                });
            });
        }

        /* =========================
           DATA PARSER PIRAMIDA
        ========================= */
        function parsePiramida(data) {
            let labels = [];
            let laki = [];
            let perempuan = [];
            let map = {};

            data.forEach(d => {
                if (!map[d.kelompok_umur]) {
                    map[d.kelompok_umur] = {
                        L: 0,
                        P: 0
                    };
                    labels.push(d.kelompok_umur);
                }
                if (d.jenkel == 1) map[d.kelompok_umur].L += d.jumlah;
                if (d.jenkel == 2) map[d.kelompok_umur].P += d.jumlah;
            });

            labels.forEach(k => {
                laki.push(-map[k].L);
                perempuan.push(map[k].P);
            });

            return {
                labels,
                laki,
                perempuan
            };
        }

        /* =========================
           PIRAMIDA PENDUDUK
        ========================= */
        function renderPiramida(data) {
            const parsed = parsePiramida(data);

            $('#loadingPiramida').fadeOut(300, function() {
                $('#piramidaContainer').fadeIn(400);
            });

            if (piramidaChart) piramidaChart.destroy();

            piramidaChart = new Chart(document.getElementById('piramidaChart'), {
                type: 'bar',
                data: {
                    labels: parsed.labels,
                    datasets: [{
                            label: 'Laki-laki',
                            data: parsed.laki,
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            borderRadius: 6
                        },
                        {
                            label: 'Perempuan',
                            data: parsed.perempuan,
                            backgroundColor: 'rgba(255, 99, 132, 0.8)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
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
                                    let label = context.dataset.label || '';
                                    let value = Math.abs(context.parsed.x);
                                    return label + ': ' + value.toLocaleString('id-ID') + ' orang';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return Math.abs(value).toLocaleString('id-ID');
                                },
                                font: {
                                    size: 12
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
        }

        /* =========================
           DISTRIBUSI UMUR
        ========================= */
        function renderDistribusi(data) {
            let map = {};
            data.forEach(d => {
                map[d.kelompok_umur] = (map[d.kelompok_umur] || 0) + d.jumlah;
            });

            $('#loadingDistribusi').fadeOut(300, function() {
                $('#distribusiChart').fadeIn(400);
            });

            if (distribusiChart) distribusiChart.destroy();

            distribusiChart = new Chart(document.getElementById('distribusiChart'), {
                type: 'doughnut',
                data: {
                    labels: Object.keys(map),
                    datasets: [{
                        data: Object.values(map),
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                            '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384',
                            '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF'
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
                            position: 'right',
                            labels: {
                                font: {
                                    size: 12
                                },
                                usePointStyle: true,
                                padding: 15
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
                                    let label = context.label || '';
                                    let value = context.parsed;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(1);
                                    return label + ': ' + value.toLocaleString('id-ID') + ' (' + percentage +
                                        '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

        /* =========================
           STATISTIK PENDUDUK
        ========================= */
        function renderStatistik(data) {
            let L = 0,
                P = 0;

            data.forEach(d => {
                if (d.jenkel == 1) L += d.jumlah;
                if (d.jenkel == 2) P += d.jumlah;
            });

            let total = L + P;
            let rasio = P ? ((L / P) * 100).toFixed(2) : 0;

            $('#totalPenduduk').text(total.toLocaleString('id-ID'));
            $('#totalLaki').text(L.toLocaleString('id-ID'));
            $('#totalPerempuan').text(P.toLocaleString('id-ID'));
            $('#rasio').text(rasio + ' : 100');

            let rasioAngka = parseFloat(rasio);
            let noteRasio = '';

            if (rasioAngka > 100) {
                noteRasio =
                    `Rasio jenis kelamin ${rasioAngka.toFixed(2)} menunjukkan terdapat lebih banyak laki-laki dibandingkan perempuan di wilayah ini (${rasioAngka.toFixed(2)} laki-laki per 100 perempuan).`;
            } else if (rasioAngka < 100) {
                noteRasio =
                    `Rasio jenis kelamin ${rasioAngka.toFixed(2)} menunjukkan terdapat lebih banyak perempuan dibandingkan laki-laki di wilayah ini (${rasioAngka.toFixed(2)} laki-laki per 100 perempuan).`;
            } else {
                noteRasio =
                    `Rasio jenis kelamin ${rasioAngka.toFixed(2)} menunjukkan jumlah laki-laki dan perempuan relatif seimbang di wilayah ini.`;
            }

            $('#noteRasio').text(noteRasio);

            $('#loadingStats').fadeOut(300, function() {
                $('#statistikContent').fadeIn(400);
            });
        }

        /* =========================
           PIRAMIDA PEMILIH
        ========================= */
        function renderPiramidaPemilih(data) {
            const parsed = parsePiramida(data);

            $('#loadingPiramidaPemilih').fadeOut(300, function() {
                $('#piramidaPemilihContainer').fadeIn(400);
            });

            if (piramidaPemilihChart) piramidaPemilihChart.destroy();

            piramidaPemilihChart = new Chart(document.getElementById('piramidaPemilihChart'), {
                type: 'bar',
                data: {
                    labels: parsed.labels,
                    datasets: [{
                            label: 'Laki-laki',
                            data: parsed.laki,
                            backgroundColor: 'rgba(75, 192, 192, 0.8)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            borderRadius: 6
                        },
                        {
                            label: 'Perempuan',
                            data: parsed.perempuan,
                            backgroundColor: 'rgba(255, 159, 64, 0.8)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 2,
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
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
                                    let label = context.dataset.label || '';
                                    let value = Math.abs(context.parsed.x);
                                    return label + ': ' + value.toLocaleString('id-ID') + ' orang';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return Math.abs(value).toLocaleString('id-ID');
                                },
                                font: {
                                    size: 12
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
        }

        /* =========================
           STATISTIK PEMILIH
        ========================= */
        function renderStatistikPemilih(data) {
            let L = 0,
                P = 0;
            data.forEach(d => {
                if (d.jenkel == 1) L += d.jumlah;
                if (d.jenkel == 2) P += d.jumlah;
            });

            let total = L + P;
            let rasio = P ? ((L / P) * 100).toFixed(2) : 0;

            $('#totalPemilih').text(total.toLocaleString('id-ID'));
            $('#pemilihLaki').text(L.toLocaleString('id-ID'));
            $('#pemilihPerempuan').text(P.toLocaleString('id-ID'));
            $('#persenPemilih').text(rasio);

            $('#loadingStatsPemilih').fadeOut(300, function() {
                $('#statistikPemilihContent').fadeIn(400);
            });
        }

        /* =========================
           DATATABLE PEMILIH
        ========================= */
        function initDataTable() {
            detailTable = $('#detailTable').DataTable({
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
                    lengthMenu: 'Tampilkan _MENU_ data',
                    zeroRecords: 'Data tidak ditemukan',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
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
                    url: '{{ route('umur.pemilih') }}',
                    data: function(d) {
                        d.rw = currentRWPemilih;
                        d.rt = currentRTPemilih;
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
                        className: 'text-center',
                        defaultContent: '-'
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        defaultContent: '-'
                    },
                    {
                        data: 'no_kk',
                        name: 'no_kk',
                        className: 'text-center',
                        defaultContent: '-'
                    },
                    {
                        data: 'jenkel',
                        name: 'jenkel',
                        className: 'text-center'
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
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ]
            });
        }

        /* =========================
           DATATABLE SEMUA PENDUDUK
        ========================= */
        function initDataTableSemuaPenduduk() {
            detailTableSemua = $('#detailTableSemuaPenduduk').DataTable({
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
                    lengthMenu: 'Tampilkan _MENU_ data',
                    zeroRecords: 'Data tidak ditemukan',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
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
                    url: '{{ route('umur.semua') }}',
                    data: function(d) {
                        d.rw = currentRWSemua;
                        d.rt = currentRTSemua;
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
                        className: 'text-center',
                        defaultContent: '-'
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        defaultContent: '-'
                    },
                    {
                        data: 'no_kk',
                        name: 'no_kk',
                        className: 'text-center',
                        defaultContent: '-'
                    },
                    {
                        data: 'jenkel',
                        name: 'jenkel',
                        className: 'text-center'
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
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ]
            });
        }
    </script>
@endpush
