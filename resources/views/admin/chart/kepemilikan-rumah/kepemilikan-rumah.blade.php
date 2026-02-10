@extends('admin.layout.main')
@section('title', 'Statistik Kepemilikan Rumah')
@section('content-header', 'Statistik Kepemilikan Rumah')

@section('content')

    <!-- Premium Info Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
            <div class="info-box-premium bg-gradient-info elevation-3">
                <div class="info-box-premium-icon">
                    <div class="icon-circle bg-white">
                        <i class="fas fa-home text-info"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Total Kepala Keluarga</span>
                    <span class="info-box-premium-number" id="total-kk">
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
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Milik Sendiri</span>
                    <span class="info-box-premium-number" id="milik-sendiri">
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
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">KK Rentan Perumahan</span>
                    <span class="info-box-premium-number" id="rentan">
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
                        <i class="fas fa-times-circle text-danger"></i>
                    </div>
                </div>
                <div class="info-box-premium-content">
                    <span class="info-box-premium-text">Data Anomali</span>
                    <span class="info-box-premium-number" id="anomali">
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
                        <h3 class="card-title-premium">Distribusi Kepemilikan Rumah</h3>
                        <p class="card-subtitle-premium">Status kepemilikan per kepala keluarga</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-distribusi" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartDistribusiKK" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-warning">
                    <div class="card-header-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Tingkat Kerentanan Perumahan</h3>
                        <p class="card-subtitle-premium">Klasifikasi keamanan kepemilikan rumah</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-kerentanan" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartKerentanan" style="display:none; max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 - Premium Design -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-success">
                    <div class="card-header-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Kepemilikan Rumah Berdasarkan Kelompok Umur</h3>
                        <p class="card-subtitle-premium">Analisis kepemilikan berdasarkan usia kepala keluarga</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-umur" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartUmur" style="display:none; max-height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 3 - Premium Design -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-info">
                    <div class="card-header-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi Kepemilikan Per RT/RW</h3>
                        <p class="card-subtitle-premium">Pemetaan kepemilikan rumah per wilayah</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium" style="overflow-x: auto;">
                    <div id="loading-wilayah" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartWilayah" style="display:none; max-height: 400px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-danger">
                    <div class="card-header-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Validasi & Kualitas Data</h3>
                        <p class="card-subtitle-premium">Status validasi data kepemilikan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-anomali" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <canvas id="chartAnomali" style="display:none; max-height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable Section - Premium Design -->
    <div class="row">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-dark">
                    <div class="card-header-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Data Kepala Keluarga</h3>
                        <p class="card-subtitle-premium">Eksplorasi data dengan filter multi-dimensi</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium p-0">
                    <!-- Filter Section -->
                    <div class="filter-section-premium">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="filter-label-premium">
                                    <i class="fas fa-home mr-2"></i>Kepemilikan Rumah
                                </label>
                                <select id="filter-kepemilikan" class="form-control select2-premium">
                                    <option value="">Semua</option>
                                    <option value="Milik Sendiri">Milik Sendiri</option>
                                    <option value="Orang Tua">Orang Tua</option>
                                    <option value="Ngontrak">Ngontrak</option>
                                    <option value="Menumpang">Menumpang</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="filter-label-premium">
                                    <i class="fas fa-shield-alt mr-2"></i>Tingkat Kerentanan
                                </label>
                                <select id="filter-kerentanan" class="form-control select2-premium">
                                    <option value="">Semua</option>
                                    <option value="Aman">Aman (Milik Sendiri)</option>
                                    <option value="Semi Rentan">Semi Rentan (Orang Tua)</option>
                                    <option value="Rentan">Rentan (Ngontrak/Menumpang)</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="filter-label-premium">
                                    <i class="fas fa-map-marker-alt mr-2"></i>RW
                                </label>
                                <select id="filter-rw" class="form-control select2-premium">
                                    <option value="">Semua RW</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="filter-label-premium">
                                    <i class="fas fa-location-arrow mr-2"></i>RT
                                </label>
                                <select id="filter-rt" class="form-control select2-premium">
                                    <option value="">Semua RT</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="filter-label-premium">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>Filter Anomali
                                </label>
                                <select id="filter-anomali" class="form-control select2-premium">
                                    <option value="">Semua</option>
                                    <option value="anomali">Hanya Anomali</option>
                                    <option value="normal">Hanya Normal</option>
                                </select>
                            </div>
                            <div class="col-md-8 d-flex align-items-end justify-content-end mb-3 text-right">
                                <button id="btn-reset-filter" class="btn btn-reset-premium elevation-2 mr-2">
                                    <i class="fas fa-redo mr-2"></i>Reset Filter
                                </button>
                                <button id="btn-export" class="btn btn-export-premium elevation-2">
                                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="table-container-premium">
                        <div class="table-responsive">
                            <table class="table-premium" id="table-kepemilikan">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>No. KK</th>
                                        <th>Kampung</th>
                                        <th>RW</th>
                                        <th>RT</th>
                                        <th>JK</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Umur</th>
                                        <th>Kepemilikan Rumah</th>
                                        <th>Status</th>
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
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Color palette
            const colors = {
                milikSendiri: 'rgba(40, 167, 69, 0.8)',
                orangTua: 'rgba(23, 162, 184, 0.8)',
                ngontrak: 'rgba(255, 193, 7, 0.8)',
                menumpang: 'rgba(253, 126, 20, 0.8)',
                lainnya: 'rgba(108, 117, 125, 0.8)',
                aman: 'rgba(40, 167, 69, 0.8)',
                semiRentan: 'rgba(255, 193, 7, 0.8)',
                rentan: 'rgba(220, 53, 69, 0.8)',
                normal: 'rgba(0, 123, 255, 0.8)',
                anomali: 'rgba(220, 53, 69, 0.8)',
                tanpaData: 'rgba(108, 117, 125, 0.8)'
            };

            // Initialize Select2
            $('.select2-premium').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            // Load RW and RT options
            loadRwRtOptions();

            // Initialize DataTable
            const table = $('#table-kepemilikan').DataTable({
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
                    url: '{{ route('kepemilikan.rumah.datatable') }}',
                    data: function(d) {
                        d.kepemilikan = $('#filter-kepemilikan').val();
                        d.kerentanan = $('#filter-kerentanan').val();
                        d.rw = $('#filter-rw').val();
                        d.rt = $('#filter-rt').val();
                        d.anomali = $('#filter-anomali').val();
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
                        className: 'text-center'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'no_kk',
                        name: 'no_kk',
                        className: 'text-center'
                    },
                    {
                        data: 'kp',
                        name: 'kp'
                    },
                    {
                        data: 'rw',
                        name: 'rw',
                        className: 'text-center'
                    },
                    {
                        data: 'rt',
                        name: 'rt',
                        className: 'text-center'
                    },
                    {
                        data: 'jenkel',
                        name: 'jenkel',
                        className: 'text-center',
                        render: data => data == 1 ?
                            '<span class="badge-status-premium badge-primary-premium">L</span>' :
                            '<span class="badge-status-premium badge-danger-premium">P</span>'
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
                        data: 'kepemilikan_rumah',
                        name: 'kepemilikan_rumah',
                        className: 'text-center'
                    },
                    {
                        data: 'status_anomali',
                        name: 'status_anomali',
                        className: 'text-center',
                        orderable: false,
                        render: data => {
                            if (data && data.includes('Anomali')) {
                                return '<span class="badge-status-premium badge-anomali-premium">Anomali</span>';
                            }
                            return '<span class="badge-status-premium badge-normal-premium">Normal</span>';
                        }
                    }
                ]
            });

            // Load RW/RT Options
            function loadRwRtOptions() {
                $.ajax({
                    url: '{{ route('kepemilikan.rumah.rw.rt.list') }}',
                    method: 'GET',
                    success: function(data) {
                        const rwSelect = $('#filter-rw');
                        rwSelect.empty().append('<option value="">Semua RW</option>');
                        data.rw_list.forEach(rw => {
                            rwSelect.append(`<option value="${rw}">${rw}</option>`);
                        });

                        const rtSelect = $('#filter-rt');
                        rtSelect.empty().append('<option value="">Semua RT</option>');
                        data.rt_list.forEach(rt => {
                            rtSelect.append(`<option value="${rt}">${rt}</option>`);
                        });
                    }
                });
            }

            // Filter handlers
            $('#filter-kepemilikan, #filter-kerentanan, #filter-rw, #filter-rt, #filter-anomali').on('change',
                function() {
                    table.ajax.reload();
                });

            // Dynamic RT based on RW selection
            $('#filter-rw').on('change', function() {
                const selectedRw = $(this).val();
                if (selectedRw) {
                    $.ajax({
                        url: '{{ route('kepemilikan.rumah.rt.by.rw') }}',
                        method: 'GET',
                        data: {
                            rw: selectedRw
                        },
                        success: function(data) {
                            const rtSelect = $('#filter-rt');
                            rtSelect.empty().append('<option value="">Semua RT</option>');
                            data.rt_list.forEach(rt => {
                                rtSelect.append(`<option value="${rt}">${rt}</option>`);
                            });
                        }
                    });
                } else {
                    loadRwRtOptions();
                }
            });

            // Reset Filter
            $('#btn-reset-filter').on('click', function() {
                $('#filter-kepemilikan').val('').trigger('change');
                $('#filter-kerentanan').val('').trigger('change');
                $('#filter-rw').val('').trigger('change');
                $('#filter-rt').val('').trigger('change');
                $('#filter-anomali').val('').trigger('change');
                loadRwRtOptions();
                table.ajax.reload();
            });

            // Export to Excel
            $('#btn-export').on('click', function() {
                const params = new URLSearchParams({
                    kepemilikan: $('#filter-kepemilikan').val(),
                    kerentanan: $('#filter-kerentanan').val(),
                    rw: $('#filter-rw').val(),
                    rt: $('#filter-rt').val(),
                    anomali: $('#filter-anomali').val()
                });
                window.location.href = '{{ route('kepemilikan.rumah.export') }}?' + params.toString();
            });

            // Load all charts
            loadDistribusiKK();
            loadKerentanan();
            loadKepemilikanByUmur();
            loadDistribusiWilayah();
            loadAnomaliData();

            // Chart 1: Distribusi Per KK (Pie Chart)
            function loadDistribusiKK() {
                $.ajax({
                    url: '{{ route('kepemilikan.rumah.distribusi.kk') }}',
                    method: 'GET',
                    success: function(data) {
                        const labels = data.map(item => item.kepemilikan_rumah || 'Tidak Diketahui');
                        const values = data.map(item => item.total_kk);
                        const bgColors = labels.map(label => {
                            if (label.includes('Milik Sendiri')) return colors.milikSendiri;
                            if (label.includes('Orang Tua')) return colors.orangTua;
                            if (label.includes('Ngontrak')) return colors.ngontrak;
                            if (label.includes('Menumpang')) return colors.menumpang;
                            return colors.lainnya;
                        });

                        const totalKK = values.reduce((a, b) => a + b, 0);
                        const milikSendiri = data.find(item => item.kepemilikan_rumah ===
                                'Milik Sendiri')
                            ?.total_kk || 0;
                        $('#total-kk').text(totalKK.toLocaleString('id-ID'));
                        $('#milik-sendiri').text(milikSendiri.toLocaleString('id-ID'));

                        $('#loading-distribusi').fadeOut(300, function() {
                            $('#chartDistribusiKK').fadeIn(400);

                            new Chart($('#chartDistribusiKK'), {
                                type: 'pie',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        data: values,
                                        backgroundColor: bgColors,
                                        borderWidth: 3,
                                        borderColor: '#fff',
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
                                                font: {
                                                    size: 12,
                                                    weight: '600'
                                                },
                                                usePointStyle: true,
                                                padding: 15
                                            }
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0,0,0,0.8)',
                                            padding: 15,
                                            cornerRadius: 8,
                                            callbacks: {
                                                label: function(context) {
                                                    const label = context.label ||
                                                        '';
                                                    const value = context.parsed;
                                                    const total = context.dataset
                                                        .data.reduce((a,
                                                            b) => a + b, 0);
                                                    const percentage = ((value /
                                                            total) * 100)
                                                        .toFixed(1);
                                                    return `${label}: ${value} KK (${percentage}%)`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    },
                    error: function() {
                        $('#loading-distribusi').html(
                            '<p class="text-danger">Gagal memuat data</p>');
                    }
                });
            }

            // Chart 2: Kerentanan Perumahan (Doughnut)
            function loadKerentanan() {
                $.ajax({
                    url: '{{ route('kepemilikan.rumah.kerentanan') }}',
                    method: 'GET',
                    success: function(data) {
                        const labels = data.map(item => item.kategori_kerentanan);
                        const values = data.map(item => item.total_kk);
                        const bgColors = labels.map(label => {
                            if (label === 'Aman') return colors.aman;
                            if (label === 'Semi Rentan') return colors.semiRentan;
                            if (label === 'Rentan') return colors.rentan;
                            return colors.lainnya;
                        });

                        const rentan = data.find(item => item.kategori_kerentanan === 'Rentan')
                            ?.total_kk || 0;
                        $('#rentan').text(rentan.toLocaleString('id-ID'));

                        $('#loading-kerentanan').fadeOut(300, function() {
                            $('#chartKerentanan').fadeIn(400);

                            new Chart($('#chartKerentanan'), {
                                type: 'doughnut',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        data: values,
                                        backgroundColor: bgColors,
                                        borderWidth: 3,
                                        borderColor: '#fff',
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
                                                font: {
                                                    size: 12,
                                                    weight: '600'
                                                },
                                                usePointStyle: true,
                                                padding: 15
                                            }
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0,0,0,0.8)',
                                            padding: 15,
                                            cornerRadius: 8,
                                            callbacks: {
                                                label: function(context) {
                                                    const label = context.label ||
                                                        '';
                                                    const value = context.parsed;
                                                    const total = context.dataset
                                                        .data.reduce((a,
                                                            b) => a + b, 0);
                                                    const percentage = ((value /
                                                            total) * 100)
                                                        .toFixed(1);
                                                    return `${label}: ${value} KK (${percentage}%)`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    },
                    error: function() {
                        $('#loading-kerentanan').html('<p class="text-danger">Gagal memuat data</p>');
                    }
                });
            }

            // Chart 3: Kepemilikan by Umur (Grouped Bar)
            function loadKepemilikanByUmur() {
                $.ajax({
                    url: '{{ route('kepemilikan.rumah.by.umur') }}',
                    method: 'GET',
                    success: function(data) {
                        const kelompokUmur = ['<30 Tahun', '30-45 Tahun', '46-60 Tahun', '>60 Tahun'];
                        const kepemilikanTypes = [...new Set(data.map(item => item.kepemilikan_rumah))];

                        const datasets = kepemilikanTypes.map(type => {
                            const color = type.includes('Milik Sendiri') ? colors.milikSendiri :
                                type.includes('Orang Tua') ? colors.orangTua :
                                type.includes('Ngontrak') ? colors.ngontrak :
                                type.includes('Menumpang') ? colors.menumpang : colors.lainnya;

                            return {
                                label: type,
                                data: kelompokUmur.map(umur => {
                                    const item = data.find(d => d.kelompok_umur ===
                                        umur && d
                                        .kepemilikan_rumah === type);
                                    return item ? item.total : 0;
                                }),
                                backgroundColor: color,
                                borderColor: color.replace('0.8', '1'),
                                borderWidth: 2,
                                borderRadius: 6
                            };
                        });

                        $('#loading-umur').fadeOut(300, function() {
                            $('#chartUmur').fadeIn(400);

                            new Chart($('#chartUmur'), {
                                type: 'bar',
                                data: {
                                    labels: kelompokUmur,
                                    datasets: datasets
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                            labels: {
                                                font: {
                                                    size: 13,
                                                    weight: '600'
                                                },
                                                usePointStyle: true,
                                                padding: 15
                                            }
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0,0,0,0.8)',
                                            padding: 15,
                                            cornerRadius: 8,
                                            mode: 'index',
                                            intersect: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            stacked: false,
                                            ticks: {
                                                font: {
                                                    size: 11,
                                                    weight: 'bold'
                                                }
                                            },
                                            grid: {
                                                display: false
                                            }
                                        },
                                        y: {
                                            stacked: false,
                                            beginAtZero: true,
                                            ticks: {
                                                stepSize: 1,
                                                font: {
                                                    size: 12
                                                }
                                            },
                                            grid: {
                                                color: 'rgba(0,0,0,0.03)'
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    },
                    error: function() {
                        $('#loading-umur').html('<p class="text-danger">Gagal memuat data</p>');
                    }
                });
            }

            // Chart 4: Distribusi Per Wilayah (Stacked Bar)
            function loadDistribusiWilayah() {
                $.ajax({
                    url: '{{ route('kepemilikan.rumah.per.wilayah') }}',
                    method: 'GET',
                    success: function(data) {
                        const rtRwList = [...new Set(data.map(item => item.rt_rw))].sort();
                        const kepemilikanTypes = [...new Set(data.map(item => item.kepemilikan_rumah))];

                        const datasets = kepemilikanTypes.map(type => {
                            const color = type.includes('Milik Sendiri') ? colors.milikSendiri :
                                type.includes('Orang Tua') ? colors.orangTua :
                                type.includes('Ngontrak') ? colors.ngontrak :
                                type.includes('Menumpang') ? colors.menumpang : colors.lainnya;

                            return {
                                label: type,
                                data: rtRwList.map(rt => {
                                    const item = data.find(d => d.rt_rw === rt && d
                                        .kepemilikan_rumah === type);
                                    return item ? item.total_kk : 0;
                                }),
                                backgroundColor: color,
                                borderColor: color.replace('0.8', '1'),
                                borderWidth: 2,
                                borderRadius: 6
                            };
                        });

                        $('#loading-wilayah').fadeOut(300, function() {
                            $('#chartWilayah').fadeIn(400);

                            new Chart($('#chartWilayah'), {
                                type: 'bar',
                                data: {
                                    labels: rtRwList,
                                    datasets: datasets
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                            labels: {
                                                font: {
                                                    size: 13,
                                                    weight: '600'
                                                },
                                                usePointStyle: true,
                                                padding: 15
                                            }
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0,0,0,0.8)',
                                            padding: 15,
                                            cornerRadius: 8,
                                            mode: 'index',
                                            intersect: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            stacked: true,
                                            ticks: {
                                                font: {
                                                    size: 11,
                                                    weight: 'bold'
                                                }
                                            },
                                            grid: {
                                                display: false
                                            }
                                        },
                                        y: {
                                            stacked: true,
                                            beginAtZero: true,
                                            ticks: {
                                                stepSize: 1,
                                                font: {
                                                    size: 12
                                                }
                                            },
                                            grid: {
                                                color: 'rgba(0,0,0,0.03)'
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    },
                    error: function() {
                        $('#loading-wilayah').html('<p class="text-danger">Gagal memuat data</p>');
                    }
                });
            }

            // Chart 5: Anomali Data (Pie)
            function loadAnomaliData() {
                $.ajax({
                    url: '{{ route('kepemilikan.rumah.anomali') }}',
                    method: 'GET',
                    success: function(data) {
                        const labels = data.map(item => item.kategori);
                        const values = data.map(item => item.total);
                        const bgColors = labels.map(label => {
                            if (label.includes('Normal')) return colors.normal;
                            if (label.includes('Anomali')) return colors.anomali;
                            return colors.tanpaData;
                        });

                        const anomali = data.find(item => item.kategori.includes('Anomali'))?.total ||
                            0;
                        $('#anomali').text(anomali.toLocaleString('id-ID'));

                        $('#loading-anomali').fadeOut(300, function() {
                            $('#chartAnomali').fadeIn(400);

                            new Chart($('#chartAnomali'), {
                                type: 'pie',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        data: values,
                                        backgroundColor: bgColors,
                                        borderWidth: 3,
                                        borderColor: '#fff',
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
                                                font: {
                                                    size: 12,
                                                    weight: '600'
                                                },
                                                usePointStyle: true,
                                                padding: 15
                                            }
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0,0,0,0.8)',
                                            padding: 15,
                                            cornerRadius: 8,
                                            callbacks: {
                                                label: function(context) {
                                                    const label = context.label ||
                                                        '';
                                                    const value = context.parsed;
                                                    const total = context.dataset
                                                        .data.reduce((a,
                                                            b) => a + b, 0);
                                                    const percentage = ((value /
                                                            total) * 100)
                                                        .toFixed(1);
                                                    return `${label}: ${value} KK (${percentage}%)`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    },
                    error: function() {
                        $('#loading-anomali').html('<p class="text-danger">Gagal memuat data</p>');
                    }
                });
            }
        });
    </script>
@endpush
