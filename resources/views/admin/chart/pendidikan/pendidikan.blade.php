@extends('admin.layout.main')
@section('title', 'Statistik Pendidikan')
@section('content-header', 'Statistik Pendidikan')

@section('content')
    <div class="container-fluid">
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Total Penduduk</h6>
                                <h3 id="totalPenduduk">0</h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-users fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-success text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Kategori Pendidikan</h6>
                                <h3 class="mb-0 mt-2">{{ $statistik }}</h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-graduation-cap fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-info text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Laki-laki</h6>
                                <h3 id="totalLakiLaki">0</h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-male fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-warning text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Perempuan</h6>
                                <h3 id="totalPerempuan">0</h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-female fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Top 10 Distribusi Pendidikan</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="pendidikanBarChart" height="400"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Proporsi Pendidikan</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="pendidikanPieChart" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Section: Tab + Table (Full Width) -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-3"><i class="fas fa-list me-2"></i>Kategori Pendidikan</h5>

                        <!-- Tab Navigation -->
                        <div id="pendidikanTabs" class="kategori-tabs">
                            <!-- Tabs akan dimuat via AJAX -->
                            <div class="p-3 text-center">
                                <i class="fas fa-spinner fa-spin"></i> Memuat kategori...
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">
                                <i class="fas fa-table me-2"></i>Detail Data: <span id="selectedCategory"
                                    class="text-primary">-</span>
                            </h6>
                            <button class="btn btn-sm btn-success" id="exportExcel">
                                <i class="fas fa-file-excel me-1"></i>Export Excel
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table-bordered table-hover table-striped table-sm nowrap table" id="detailTable">
                                <thead class="table-dark">
                                    <tr class="nowrap text-center">
                                        <th>NO</th>
                                        <th>NIK</th>
                                        <th>NAMA</th>
                                        <th>KK</th>
                                        <th>JENIS KELAMIN</th>
                                        <th>TANGGAL LAHIR</th>
                                        <th>ALAMAT</th>
                                        <th>RT/RW</th>
                                        <th>Desa</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div id="noDataMessage" class="alert alert-info mt-3" style="display: none;">
                            <i class="fas fa-info-circle me-2"></i>Tidak ada data untuk kategori ini
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden data for JavaScript -->
@endsection

