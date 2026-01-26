@extends('admin.layout.main')
@section('title', 'Statistik Bantuan Pemerintah')
@section('content-header', 'Statistik Bantuan Pemerintah')

@section('content')
    <div class="row align-items-stretch" id="dashboard-header">

        <div class="col-lg-2 col-6 d-flex">
            <div class="small-box bg-info w-100">
                <div class="inner">
                    <h3 id="total-penduduk">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Total Penduduk</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-6 d-flex">
            <div class="small-box bg-success w-100">
                <div class="inner">
                    <h3 id="total-kk">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Total KK</p>
                </div>
                <div class="icon">
                    <i class="fas fa-home"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-6 d-flex">
            <div class="small-box bg-warning w-100">
                <div class="inner">
                    <h3 id="total-penerima">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Total Penerima Bantuan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-6 d-flex">
            <div class="small-box bg-danger w-100">
                <div class="inner">
                    <h3 id="layak-belum-menerima">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Layak Belum Menerima</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-6 d-flex">
            <div class="small-box bg-secondary w-100">
                <div class="inner">
                    <h3 id="tidak-layak-menerima">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Anomali</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-6 d-flex">
            <div class="small-box bg-primary w-100">
                <div class="inner">
                    <h3 id="lansia-layak">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Lansia Layak (%)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
        </div>

    </div>


    <!-- Charts Row 1 -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Status Kelayakan Bantuan</h3>
                </div>
                <div class="card-body">
                    <canvas id="chart-kelayakan" style="min-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distribusi Penerima Bantuan</h3>
                </div>
                <div class="card-body">
                    <canvas id="chart-bantuan" style="min-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distribusi Kelompok Umur</h3>
                </div>
                <div class="card-body">
                    <canvas id="chart-umur" style="min-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Penerima Bantuan Berdasarkan Gender</h3>
                </div>
                <div class="card-body">
                    <canvas id="chart-gender" style="min-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 3 -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top 10 RT/RW Penerima Bantuan</h3>
                </div>
                <div class="card-body">
                    <div style="height: 350px;">
                        <canvas id="chart-rtrw"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Status KK</h3>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="chart-kk"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Detail Tables -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Data Penduduk</h3>
                    <div class="card-tools">
                        <select id="filter-kategori" class="form-control form-control-sm" style="width: 200px;">
                            <option value="semua">Semua Data</option>
                            <option value="layak">Layak</option>
                            <option value="tidak_layak">Tidak Layak</option>
                            <option value="penerima">Penerima Bantuan</option>
                            <option value="belum_menerima">Belum Menerima</option>
                            <option value="layak_belum_menerima">Layak Belum Menerima (Kritis)</option>
                            <option value="anomali">Anomali (Tidak Layak Menerima)</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive">
                                <table id="table-detail" class="table-bordered table-striped table-hover table">
                                    <thead>
                                        <tr class="nowrap text-center">
                                            <th style="width: 1%">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>No KK</th>
                                            <th>Kampung</th>
                                            <th>RT/RW</th>
                                            <th>JK</th>
                                            <th>Tgl Lahir</th>
                                            <th>Umur</th>
                                            <th>Kelompok Umur</th>
                                            <th>Status Kelayakan</th>
                                            <th>Bantuan</th>
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
    </div>

    <!-- Anomali Detail -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Detail Anomali - Tidak Layak Tapi Menerima</h3>
                </div>
                <div class="card-body">
                    <table class="table-sm table" id="table-anomali">
                        <thead>
                            <tr>
                                <th>Jenis Bantuan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" class="text-center">
                                    <i class="fas fa-spinner fa-spin"></i> Memuat data...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Distribusi Per Kampung</h3>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <table class="table-sm table" id="table-kampung">
                        <thead>
                            <tr>
                                <th>Kampung</th>
                                <th>Total</th>
                                <th>Penerima</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center">
                                    <i class="fas fa-spinner fa-spin"></i> Memuat data...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #dashboard-header .small-box {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        #dashboard-header .small-box .inner {
            flex-grow: 1;
        }

        #dashboard-header .small-box .inner {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            let charts = {};
            let dataTable;

            // Color palette
            const colors = {
                primary: '#007bff',
                success: '#28a745',
                danger: '#dc3545',
                warning: '#ffc107',
                info: '#17a2b8',
                secondary: '#6c757d',
                purple: '#6f42c1',
                orange: '#fd7e14',
                teal: '#20c997',
                pink: '#e83e8c'
            };

            // Load statistik data
            function loadStatistik() {
                $.ajax({
                    url: '{{ route('bantuan.pemerintah.statistik') }}',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        updateDashboardHeader(response.ringkasan);
                        createChartKelayakan(response.kelayakan);
                        createChartBantuan(response.distribusi_bantuan);
                        createChartUmur(response.umur);
                        createChartGender(response.gender);
                        createChartRTRW(response.wilayah.rt_rw);
                        createChartKK(response.kk);
                        updateAnomaliTable(response.anomali.detail);
                        updateKampungTable(response.wilayah.kampung);
                    },
                    error: function(xhr) {
                        console.error('Error loading statistik:', xhr);
                        toastr.error('Gagal memuat data statistik');
                    }
                });
            }

            // Update dashboard header
            function updateDashboardHeader(data) {
                $('#total-penduduk').text(data.total_penduduk.toLocaleString());
                $('#total-kk').text(data.total_kk.toLocaleString());
                $('#total-penerima').text(data.total_penerima_bantuan.toLocaleString());
                $('#layak-belum-menerima').text(data.layak_belum_menerima.toLocaleString());
                $('#tidak-layak-menerima').text(data.tidak_layak_menerima.toLocaleString());
                $('#lansia-layak').text(data.lansia_layak_persen + '%');
            }

            // Chart: Kelayakan
            function createChartKelayakan(data) {
                const ctx = document.getElementById('chart-kelayakan').getContext('2d');
                if (charts.kelayakan) charts.kelayakan.destroy();

                charts.kelayakan = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Layak', 'Tidak Layak'],
                        datasets: [{
                            data: [data.layak, data.tidak_layak],
                            backgroundColor: [colors.success, colors.warning],
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
                                    padding: 15
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const persen = context.dataIndex === 0 ? data.persen_layak :
                                            data.persen_tidak_layak;
                                        return label + ': ' + value.toLocaleString() + ' (' + persen +
                                            '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Chart: Distribusi Bantuan
            function createChartBantuan(data) {
                const ctx = document.getElementById('chart-bantuan').getContext('2d');
                if (charts.bantuan) charts.bantuan.destroy();

                const labels = Object.keys(data);
                const values = Object.values(data);
                const backgroundColors = [
                    colors.primary, colors.success, colors.danger,
                    colors.warning, colors.info, colors.purple, colors.secondary
                ];

                charts.bantuan = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Penerima',
                            data: values,
                            backgroundColor: backgroundColors.slice(0, labels.length),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Jumlah: ' + context.parsed.y.toLocaleString() +
                                            ' orang';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Chart: Kelompok Umur
            function createChartUmur(data) {
                const ctx = document.getElementById('chart-umur').getContext('2d');
                if (charts.umur) charts.umur.destroy();

                const urutan = [
                    'Balita (0-5)',
                    'Anak (6-12)',
                    'Remaja (13-17)',
                    'Produktif Muda (18-35)',
                    'Produktif (36-59)',
                    'Lansia (≥60)'
                ];

                const labels = [];
                const total = [];
                const penerima = [];

                urutan.forEach(kel => {
                    if (data.distribusi[kel]) {
                        labels.push(kel);
                        total.push(data.distribusi[kel]);
                        penerima.push(data.penerima_bantuan[kel] || 0);
                    }
                });

                charts.umur = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Penduduk',
                            data: total,
                            backgroundColor: colors.info,
                            borderWidth: 1
                        }, {
                            label: 'Penerima Bantuan',
                            data: penerima,
                            backgroundColor: colors.success,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y
                                            .toLocaleString() + ' orang';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Chart: Gender
            function createChartGender(data) {
                const ctx = document.getElementById('chart-gender').getContext('2d');
                if (charts.gender) charts.gender.destroy();

                charts.gender = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Laki-laki', 'Perempuan'],
                        datasets: [{
                            label: 'Total',
                            data: [data.laki_laki, data.perempuan],
                            backgroundColor: colors.primary,
                            borderWidth: 1
                        }, {
                            label: 'Penerima Bantuan',
                            data: [data.laki_laki_bantuan, data.perempuan_bantuan],
                            backgroundColor: colors.success,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y
                                            .toLocaleString() + ' orang';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Chart: RT/RW
            function createChartRTRW(data) {
                const ctx = document.getElementById('chart-rtrw').getContext('2d');
                if (charts.rtrw) charts.rtrw.destroy();

                const labels = Object.keys(data);
                const values = Object.values(data).map(item => item.penerima);

                charts.rtrw = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Penerima Bantuan',
                            data: values,
                            backgroundColor: colors.warning,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Penerima: ' + context.parsed.x + ' orang';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Chart: KK
            function createChartKK(data) {
                const ctx = document.getElementById('chart-kk').getContext('2d');
                if (charts.kk) charts.kk.destroy();

                charts.kk = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['KK Penerima', 'KK Belum Menerima', 'Multi Penerima (1 KK)'],
                        datasets: [{
                            data: [data.kk_penerima, data.kk_belum_menerima, data.multi_penerima],
                            backgroundColor: [colors.success, colors.secondary, colors.danger],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': ' + value.toLocaleString() + ' (' +
                                            percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Update Anomali Table
            function updateAnomaliTable(data) {
                let html = '';
                if (Object.keys(data).length === 0) {
                    html = '<tr><td colspan="2" class="text-center">Tidak ada data anomali</td></tr>';
                } else {
                    $.each(data, function(bantuan, jumlah) {
                        html += '<tr><td>' + bantuan + '</td><td><span class="badge badge-danger">' +
                            jumlah + '</span></td></tr>';
                    });
                }
                $('#table-anomali tbody').html(html);
            }

            // Update Kampung Table
            function updateKampungTable(data) {
                let html = '';
                if (Object.keys(data).length === 0) {
                    html = '<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>';
                } else {
                    $.each(data, function(kampung, item) {
                        html += '<tr>';
                        html += '<td>' + kampung + '</td>';
                        html += '<td>' + item.total + '</td>';
                        html += '<td>' + item.penerima + '</td>';
                        html += '<td>' + item.persen + '%</td>';
                        html += '</tr>';
                    });
                }
                $('#table-kampung tbody').html(html);
            }

            // Initialize DataTable
            function initDataTable(kategori = 'semua') {
                if (dataTable) {
                    dataTable.destroy();
                }

                dataTable = $('#table-detail').DataTable({
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
                        url: '{{ route('bantuan.pemerintah.datatables') }}',
                        data: function(d) {
                            d.kategori = kategori;
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
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            className: 'text-left nowrap'
                        },
                        {
                            data: 'no_kk',
                            name: 'no_kk',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'kp',
                            name: 'kp',
                            className: 'text-left nowrap'
                        },
                        {
                            data: 'rt_rw',
                            name: 'rt_rw',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'jenkel_text',
                            name: 'jenkel_text',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'tgl_lahir',
                            name: 'tgl_lahir',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'umur',
                            name: 'umur',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'kelompok_umur',
                            name: 'kelompok_umur',
                            className: 'text-left nowrap'
                        },
                        {
                            data: 'status_kelayakan',
                            name: 'status_kelayakan',
                            orderable: false,
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'nama_bantuan',
                            name: 'nama_bantuan',
                            defaultContent: '-',
                            className: 'text-center nowrap'
                        },
                        {
                            data: 'status_bantuan',
                            name: 'status_bantuan',
                            orderable: false,
                            className: 'text-center nowrap'
                        }
                    ],
                });
            }

            // Filter kategori change
            $('#filter-kategori').on('change', function() {
                const kategori = $(this).val();
                initDataTable(kategori);
            });

            // Initialize
            loadStatistik();
            initDataTable();
        });
    </script>
@endpush
