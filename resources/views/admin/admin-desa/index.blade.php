@extends('admin.layout.main')
@section('title', 'Statistik Admin Desa')
@section('content-header', 'Statistik Admin Desa')

@section('content')
    <!-- Header Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card-premium elevation-2">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-chart-line"></i>
                        </div>

                        <div class="ml-3">
                            <h5 class="font-weight-bold mb-1">Ringkasan Statistik Admin Desa</h5>
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

        <!-- Total Admin Desa -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-info text-white">
                            <i class="fas fa-users"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="total-users">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Total Admin Desa
                                <i class="fas fa-users stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Admin Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total KK -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-success text-white">
                            <i class="fas fa-address-card"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="total-kk">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Total Kartu Keluarga
                                <i class="fas fa-address-card stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Data KK</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Anggota -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-user-friends"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="total-anggota">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Total Anggota Keluarga
                                <i class="fas fa-user-friends stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Anggota Terdaftar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Belum Input -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-danger text-white">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="users-without-data">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Admin Belum Input
                                <i class="fas fa-exclamation-triangle stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Perlu Tindakan</p>
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

        <!-- Top 10 Admin Chart -->
        <div class="col-lg-7 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Top 10 Admin dengan Input Tertinggi</h3>
                        <p class="card-subtitle-premium">Admin dengan jumlah KK & Anggota Terbanyak</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-top-users" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="container-top-users">
                        <canvas id="topUsersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Chart -->
        <div class="col-lg-5 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-success">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Kategori Admin Berdasarkan Produktivitas</h3>
                        <p class="card-subtitle-premium">Distribusi Tingkat Produktivitas</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loading-category" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data...</p>
                    </div>
                    <div style="position: relative; height: 400px; display: none;" id="container-category">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics -->
    <div class="row mb-4">
        <div class="col-12 mb-3">
            <h4 class="section-title">
                <i class="fas fa-info-circle mr-2"></i> Statistik Rata-rata
            </h4>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-success text-white">
                            <i class="fas fa-chart-line"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="avg-kk-per-user">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Rata-rata KK per Admin
                                <i class="fas fa-chart-line stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">KK / Admin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-info text-white">
                            <i class="fas fa-chart-area"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="avg-anggota-per-user">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Rata-rata Anggota per Admin
                                <i class="fas fa-chart-area stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Anggota / Admin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-check-circle"></i>
                        </div>

                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="users-with-data">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>

                            <p class="stat-label-premium mb-0">
                                Admin Sudah Input Data
                                <i class="fas fa-check-circle stat-mini-icon"></i>
                            </p>

                            <p class="stat-sublabel-premium mb-0">Admin Aktif Input</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable -->
    <div class="row">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-dark">
                    <div class="card-header-icon">
                        <i class="fas fa-table"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Detail Data Per Admin</h3>
                        <p class="card-subtitle-premium">Informasi lengkap statistik setiap admin desa</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-sm btn-light mr-2" id="refresh-table">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium p-0">
                    <div class="table-container-premium">
                        <div class="table-responsive">
                            <table id="users-table" class="table-premium">
                                <thead>
                                    <tr class="nowrap">
                                        <th style="width: 1%">No</th>
                                        <th>Nama Admin</th>
                                        <th>Desa</th>
                                        <th>Total KK</th>
                                        <th>Total Anggota</th>
                                        <th>Rata-rata Anggota/KK</th>
                                        <th>Kategori</th>
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
            let chartData = null;
            let topUsersChart = null;
            let categoryChart = null;

            // Color schemes
            const colors = {
                primary: ['rgba(54, 162, 235, 0.8)', 'rgba(75, 192, 192, 0.8)'],
                primaryBorder: ['rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)'],
                category: [
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(0, 123, 255, 0.8)',
                    'rgba(40, 167, 69, 0.8)'
                ],
                categoryBorder: [
                    'rgba(220, 53, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(0, 123, 255, 1)',
                    'rgba(40, 167, 69, 1)'
                ]
            };

            // Load Statistics
            function loadStatistics() {
                $.ajax({
                    url: '{{ route('admin.desa.statistics') }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update summary cards
                            $('#total-users').html(response.summary.total_users.toLocaleString(
                            'id-ID'));
                            $('#total-kk').html(response.summary.total_kk.toLocaleString('id-ID'));
                            $('#total-anggota').html(response.summary.total_anggota.toLocaleString(
                                'id-ID'));
                            $('#users-without-data').html(response.summary.users_without_data
                                .toLocaleString('id-ID'));
                            $('#avg-kk-per-user').html(response.summary.avg_kk_per_user.toFixed(2));
                            $('#avg-anggota-per-user').html(response.summary.avg_anggota_per_user
                                .toFixed(2));
                            $('#users-with-data').html(response.summary.users_with_data.toLocaleString(
                                'id-ID'));

                            chartData = response.data;

                            // Load charts
                            loadTopUsersChart();
                            loadCategoryChart();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading statistics:', error);
                        alert('Gagal memuat statistik. Silakan refresh halaman.');
                    }
                });
            }

            // Top Users Chart
            function loadTopUsersChart() {
                $('#loading-top-users').fadeOut(300, function() {
                    $('#container-top-users').fadeIn(400);

                    // Sort and get top 10
                    let sortedData = chartData.sort((a, b) => b.total_kk - a.total_kk).slice(0, 10);

                    const ctx = document.getElementById('topUsersChart').getContext('2d');

                    if (topUsersChart) {
                        topUsersChart.destroy();
                    }

                    topUsersChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: sortedData.map(item => item.nama_user),
                            datasets: [{
                                label: 'Jumlah KK',
                                data: sortedData.map(item => item.total_kk),
                                backgroundColor: colors.primary[0],
                                borderColor: colors.primaryBorder[0],
                                borderWidth: 1,
                                borderRadius: 10
                            }, {
                                label: 'Jumlah Anggota',
                                data: sortedData.map(item => item.total_anggota),
                                backgroundColor: colors.primary[1],
                                borderColor: colors.primaryBorder[1],
                                borderWidth: 1,
                                borderRadius: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        padding: 15,
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
                                    },
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': ' + context.parsed
                                                .y.toLocaleString();
                                        }
                                    }
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
                                        },
                                        callback: function(value) {
                                            return value.toLocaleString();
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        font: {
                                            size: 11,
                                            weight: 'bold'
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            }

            // Category Chart
            function loadCategoryChart() {
                $('#loading-category').fadeOut(300, function() {
                    $('#container-category').fadeIn(400);

                    // Categorize users
                    let categories = {
                        'Tidak Aktif': 0,
                        'Aktif Rendah': 0,
                        'Aktif Sedang': 0,
                        'Aktif Tinggi': 0
                    };

                    chartData.forEach(item => {
                        if (item.total_kk == 0) {
                            categories['Tidak Aktif']++;
                        } else if (item.total_kk < 100) {
                            categories['Aktif Rendah']++;
                        } else if (item.total_kk < 150) {
                            categories['Aktif Sedang']++;
                        } else {
                            categories['Aktif Tinggi']++;
                        }
                    });

                    const ctx = document.getElementById('categoryChart').getContext('2d');

                    if (categoryChart) {
                        categoryChart.destroy();
                    }

                    categoryChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: Object.keys(categories),
                            datasets: [{
                                data: Object.values(categories),
                                backgroundColor: colors.category,
                                borderColor: colors.categoryBorder,
                                borderWidth: 4,
                                hoverBorderWidth: 6,
                                hoverOffset: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
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
                                    },
                                    callbacks: {
                                        label: function(context) {
                                            const total = context.dataset.data.reduce((a, b) =>
                                                a + b, 0);
                                            const percentage = ((context.parsed / total) * 100)
                                                .toFixed(1);
                                            return context.label + ': ' + context.parsed +
                                                ' (' + percentage + '%)';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            }

            // Initialize DataTable
            const table = $('#users-table').DataTable({
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
                destroy: true,
                order: [
                    [3, 'desc']
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
                ajax: '{{ route('admin.desa.datatables') }}',
                columns: [{
                        data: null,
                        name: 'no',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nama_user',
                        name: 'u.name'
                    },
                    {
                        data: 'nama_desa',
                        name: 'v.name'
                    },
                    {
                        data: 'total_kk',
                        name: 'total_kk',
                        className: 'text-center'
                    },
                    {
                        data: 'total_anggota',
                        name: 'total_anggota',
                        className: 'text-center'
                    },
                    {
                        data: 'avg_anggota_per_kk',
                        name: 'avg_anggota_per_kk',
                        orderable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'kategori',
                        name: 'kategori',
                        orderable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        className: 'text-center'
                    }
                ],
            });

            // Refresh table button
            $('#refresh-table').on('click', function() {
                table.ajax.reload();
            });

            // Load initial data
            loadStatistics();
        });
    </script>
@endpush