@push('styles')
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        /* Sticky header hanya untuk horizontal scroll */
        .table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #343a40;
            /* Sesuaikan dengan warna table-dark */
        }

        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .list-group-item {
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }

        .list-group-item:hover {
            background-color: #f8f9fc;
        }

        .list-group-item.active {
            background-color: #4e73df;
            border-color: #4e73df;
            color: white;
        }

        .list-group-item.active .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .opacity-50 {
            opacity: 0.5;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        .legend-box {
            display: inline-block;
            width: 16px;
            height: 16px;
            border-radius: 3px;
            border: 2px solid #fff;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }

        /* Tab Kategori Styling */
        .kategori-tabs {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 8px;
            max-height: none;
            /* 3 baris x ~60px per baris */
            overflow-y: auto;
            padding: 10px;
            background-color: #f8f9fc;
            border-radius: 8px;
        }

        .kategori-tab-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            background: white;
            border: 2px solid #e3e6f0;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #5a5c69;
            font-size: 13px;
        }

        .kategori-tab-item:hover {
            border-color: #4e73df;
            background-color: #f8f9fc;
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .kategori-tab-item.active {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border-color: #4e73df;
            color: white;
            font-weight: 600;
        }

        .kategori-tab-item .legend-box {
            width: 12px;
            height: 12px;
            border-radius: 2px;
            flex-shrink: 0;
            margin-right: 8px;
        }

        .kategori-tab-item .tab-content {
            flex: 1;
            display: flex;
            align-items: center;
            min-width: 0;
        }

        .kategori-tab-item .tab-label {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 500;
        }

        .kategori-tab-item .tab-badge {
            background-color: #e3e6f0;
            color: #5a5c69;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 8px;
        }

        .kategori-tab-item.active .tab-badge {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
        }

        /* Scrollbar untuk tabs */
        .kategori-tabs::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .kategori-tabs::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .kategori-tabs::-webkit-scrollbar-thumb {
            background: #4e73df;
            border-radius: 10px;
        }

        .kategori-tabs::-webkit-scrollbar-thumb:hover {
            background: #224abe;
        }

        /* Table Responsive */
        .table-responsive {
            overflow-x: auto;
        }

        .table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #343a40;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .opacity-50 {
            opacity: 0.5;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(function() {
            let barChart, pieChart, detailTable;

            // Inisialisasi Bar Chart (Top 10)
            barChart = new Chart($('#pendidikanBarChart'), {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Laki-laki',
                        data: [],
                        backgroundColor: '#4e73df',
                        borderColor: '#4e73df',
                        borderWidth: 1
                    }, {
                        label: 'Perempuan',
                        data: [],
                        backgroundColor: '#e74a3b',
                        borderColor: '#e74a3b',
                        borderWidth: 1
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
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        },
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });

            // Inisialisasi Pie Chart (Legend di bawah)
            pieChart = new Chart($('#pendidikanPieChart'), {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                            '#858796', '#5a5c69', '#fd7e14', '#20c997', '#6f42c1',
                            '#e83e8c', '#17a2b8', '#28a745', '#ffc107', '#dc3545',
                            '#6610f2', '#d63384', '#0dcaf0', '#198754', '#0d6efd',
                            '#6c757d', '#ffc107', '#dc3545', '#198754', '#0dcaf0',
                            '#6610f2', '#d63384', '#fd7e14', '#20c997', '#6f42c1',
                            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 8,
                                font: {
                                    size: 10
                                },
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        return data.labels.slice(0, 10).map((label, i) => ({
                                            text: label,
                                            fillStyle: data.datasets[0].backgroundColor[i],
                                            hidden: false,
                                            index: i
                                        }));
                                    }
                                    return [];
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed || 0;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(1);
                                    return label + ': ' + value + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });

            // Tampilkan loading state
            $('#totalPenduduk').html('<i class="fas fa-spinner fa-spin"></i>');
            $('#totalLakiLaki').html('<i class="fas fa-spinner fa-spin"></i>');
            $('#totalPerempuan').html('<i class="fas fa-spinner fa-spin"></i>');
            $('#pendidikanList').html(
                '<div class="p-3 text-center"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>');

            /* ===========================
               LOAD DATA STATISTIK (Asynchronous)
            =========================== */
            $.getJSON("{{ route('pendidikan.json') }}", function(res) {
                const data = res.statistik;

                /* ===== UPDATE SUMMARY ===== */
                let laki = 0,
                    perempuan = 0;
                data.forEach(v => {
                    laki += Number(v.laki_laki);
                    perempuan += Number(v.perempuan);
                });

                $('#totalPenduduk').text(res.total.toLocaleString());
                $('#totalLakiLaki').text(laki.toLocaleString());
                $('#totalPerempuan').text(perempuan.toLocaleString());

                /* ===== UPDATE TAB PENDIDIKAN (dengan warna legend) ===== */
                const colors = [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                    '#858796', '#5a5c69', '#fd7e14', '#20c997', '#6f42c1',
                    '#e83e8c', '#17a2b8', '#28a745', '#ffc107', '#dc3545',
                    '#6610f2', '#d63384', '#0dcaf0', '#198754', '#0d6efd',
                    '#6c757d', '#ffc107', '#dc3545', '#198754', '#0dcaf0',
                    '#6610f2', '#d63384', '#fd7e14', '#20c997', '#6f42c1',
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
                ];

                let tabsHtml = '';
                data.forEach((v, i) => {
                    const color = colors[i % colors.length];

                    tabsHtml += `
                <a href="#" class="kategori-tab-item ${i===0?'active':''}"
                data-id="${v.pendidikan_id}" data-nama="${v.pendidikan_nama}">
                    <div class="tab-content">
                        <span class="legend-box" style="background-color: ${color};"></span>
                        <span class="tab-label" title="${v.pendidikan_nama}">${v.pendidikan_nama}</span>
                    </div>
                    <span class="tab-badge">${v.jumlah}</span>
                </a>`;
                });
                $('#pendidikanTabs').html(tabsHtml);

                /* ===========================
                   CLICK TAB
                =========================== */
                $(document).on('click', '.kategori-tab-item', function(e) {
                    e.preventDefault();
                    $('.kategori-tab-item').removeClass('active');
                    $(this).addClass('active');

                    $('#selectedCategory').text($(this).data('nama'));
                    loadTable($(this).data('id'));
                });

                /* ===== UPDATE CHART DATA ===== */
                const labels = data.map(v => v.pendidikan_nama);
                const lakiArr = data.map(v => Number(v.laki_laki));
                const perempuanArr = data.map(v => Number(v.perempuan));
                const totalArr = data.map(v => Number(v.jumlah));

                // Untuk Bar Chart: Ambil hanya Top 10 kategori terbesar
                const top10Labels = labels.slice(0, 10);
                const top10Laki = lakiArr.slice(0, 10);
                const top10Perempuan = perempuanArr.slice(0, 10);

                // Update bar chart dengan top 10 saja
                barChart.data.labels = top10Labels;
                barChart.data.datasets[0].data = top10Laki;
                barChart.data.datasets[1].data = top10Perempuan;
                barChart.update();

                // Update pie chart dengan semua data
                pieChart.data.labels = labels;
                pieChart.data.datasets[0].data = totalArr;
                pieChart.update();

                /* ===== AUTO LOAD TABLE (hanya jika ada data) ===== */
                if (data.length) {
                    $('#selectedCategory').text(data[0].pendidikan_nama);
                    // Delay sedikit agar chart render dulu
                    setTimeout(() => {
                        loadTable(data[0].pendidikan_id);
                    }, 100);
                }
            }).fail(function() {
                // Handle error
                $('#pendidikanList').html(
                    '<div class="p-3 text-center text-danger"><i class="fas fa-exclamation-triangle"></i> Gagal memuat data</div>'
                );
            });

            /* ===========================
                DATATABLE (Lazy Load)
            =========================== */
            function loadTable(id) {

                if (detailTable) {
                    detailTable.destroy();
                }

                detailTable = $('#detailTable').DataTable({
                    responsive: false,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,
                    ordering: true,
                    paging: true,
                    searching: true,
                    info: true,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    ajax: {
                        url: "{{ route('pendidikan.datatable') }}",
                        data: {
                            pendidikan_id: id
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
                            class: 'nowrap text-center',
                            defaultContent: '-'
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            class: 'nowrap',
                            defaultContent: '-'
                        },
                        {
                            data: 'no_kk',
                            name: 'no_kk',
                            class: 'nowrap text-center',
                            defaultContent: '-'
                        },
                        {
                            data: 'jenkel',
                            name: 'jenkel',
                            class: 'text-center nowrap'
                        },
                        {
                            data: 'tgl_lahir',
                            name: 'tgl_lahir',
                            class: 'text-center nowrap'
                        },
                        {
                            data: 'kp',
                            name: 'kp',
                            class: 'text-left nowrap'
                        },
                        {
                            data: 'rt_rw',
                            name: 'rt_rw',
                            orderable: false,
                            searchable: false,
                            class: 'text-center nowrap'
                        },
                        {
                            data: 'desa',
                            name: 'desa',
                            class: 'text-center nowrap'
                        }
                    ],
                });
            }


            /* ===========================
               EXPORT EXCEL
            =========================== */
            document.getElementById('exportExcel').addEventListener('click', function() {
                if (!detailTable) {
                    alert('Data belum dimuat');
                    return;
                }

                const data = detailTable.rows({
                    search: 'applied'
                }).data();
                if (data.length === 0) {
                    alert('Tidak ada data untuk di-export');
                    return;
                }

                let csv = 'No,NIK,Nama,No KK,Jenis Kelamin,Tanggal Lahir,Alamat,RT/RW,Desa\n';
                data.each(function(row, index) {
                    csv +=
                        `"${index + 1}","${row.no_nik}","${row.nama}","${row.no_kk}","${row.jenkel}","${row.tgl_lahir}","${row.kp}","${row.rt_rw}","${row.desa}"\n`;
                });

                const blob = new Blob([csv], {
                    type: 'text/csv;charset=utf-8;'
                });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                const category = document.getElementById('selectedCategory').innerText;

                a.href = url;
                a.download = `Pendidikan_${category}_${new Date().toISOString().split('T')[0]}.csv`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            });
        });
    </script>
@endpush
