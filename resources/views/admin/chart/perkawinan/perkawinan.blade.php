@extends('admin.layout.main')
@section('title', 'Statistik Perkawinan')
@section('content-header', 'Statistik Perkawinan')

@section('content')
    <!-- Filter Section -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter"></i> Filter Data</h3>
                </div>
                <div class="card-body">
                    <form id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>RT/RW</label>
                                    <select class="form-control form-control-sm" id="filter_rt_rw" name="rt_rw">
                                        <option value="">Semua RT/RW</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kampung</label>
                                    <select class="form-control form-control-sm" id="filter_kp" name="kp">
                                        <option value="">Semua Kampung</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select class="form-control form-control-sm" id="filter_jenkel" name="jenkel">
                                        <option value="">Semua</option>
                                        <option value="1">Laki-laki</option>
                                        <option value="2">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">
                                        <i class="fas fa-search"></i> Tampilkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Boxes -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total_penduduk">0</h3>
                    <p>Total Penduduk</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="total_kawin">0</h3>
                    <p>Kawin</p>
                </div>
                <div class="icon">
                    <i class="fas fa-heart"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="total_belum_kawin">0</h3>
                    <p>Belum Kawin</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="total_usia_anak">0</h3>
                    <p>Kawin Usia Anak</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>


    <!-- Charts Row 1 -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie"></i> Komposisi Status Perkawinan
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="chartStatusPerkawinan" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie"></i> Legalitas Perkawinan
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="chartLegalitas" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i> Perkawinan Berdasarkan Gender
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="chartGender" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i> Usia Siap Kawin
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="chartUsiaSiap" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Row 3 -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line"></i> Distribusi Usia Kawin
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="chartDistribusiUsia" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Data Tables -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i> Detail Data Berdasarkan Kategori
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Main Category Tabs -->
                    <ul class="nav nav-pills mb-3" id="categoryTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="status-tab" data-toggle="pill" href="#status-kategori"
                                role="tab">
                                <i class="fas fa-ring"></i> Status Perkawinan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="legalitas-tab" data-toggle="pill" href="#legalitas-kategori"
                                role="tab">
                                <i class="fas fa-file-contract"></i> Legalitas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="usia-tab" data-toggle="pill" href="#usia-kategori" role="tab">
                                <i class="fas fa-calendar-check"></i> Usia Siap Kawin
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="anak-tab" data-toggle="pill" href="#anak-kategori" role="tab">
                                <i class="fas fa-child"></i> Usia Anak
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="gender-tab" data-toggle="pill" href="#gender-kategori"
                                role="tab">
                                <i class="fas fa-venus-mars"></i> Gender
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="distribusi-tab" data-toggle="pill" href="#distribusi-kategori"
                                role="tab">
                                <i class="fas fa-chart-area"></i> Distribusi Usia
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="categoryTabContent">
                        <!-- Status Perkawinan -->
                        <div class="tab-pane fade show active" id="status-kategori" role="tabpanel">
                            <ul class="nav nav-tabs" id="statusSubTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#" data-kategori="semua"
                                        data-table="table_status">Semua</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#" data-kategori="belum_kawin"
                                        data-table="table_status">Belum Kawin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#" data-kategori="kawin"
                                        data-table="table_status">Kawin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#" data-kategori="cerai_hidup"
                                        data-table="table_status">Cerai Hidup</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#" data-kategori="cerai_mati"
                                        data-table="table_status">Cerai Mati</a>
                                </li>
                            </ul>
                            <div class="table-responsive mt-3">
                                <table id="table_status" class="table-bordered table-striped table-sm table">
                                    <thead>
                                        <tr class="nowrap text-center">
                                            <th style="width: 1%">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Tgl Lahir</th>
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

                        <!-- Legalitas Perkawinan -->
                        <div class="tab-pane fade" id="legalitas-kategori" role="tabpanel">
                            <ul class="nav nav-tabs" id="legalitasSubTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#"
                                        data-kategori="kawin_tercatat" data-table="table_legalitas">Tercatat</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#"
                                        data-kategori="kawin_tidak_tercatat" data-table="table_legalitas">Tidak
                                        Tercatat</a>
                                </li>
                            </ul>
                            <div class="table-responsive mt-3">
                                <table id="table_legalitas" class="table-bordered table-striped table-sm table">
                                    <thead>
                                        <tr class="nowrap text-center">
                                            <th style="width: 1%">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Tgl Lahir</th>
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
                        <div class="tab-pane fade" id="usia-kategori" role="tabpanel">
                            <ul class="nav nav-tabs" id="usiaSubTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#"
                                        data-kategori="belum_kawin_siap" data-table="table_usia_siap">Usia ≥ 19</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#"
                                        data-kategori="belum_kawin_belum_siap" data-table="table_usia_siap">Usia < 19</a>
                                </li>
                            </ul>
                            <div class="table-responsive mt-3">
                                <table id="table_usia_siap" class="table-bordered table-striped table-sm table">
                                    <thead>
                                        <tr class="nowrap text-center">
                                            <th style="width: 1%">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Tgl Lahir</th>
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
                        <div class="tab-pane fade" id="anak-kategori" role="tabpanel">
                            <div class="table-responsive mt-3">
                                <table id="table_usia_anak" class="table-bordered table-striped table-sm table">
                                    <thead>
                                        <tr class="nowrap text-center">
                                            <th style="width: 1%">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Tgl Lahir</th>
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
                        <div class="tab-pane fade" id="gender-kategori" role="tabpanel">
                            <ul class="nav nav-tabs" id="genderSubTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#"
                                        data-kategori="kawin_laki" data-table="table_gender">Laki-laki</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#" data-kategori="kawin_perempuan"
                                        data-table="table_gender">Perempuan</a>
                                </li>
                            </ul>
                            <div class="table-responsive mt-3">
                                <table id="table_gender" class="table-bordered table-striped table-sm table">
                                    <thead>
                                        <tr class="nowrap">
                                            <th style="width: 1%">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Tgl Lahir</th>
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
                        <div class="tab-pane fade" id="distribusi-kategori" role="tabpanel">
                            <ul class="nav nav-tabs" id="distribusiSubTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#"
                                        data-kategori="kawin_usia_19_24" data-table="table_distribusi">19-24</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#"
                                        data-kategori="kawin_usia_25_34" data-table="table_distribusi">25-34</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#"
                                        data-kategori="kawin_usia_35_49" data-table="table_distribusi">35-49</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#"
                                        data-kategori="kawin_usia_50_plus" data-table="table_distribusi">≥ 50</a>
                                </li>
                            </ul>
                            <div class="table-responsive mt-3">
                                <table id="table_distribusi" class="table-bordered table-striped table-sm table">
                                    <thead>
                                        <tr class="nowrap text-center">
                                            <th style="width: 1%">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Tgl Lahir</th>
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
            loadFilterOptions();
            loadData();

            // Load tabel pertama saat halaman dimuat
            loadTableData('table_status', 'semua');

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                loadData();
                reloadAllTables();
            });

            // Event listener untuk main category pills
            $('#categoryTab a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                const targetPane = $(e.target).attr('href');

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

            // Event listeners untuk sub-tabs
            $(document).on('click', '[data-kategori]', function(e) {
                e.preventDefault();
                const kategori = $(this).data('kategori');
                const tableId = $(this).data('table');

                // Update active class
                $(this).closest('.nav-tabs').find('.nav-link').removeClass('active');
                $(this).addClass('active');

                // Load table data
                if (tableId) {
                    loadTableData(tableId, kategori);
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
            $('#total_penduduk').text(stats.total.toLocaleString('id-ID'));
            $('#total_kawin').text(stats.status_perkawinan['KAWIN'].toLocaleString('id-ID'));
            $('#total_belum_kawin').text(stats.status_perkawinan['BELUM KAWIN'].toLocaleString('id-ID'));

            $('#total_usia_anak').html(
                stats.perkawinan_usia_anak.jumlah.toLocaleString('id-ID') +
                ' <small class="text-muted" style="font-size: 0.875rem;">(' +
                stats.perkawinan_usia_anak.persentase + '%)</small>'
            );
        }


        function updateCharts(stats) {
            const ctxStatus = document.getElementById('chartStatusPerkawinan').getContext('2d');
            if (chartStatusPerkawinan) chartStatusPerkawinan.destroy();

            chartStatusPerkawinan = new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(stats.status_perkawinan),
                    datasets: [{
                        data: Object.values(stats.status_perkawinan),
                        backgroundColor: ['#FFC107', '#28A745', '#DC3545', '#6C757D']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            const ctxLegalitas = document.getElementById('chartLegalitas').getContext('2d');
            if (chartLegalitas) chartLegalitas.destroy();

            chartLegalitas = new Chart(ctxLegalitas, {
                type: 'pie',
                data: {
                    labels: Object.keys(stats.legalitas_perkawinan),
                    datasets: [{
                        data: Object.values(stats.legalitas_perkawinan),
                        backgroundColor: ['#28A745', '#DC3545']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            const ctxGender = document.getElementById('chartGender').getContext('2d');
            if (chartGender) chartGender.destroy();

            chartGender = new Chart(ctxGender, {
                type: 'bar',
                data: {
                    labels: Object.keys(stats.perkawinan_gender),
                    datasets: [{
                        label: 'Jumlah',
                        data: Object.values(stats.perkawinan_gender),
                        backgroundColor: ['#007BFF', '#E83E8C']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctxUsiaSiap = document.getElementById('chartUsiaSiap').getContext('2d');
            if (chartUsiaSiap) chartUsiaSiap.destroy();

            chartUsiaSiap = new Chart(ctxUsiaSiap, {
                type: 'bar',
                data: {
                    labels: Object.keys(stats.usia_siap_kawin),
                    datasets: [{
                        label: 'Jumlah',
                        data: Object.values(stats.usia_siap_kawin),
                        backgroundColor: ['#28A745', '#FFC107']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctxDistribusi = document.getElementById('chartDistribusiUsia').getContext('2d');
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
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
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

            if (tables[tableId]) {
                tables[tableId].destroy();
            }

            tables[tableId] = $('#' + tableId).DataTable({
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
                    url: '{{ route('perkawinan.index') }}/datatable',
                    data: filters
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center nowrap'
                    },
                    {
                        data: 'no_nik',
                        name: 'no_nik',
                        className: 'text-center nowrap'
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        className: 'nowrap'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin',
                        className: 'text-center nowrap'
                    },
                    {
                        data: 'umur',
                        name: 'umur',
                        className: 'text-center nowrap'
                    },
                    {
                        data: 'tgl_lahir',
                        name: 'tgl_lahir',
                        className: 'text-center nowrap'
                    },
                    {
                        data: 'rt_rw',
                        name: 'rt_rw',
                        className: 'text-center nowrap'
                    },
                    {
                        data: 'kp',
                        name: 'kp',
                        className: 'text-center nowrap'
                    },
                    {
                        data: 'badge_status',
                        name: 'badge_status',
                        className: 'text-center nowrap'
                    },
                    {
                        data: 'status_tercatat',
                        name: 'status_tercatat',
                        className: 'text-center nowrap'
                    }
                ],
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
