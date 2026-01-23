@extends('admin.layout.main')
@section('title', 'Statistik BPJS')
@section('content-header', 'Statistik BPJS')

@section('content')
    <!-- Statistik Kepemilikan BPJS -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Penduduk</h6>
                            <h3 class="mb-0 mt-2" id="total_penduduk">
                                <i class="fas fa-spinner fa-spin"></i>
                            </h3>
                            <small>Total Penduduk</small>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Punya BPJS</h6>
                            <h3 class="mb-0 mt-2" id="punya_bpjs">
                                <i class="fas fa-spinner fa-spin"></i>
                            </h3>
                            <small id="persentase_punya"></small>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Tidak Punya BPJS</h6>
                            <h3 class="mb-0 mt-2" id="tidak_punya_bpjs">
                                <i class="fas fa-spinner fa-spin"></i>
                            </h3>
                            <small id="persentase_tidak_punya"></small>
                        </div>
                        <i class="fas fa-times-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Data Anomali</h6>
                            <h3 class="mb-0 mt-2" id="total_anomali">
                                <i class="fas fa-spinner fa-spin"></i>
                            </h3>
                            <small>Data tidak valid</small>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Distribusi Kepemilikan BPJS</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartKepemilikan" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Jenis BPJS</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartJenisBpjs" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Sumber Pembayaran BPJS</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartPembayaran" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Status BPJS per Kartu Keluarga</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartKK" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Kombinasi -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Kombinasi Jenis BPJS × Sumber Pembayaran</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartKombinasi" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Detail Anomali -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Validasi & Anomali Data</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-bordered table">
                            <thead class="table-warning">
                                <tr>
                                    <th>Jenis Anomali</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="anomaliTable">
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <i class="fas fa-spinner fa-spin"></i> Memuat data...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Detail Data -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Data Penduduk</h5>
                </div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <select class="form-control form-control-sm" id="filterData">
                        <option value="">Semua Data</option>
                        <option value="punya_bpjs">Punya BPJS</option>
                        <option value="tidak_punya_bpjs">Tidak Punya BPJS</option>
                        <optgroup label="Jenis BPJS" id="filterJenis"></optgroup>
                        <optgroup label="Pembayaran" id="filterPembayaran"></optgroup>
                        <optgroup label="Anomali">
                            <option value="anomali_punya_null_jenis">Punya BPJS tapi Jenis Kosong</option>
                            <option value="anomali_tidak_punya_ada_jenis">Tidak Punya tapi Ada Jenis</option>
                            <option value="anomali_ada_jenis_null_pembayaran">Ada Jenis tapi Pembayaran Kosong
                            </option>
                        </optgroup>
                    </select>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-bordered table-hover table-striped table-sm nowrap table" id="tableDetail">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>No KK</th>
                                    <th>JK</th>
                                    <th>Umur</th>
                                    <th>Alamat</th>
                                    <th>RT/RW</th>
                                    <th>Status BPJS</th>
                                    <th>Jenis BPJS</th>
                                    <th>Pembayaran</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .opacity-50 {
            opacity: 0.5;
        }

        .card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;
        }

        .badge-status {
            font-size: 0.875rem;
            padding: 0.35em 0.65em;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let charts = {};
        let dataTable;

        $(document).ready(function() {
            loadStatistik();
            initDataTable();
        });

        function loadStatistik() {
            $.ajax({
                url: '{{ route('bpjs.statistik') }}',
                method: 'GET',
                success: function(data) {
                    updateCards(data.kepemilikan, data.anomali);
                    updateAnomaliTable(data.anomali);
                    createChartKepemilikan(data.kepemilikan);
                    createChartJenisBpjs(data.jenis_bpjs);
                    createChartPembayaran(data.pembayaran);
                    createChartKK(data.kepemilikan_kk);
                    createChartKombinasi(data.kombinasi);
                    populateFilters(data.jenis_bpjs, data.pembayaran);
                },
                error: function() {
                    alert('Gagal memuat statistik');
                }
            });
        }

        function updateCards(kepemilikan, anomali) {
            $('#total_penduduk').text(kepemilikan.total_penduduk.toLocaleString());
            $('#punya_bpjs').text(kepemilikan.punya_bpjs.toLocaleString());
            $('#persentase_punya').text(kepemilikan.persentase_punya + '%');
            $('#tidak_punya_bpjs').text(kepemilikan.tidak_punya_bpjs.toLocaleString());

            let persentaseTidak = 100 - kepemilikan.persentase_punya;
            $('#persentase_tidak_punya').text(persentaseTidak.toFixed(2) + '%');

            let totalAnomali = anomali.punya_tapi_null_jenis + anomali.tidak_punya_tapi_ada_jenis + anomali
                .ada_jenis_null_pembayaran;
            $('#total_anomali').text(totalAnomali.toLocaleString());
        }

        function updateAnomaliTable(anomali) {
            let html = '';

            if (anomali.punya_tapi_null_jenis > 0) {
                html += `<tr class="table-warning">
            <td>Punya BPJS tapi Jenis BPJS Kosong</td>
            <td><span class="badge bg-warning">${anomali.punya_tapi_null_jenis}</span></td>
            <td><button class="btn btn-sm btn-info" onclick="viewDetail('anomali_punya_null_jenis')">
                <i class="fas fa-eye"></i> Lihat Detail
            </button></td>
        </tr>`;
            }

            if (anomali.tidak_punya_tapi_ada_jenis > 0) {
                html += `<tr class="table-danger">
            <td>Tidak Punya BPJS tapi Ada Jenis BPJS</td>
            <td><span class="badge bg-danger">${anomali.tidak_punya_tapi_ada_jenis}</span></td>
            <td><button class="btn btn-sm btn-info" onclick="viewDetail('anomali_tidak_punya_ada_jenis')">
                <i class="fas fa-eye"></i> Lihat Detail
            </button></td>
        </tr>`;
            }

            if (anomali.ada_jenis_null_pembayaran > 0) {
                html += `<tr class="table-warning">
            <td>Ada Jenis BPJS tapi Pembayaran Kosong</td>
            <td><span class="badge bg-warning">${anomali.ada_jenis_null_pembayaran}</span></td>
            <td><button class="btn btn-sm btn-info" onclick="viewDetail('anomali_ada_jenis_null_pembayaran')">
                <i class="fas fa-eye"></i> Lihat Detail
            </button></td>
        </tr>`;
            }

            if (html === '') {
                html =
                    '<tr class="table-success"><td colspan="3" class="text-center"><i class="fas fa-check-circle"></i> Tidak ada anomali data</td></tr>';
            }

            $('#anomaliTable').html(html);
        }

        function createChartKepemilikan(data) {
            const ctx = document.getElementById('chartKepemilikan').getContext('2d');
            if (charts.kepemilikan) charts.kepemilikan.destroy();

            charts.kepemilikan = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Punya BPJS', 'Tidak Punya BPJS'],
                    datasets: [{
                        data: [data.punya_bpjs, data.tidak_punya_bpjs],
                        backgroundColor: ['#28a745', '#dc3545'],
                        borderWidth: 2
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
                                    let label = context.label || '';
                                    let value = context.parsed || 0;
                                    let total = data.total_penduduk;
                                    let pct = ((value / total) * 100).toFixed(2);
                                    return label + ': ' + value.toLocaleString() + ' (' + pct + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

        function createChartJenisBpjs(data) {
            const ctx = document.getElementById('chartJenisBpjs').getContext('2d');
            if (charts.jenis) charts.jenis.destroy();

            const labels = data.map(item => formatLabel(item.jenis_bpjs));
            const values = data.map(item => item.jumlah);

            charts.jenis = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Penduduk',
                        data: values,
                        backgroundColor: '#007bff'
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
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        function createChartPembayaran(data) {
            const ctx = document.getElementById('chartPembayaran').getContext('2d');
            if (charts.pembayaran) charts.pembayaran.destroy();

            const labels = data.map(item => formatLabel(item.pembayaran_bpjs));
            const values = data.map(item => item.jumlah);
            const colors = ['#17a2b8', '#ffc107', '#28a745', '#6f42c1'];

            charts.pembayaran = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors
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
        }

        function createChartKK(data) {
            const ctx = document.getElementById('chartKK').getContext('2d');
            if (charts.kk) charts.kk.destroy();

            charts.kk = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Semua Punya BPJS', 'Sebagian Punya', 'Tidak Ada yang Punya'],
                    datasets: [{
                        label: 'Jumlah KK',
                        data: [data.kk_semua_punya, data.kk_sebagian_punya, data.kk_tidak_ada],
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545']
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
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        function createChartKombinasi(data) {
            const ctx = document.getElementById('chartKombinasi').getContext('2d');
            if (charts.kombinasi) charts.kombinasi.destroy();

            // Group by jenis_bpjs
            const grouped = {};
            data.forEach(item => {
                if (!grouped[item.jenis_bpjs]) {
                    grouped[item.jenis_bpjs] = {};
                }
                grouped[item.jenis_bpjs][item.pembayaran_bpjs] = item.jumlah;
            });

            // Get all unique pembayaran types
            const allPembayaran = [...new Set(data.map(item => item.pembayaran_bpjs))];
            const colors = ['#17a2b8', '#ffc107', '#28a745', '#6f42c1'];

            const datasets = allPembayaran.map((pembayaran, idx) => ({
                label: formatLabel(pembayaran),
                data: Object.keys(grouped).map(jenis => grouped[jenis][pembayaran] || 0),
                backgroundColor: colors[idx % colors.length]
            }));

            charts.kombinasi = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(grouped).map(jenis => formatLabel(jenis)),
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function formatLabel(text) {
            if (!text) return '-';
            return text.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        }

        function populateFilters(jenisBpjs, pembayaran) {
            let jenisHtml = '';
            jenisBpjs.forEach(item => {
                jenisHtml += `<option value="jenis_${item.jenis_bpjs}">${formatLabel(item.jenis_bpjs)}</option>`;
            });
            $('#filterJenis').html(jenisHtml);

            let pembayaranHtml = '';
            pembayaran.forEach(item => {
                pembayaranHtml +=
                    `<option value="pembayaran_${item.pembayaran_bpjs}">${formatLabel(item.pembayaran_bpjs)}</option>`;
            });
            $('#filterPembayaran').html(pembayaranHtml);
        }

        function initDataTable() {
            dataTable = $('#tableDetail').DataTable({
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
                destroy: true,
                ajax: {
                    url: '{{ route('bpjs.detail') }}',
                    data: function(d) {
                        d.filter = $('#filterData').val();
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
                        className: 'text-center nowrap'
                    },
                    {
                        data: 'nama',
                        className: ' nowrap'
                    },
                    {
                        data: 'no_kk',
                        className: 'text-center nowrap'
                    },
                    {
                        data: 'jenkel',
                        className: 'text-center',
                        render: data =>
                            data == 1 ?
                            '<span class="badge bg-primary">L</span>' : '<span class="badge bg-danger">P</span>'
                    },
                    {
                        data: 'umur',
                        className: 'text-center'
                    },
                    {
                        data: 'kp',
                        className: 'nowrap'
                    },
                    {
                        data: 'rt_rw',
                        className: 'text-center'
                    },
                    {
                        data: 'punya_bpjs',
                        className: 'text-center',
                        render: data =>
                            data === 'ya' ?
                            '<span class="badge bg-success">Punya</span>' :
                            '<span class="badge bg-danger">Tidak</span>'
                    },
                    {
                        data: 'jenis_bpjs',
                        className: 'text-center',
                        render: data =>
                            data ? `<span class="badge bg-info">${formatLabel(data)}</span>` : '-'
                    },
                    {
                        data: 'pembayaran_bpjs',
                        className: 'text-center',
                        render: data =>
                            data ? `<span class="badge bg-secondary">${formatLabel(data)}</span>` : '-'
                    }
                ],
            });

            $('#filterData').on('change', function() {
                dataTable.ajax.reload();
            });
        }

        function viewDetail(filter) {
            $('#filterData').val(filter).trigger('change');
            $('html, body').animate({
                scrollTop: $('#tableDetail').offset().top - 100
            }, 500);
        }
    </script>
@endpush
