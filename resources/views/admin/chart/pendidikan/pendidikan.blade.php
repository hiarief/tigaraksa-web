@extends('admin.layout.main')
@section('title', 'Statistik Pendidikan')
@section('content-header', 'Statistik Pendidikan')

@section('content')
    <!-- Header Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card-premium elevation-2">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-graduation-cap"></i>
                        </div>

                        <div class="ml-3">
                            <h5 class="font-weight-bold mb-1">Ringkasan Statistik Pendidikan</h5>
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
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-users"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalPenduduk">
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

        <!-- Kategori Pendidikan -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-success text-white">
                            <i class="fas fa-graduation-cap"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium">{{ $statistik }}</p>

                            <p class="stat-label-premium mb-0">
                                Kategori Pendidikan
                                <i class="fas fa-graduation-cap stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Tingkat Pendidikan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Laki-laki -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-info text-white">
                            <i class="fas fa-male"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalLakiLaki">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Laki-laki
                                <i class="fas fa-male stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Total Laki-laki</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Perempuan -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-warning text-white">
                            <i class="fas fa-female"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalPerempuan">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Perempuan
                                <i class="fas fa-female stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Total Perempuan</p>
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

        <!-- Bar Chart -->
        <div class="col-lg-7 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Top 10 Distribusi Pendidikan</h3>
                        <p class="card-subtitle-premium">Tingkat pendidikan tertinggi berdasarkan gender</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingBarChart" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="barChartWrapper">
                        <canvas id="pendidikanBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-lg-5 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-success">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Proporsi Pendidikan</h3>
                        <p class="card-subtitle-premium">Komposisi tingkat pendidikan populasi</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingPieChart" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="pieChartWrapper">
                        <canvas id="pendidikanPieChart"></canvas>
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
                        <h3 class="card-title-premium">Data Detail Pendidikan</h3>
                        <p class="card-subtitle-premium">Eksplorasi data berdasarkan kategori pendidikan</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium p-0">
                    <!-- Category Grid Pills -->
                    <div class="pills-container-premium">
                        <div id="pendidikanTabs" class="kategori-tabs-premium">
                            <!-- Tabs akan dimuat via AJAX -->
                            <div class="loading-tabs-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memuat kategori...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="tab-content-premium">
                        <div class="table-header-premium">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-dark font-weight-bold mb-0">
                                    <i class="fas fa-table text-primary mr-2"></i>Detail Data:
                                    <span id="selectedCategory" class="text-primary">-</span>
                                </h6>
                                <button class="btn btn-success btn-sm elevation-2" id="exportExcel">
                                    <i class="fas fa-file-excel mr-1"></i>Export Excel
                                </button>
                            </div>
                        </div>

                        <div class="table-container-premium">
                            <div class="table-responsive">
                                <table class="table-premium" id="detailTable">
                                    <thead>
                                        <tr>
                                            <th width="1%">No</th>
                                            <th>NIK</th>
                                            <th>Nama Lengkap</th>
                                            <th>No. KK</th>
                                            <th>JK</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Alamat</th>
                                            <th>RT/RW</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                            </div>
                        </div>

                        <div id="noDataMessage" class="alert-premium alert-info-premium" style="display: none;">
                            <div class="alert-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="alert-content">
                                <h5 class="alert-title">Tidak Ada Data</h5>
                                <p class="alert-text">Tidak ada data untuk kategori ini</p>
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
        $(function() {
            let barChart, pieChart, detailTable;

            // Initialize Select2 with premium theme
            $('.select2-primary').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Pilih RT/RW'
            });

            $('.select2-success').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Pilih Desa'
            });

            $('.select2-info').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Pilih Jenis Kelamin'
            });

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
                        borderWidth: 2,
                        borderRadius: 8
                    }, {
                        label: 'Perempuan',
                        data: [],
                        backgroundColor: '#e74a3b',
                        borderColor: '#e74a3b',
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
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
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.03)'
                            }
                        },
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45,
                                font: {
                                    size: 11,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Inisialisasi Pie Chart
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
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 12,
                                font: {
                                    size: 11,
                                    weight: '600'
                                },
                                usePointStyle: true,
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
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            padding: 15,
                            cornerRadius: 8,
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

            /* ===========================
               LOAD DATA STATISTIK
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

                $('#totalPenduduk').text(res.total.toLocaleString('id-ID'));
                $('#totalLakiLaki').text(laki.toLocaleString('id-ID'));
                $('#totalPerempuan').text(perempuan.toLocaleString('id-ID'));

                /* ===== UPDATE TAB PENDIDIKAN (PREMIUM GRID) ===== */
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
                        <a href="#" class="kategori-tab-item-premium ${i===0?'active':''}"
                           data-id="${v.pendidikan_id}" data-nama="${v.pendidikan_nama}">
                            <div class="tab-content-wrapper">
                                <span class="legend-box-premium" style="background-color: ${color};"></span>
                                <span class="tab-label-premium" title="${v.pendidikan_nama}">${v.pendidikan_nama}</span>
                            </div>
                            <span class="tab-badge-premium">${v.jumlah}</span>
                        </a>`;
                });
                $('#pendidikanTabs').html(tabsHtml);

                /* ===========================
                   CLICK TAB
                =========================== */
                $(document).on('click', '.kategori-tab-item-premium', function(e) {
                    e.preventDefault();
                    $('.kategori-tab-item-premium').removeClass('active');
                    $(this).addClass('active');

                    $('#selectedCategory').text($(this).data('nama'));
                    loadTable($(this).data('id'));

                    // Smooth scroll to table
                    $('html, body').animate({
                        scrollTop: $('.table-container-premium').offset().top - 100
                    }, 300);
                });

                /* ===== UPDATE CHART DATA ===== */
                const labels = data.map(v => v.pendidikan_nama);
                const lakiArr = data.map(v => Number(v.laki_laki));
                const perempuanArr = data.map(v => Number(v.perempuan));
                const totalArr = data.map(v => Number(v.jumlah));

                // Top 10 untuk Bar Chart
                const top10Labels = labels.slice(0, 10);
                const top10Laki = lakiArr.slice(0, 10);
                const top10Perempuan = perempuanArr.slice(0, 10);

                // Update charts dengan animasi
                $('#loadingBarChart').fadeOut(300, function() {
                    $('#barChartWrapper').fadeIn(400);

                    barChart.data.labels = top10Labels;
                    barChart.data.datasets[0].data = top10Laki;
                    barChart.data.datasets[1].data = top10Perempuan;
                    barChart.update();
                });

                $('#loadingPieChart').fadeOut(300, function() {
                    $('#pieChartWrapper').fadeIn(400);

                    pieChart.data.labels = labels;
                    pieChart.data.datasets[0].data = totalArr;
                    pieChart.update();
                });

                /* ===== AUTO LOAD TABLE ===== */
                if (data.length) {
                    $('#selectedCategory').text(data[0].pendidikan_nama);
                    setTimeout(() => {
                        loadTable(data[0].pendidikan_id);
                    }, 100);
                }
            }).fail(function() {
                $('#pendidikanTabs').html(
                    '<div class="alert-premium alert-info-premium"><div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div><div class="alert-content"><h5 class="alert-title">Error</h5><p class="alert-text">Gagal memuat data</p></div></div>'
                );
            });

            /* ===========================
                DATATABLE
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
                            class: 'text-center'
                        },
                        {
                            data: 'no_nik',
                            name: 'no_nik',
                            class: 'text-center',
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
                            class: 'text-center',
                            defaultContent: '-'
                        },
                        {
                            data: 'jenkel',
                            name: 'jenkel',
                            class: 'text-center'
                        },
                        {
                            data: 'tgl_lahir',
                            name: 'tgl_lahir',
                            class: 'text-center'
                        },
                        {
                            data: 'kp',
                            name: 'kp',
                            class: 'text-left'
                        },
                        {
                            data: 'rt_rw',
                            name: 'rt_rw',
                            orderable: false,
                            searchable: false,
                            class: 'text-center'
                        },
                    ],
                });
            }

            /* ===========================
               EXPORT EXCEL
            =========================== */
            document.getElementById('exportExcel').addEventListener('click', function() {
                if (!detailTable) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Data belum dimuat',
                        confirmButtonColor: '#667eea'
                    });
                    return;
                }

                const data = detailTable.rows({
                    search: 'applied'
                }).data();

                if (data.length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Informasi',
                        text: 'Tidak ada data untuk di-export',
                        confirmButtonColor: '#667eea'
                    });
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

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil di-export',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        });
    </script>
@endpush
