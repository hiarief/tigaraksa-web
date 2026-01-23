@extends('admin.layout.main')
@section('title', 'Statistik Kepemilikan Rumah')
@section('content-header', 'Statistik Kepemilikan Rumah')

@section('content')
    <div class="row">
        <div class="col-sm">

            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="total-kk">-</h3>
                            <p>Total Kepala Keluarga</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-home"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="milik-sendiri">-</h3>
                            <p>Milik Sendiri</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="rentan">-</h3>
                            <p>KK Rentan Perumahan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="anomali">-</h3>
                            <p>Data Anomali</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1 -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Distribusi Kepemilikan Rumah (Per KK)
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="chartDistribusiKK" height="250"></canvas>
                        </div>
                        <div class="overlay" id="loading-distribusi">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Tingkat Kerentanan Perumahan
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="chartKerentanan" height="250"></canvas>
                        </div>
                        <div class="overlay" id="loading-kerentanan">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 2 -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Kepemilikan Rumah Berdasarkan Kelompok Umur Kepala Keluarga
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="chartUmur" height="215"></canvas>
                        </div>
                        <div class="overlay" id="loading-umur">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 3 -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-1"></i>
                                Distribusi Kepemilikan Rumah Per RT/RW
                            </h3>
                        </div>
                        <div class="card-body" style="overflow-x: auto;">
                            <canvas id="chartWilayah" height="250"></canvas>
                        </div>
                        <div class="overlay" id="loading-wilayah">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Validasi & Kualitas Data
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="chartAnomali" height="250"></canvas>
                        </div>
                        <div class="overlay" id="loading-anomali">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DataTable Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-table mr-1"></i>
                                Data Kepala Keluarga
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Filter -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Filter Kepemilikan Rumah:</label>
                                    <select id="filter-kepemilikan" class="form-control">
                                        <option value="">Semua</option>
                                        <option value="Milik Sendiri">Milik Sendiri</option>
                                        <option value="Orang Tua">Orang Tua</option>
                                        <option value="Ngontrak">Ngontrak</option>
                                        <option value="Menumpang">Menumpang</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Filter Kerentanan:</label>
                                    <select id="filter-kerentanan" class="form-control">
                                        <option value="">Semua</option>
                                        <option value="Aman">Aman (Milik Sendiri)</option>
                                        <option value="Semi Rentan">Semi Rentan (Orang Tua)</option>
                                        <option value="Rentan">Rentan (Ngontrak/Menumpang)</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Filter RW:</label>
                                    <select id="filter-rw" class="form-control">
                                        <option value="">Semua RW</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Filter RT:</label>
                                    <select id="filter-rt" class="form-control">
                                        <option value="">Semua RT</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Filter Anomali:</label>
                                    <select id="filter-anomali" class="form-control">
                                        <option value="">Semua</option>
                                        <option value="anomali">Hanya Anomali</option>
                                        <option value="normal">Hanya Normal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <button id="btn-reset-filter" class="btn btn-secondary">
                                        <i class="fas fa-redo"></i> Reset Semua Filter
                                    </button>
                                    {{--  <button id="btn-export" class="btn btn-success ml-2">
                                        <i class="fas fa-file-excel"></i> Export ke Excel
                                    </button>  --}}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!-- Table -->
                                <table id="table-kepemilikan" class="table-bordered table-striped table">
                                    <thead>
                                        <tr class="nowrap text-center">
                                            <th>No</th>
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
    <style>
        .small-box .icon {
            top: -10px;
            right: 10px;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .card {
            position: relative;
        }

        .badge-anomali {
            background-color: #dc3545;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
        }

        .badge-normal {
            background-color: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Color palette
            const colors = {
                milikSendiri: '#28a745',
                orangTua: '#17a2b8',
                ngontrak: '#ffc107',
                menumpang: '#fd7e14',
                lainnya: '#6c757d',
                aman: '#28a745',
                semiRentan: '#ffc107',
                rentan: '#dc3545',
                normal: '#007bff',
                anomali: '#dc3545',
                tanpaData: '#6c757d'
            };

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
                    [10, 25, 50, 100, "All"]
                ],
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
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'no_nik',
                        name: 'no_nik',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        class: 'nowrap'
                    },
                    {
                        data: 'no_kk',
                        name: 'no_kk',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'kp',
                        name: 'kp',
                        class: 'nowrap'
                    },
                    {
                        data: 'rw',
                        name: 'rw',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'rt',
                        name: 'rt',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'jenkel',
                        name: 'jenkel',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'tgl_lahir',
                        name: 'tgl_lahir',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'umur',
                        name: 'umur',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'kepemilikan_rumah',
                        name: 'kepemilikan_rumah',
                        class: 'text-center nowrap'
                    },
                    {
                        data: 'status_anomali',
                        name: 'status_anomali',
                        class: 'text-center nowrap',
                        orderable: false
                    }
                ],
            });

            // Load RW/RT Options
            function loadRwRtOptions() {
                $.ajax({
                    url: '{{ route('kepemilikan.rumah.rw.rt.list') }}',
                    method: 'GET',
                    success: function(data) {
                        // Populate RW dropdown
                        const rwSelect = $('#filter-rw');
                        rwSelect.empty().append('<option value="">Semua RW</option>');
                        data.rw_list.forEach(rw => {
                            rwSelect.append(`<option value="${rw}">${rw}</option>`);
                        });

                        // Populate RT dropdown
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

            $('#btn-reset-filter').on('click', function() {
                $('#filter-kepemilikan').val('');
                $('#filter-kerentanan').val('');
                $('#filter-rw').val('');
                $('#filter-rt').val('');
                $('#filter-anomali').val('');
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
                        $('#loading-distribusi').hide();

                        const labels = data.map(item => item.kepemilikan_rumah || 'Tidak Diketahui');
                        const values = data.map(item => item.total_kk);
                        const bgColors = labels.map(label => {
                            if (label.includes('Milik Sendiri')) return colors.milikSendiri;
                            if (label.includes('Orang Tua')) return colors.orangTua;
                            if (label.includes('Ngontrak')) return colors.ngontrak;
                            if (label.includes('Menumpang')) return colors.menumpang;
                            return colors.lainnya;
                        });

                        // Update summary card
                        const totalKK = values.reduce((a, b) => a + b, 0);
                        const milikSendiri = data.find(item => item.kepemilikan_rumah ===
                            'Milik Sendiri')?.total_kk || 0;
                        $('#total-kk').text(totalKK.toLocaleString());
                        $('#milik-sendiri').text(milikSendiri.toLocaleString());

                        new Chart($('#chartDistribusiKK'), {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: values,
                                    backgroundColor: bgColors,
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const label = context.label || '';
                                                const value = context.parsed;
                                                const total = context.dataset.data.reduce((
                                                    a, b) => a + b, 0);
                                                const percentage = ((value / total) * 100)
                                                    .toFixed(1);
                                                return `${label}: ${value} KK (${percentage}%)`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        $('#loading-distribusi').html('<p class="text-danger">Gagal memuat data</p>');
                    }
                });
            }

            // Chart 2: Kerentanan Perumahan (Doughnut)
            function loadKerentanan() {
                $.ajax({
                    url: '{{ route('kepemilikan.rumah.kerentanan') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#loading-kerentanan').hide();

                        const labels = data.map(item => item.kategori_kerentanan);
                        const values = data.map(item => item.total_kk);
                        const bgColors = labels.map(label => {
                            if (label === 'Aman') return colors.aman;
                            if (label === 'Semi Rentan') return colors.semiRentan;
                            if (label === 'Rentan') return colors.rentan;
                            return colors.lainnya;
                        });

                        // Update summary card
                        const rentan = data.find(item => item.kategori_kerentanan === 'Rentan')
                            ?.total_kk || 0;
                        $('#rentan').text(rentan.toLocaleString());

                        new Chart($('#chartKerentanan'), {
                            type: 'doughnut',
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: values,
                                    backgroundColor: bgColors,
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const label = context.label || '';
                                                const value = context.parsed;
                                                const total = context.dataset.data.reduce((
                                                    a, b) => a + b, 0);
                                                const percentage = ((value / total) * 100)
                                                    .toFixed(1);
                                                return `${label}: ${value} KK (${percentage}%)`;
                                            }
                                        }
                                    }
                                }
                            }
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
                        $('#loading-umur').hide();

                        // Group data
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
                                        umur && d.kepemilikan_rumah === type);
                                    return item ? item.total : 0;
                                }),
                                backgroundColor: color,
                                borderColor: color,
                                borderWidth: 1
                            };
                        });

                        new Chart($('#chartUmur'), {
                            type: 'bar',
                            data: {
                                labels: kelompokUmur,
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    },
                                    tooltip: {
                                        mode: 'index',
                                        intersect: false
                                    }
                                },
                                scales: {
                                    x: {
                                        stacked: false
                                    },
                                    y: {
                                        stacked: false,
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                }
                            }
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
                        $('#loading-wilayah').hide();

                        // Group data
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
                                borderColor: color,
                                borderWidth: 1
                            };
                        });

                        new Chart($('#chartWilayah'), {
                            type: 'bar',
                            data: {
                                labels: rtRwList,
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    },
                                    tooltip: {
                                        mode: 'index',
                                        intersect: false
                                    }
                                },
                                scales: {
                                    x: {
                                        stacked: true
                                    },
                                    y: {
                                        stacked: true,
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                }
                            }
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
                        $('#loading-anomali').hide();

                        const labels = data.map(item => item.kategori);
                        const values = data.map(item => item.total);
                        const bgColors = labels.map(label => {
                            if (label.includes('Normal')) return colors.normal;
                            if (label.includes('Anomali')) return colors.anomali;
                            return colors.tanpaData;
                        });

                        // Update summary card
                        const anomali = data.find(item => item.kategori.includes('Anomali'))?.total ||
                            0;
                        $('#anomali').text(anomali.toLocaleString());

                        new Chart($('#chartAnomali'), {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: values,
                                    backgroundColor: bgColors,
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const label = context.label || '';
                                                const value = context.parsed;
                                                const total = context.dataset.data.reduce((
                                                    a, b) => a + b, 0);
                                                const percentage = ((value / total) * 100)
                                                    .toFixed(1);
                                                return `${label}: ${value} KK (${percentage}%)`;
                                            }
                                        }
                                    }
                                }
                            }
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
