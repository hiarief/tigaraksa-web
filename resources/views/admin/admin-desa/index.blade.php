@extends('admin.layout.main')
@section('title', 'Statistik Admin Desa')
@section('content-header', 'Statistik Admin Desa')

@section('content')
    <!-- Summary Cards -->
    <div class="row" id="summary-cards">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total-users"><i class="fas fa-spinner fa-spin"></i></h3>
                    <p>Total Admin Desa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="total-kk"><i class="fas fa-spinner fa-spin"></i></h3>
                    <p>Total Kartu Keluarga</p>
                </div>
                <div class="icon">
                    <i class="fas fa-address-card"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="total-anggota" class="text-white"><i class="fas fa-spinner fa-spin"></i></h3>
                    <p class="text-white">Total Anggota Keluarga</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-friends"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="users-without-data"><i class="fas fa-spinner fa-spin"></i></h3>
                    <p>Admin Belum Input</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Top 10 Admin dengan Input Tertinggi
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="topUsersChart" style="height: 300px;"></canvas>
                </div>
                <div class="overlay" id="chart1-overlay">
                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Kategori Admin Berdasarkan Produktivitas
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" style="height: 300px;"></canvas>
                </div>
                <div class="overlay" id="chart2-overlay">
                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-1"></i>
                        Statistik Lainnya
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box bg-gradient-success">
                                <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Rata-rata KK per Admin</span>
                                    <span class="info-box-number" id="avg-kk-per-user">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box bg-gradient-info">
                                <span class="info-box-icon"><i class="fas fa-chart-area"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Rata-rata Anggota per Admin</span>
                                    <span class="info-box-number" id="avg-anggota-per-user">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box bg-gradient-primary">
                                <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Admin Sudah Input Data</span>
                                    <span class="info-box-number" id="users-with-data">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table mr-1"></i>
                        Detail Data Per Admin
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-primary" id="refresh-table">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="users-table" class="table-bordered table-striped table-hover table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Admin</th>
                                    <th>Desa</th>
                                    <th>Total KK</th>
                                    <th>Total Anggota</th>
                                    <th>Rata-rata Anggota/KK</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
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
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .info-box-number {
            font-size: 1.5rem !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            let chartData = null;
            let topUsersChart = null;
            let categoryChart = null;

            // Load Statistics
            function loadStatistics() {
                $.ajax({
                    url: '{{ route('admin.desa.statistics') }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update summary cards
                            $('#total-users').text(response.summary.total_users.toLocaleString());
                            $('#total-kk').text(response.summary.total_kk.toLocaleString());
                            $('#total-anggota').text(response.summary.total_anggota.toLocaleString());
                            $('#users-without-data').text(response.summary.users_without_data
                                .toLocaleString());
                            $('#avg-kk-per-user').text(response.summary.avg_kk_per_user.toFixed(2));
                            $('#avg-anggota-per-user').text(response.summary.avg_anggota_per_user
                                .toFixed(2));
                            $('#users-with-data').text(response.summary.users_with_data
                                .toLocaleString());

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
                $('#chart1-overlay').hide();

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
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Jumlah Anggota',
                            data: sortedData.map(item => item.total_anggota),
                            backgroundColor: 'rgba(75, 192, 192, 0.8)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
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
            }

            // Category Chart
            function loadCategoryChart() {
                $('#chart2-overlay').hide();

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
                            backgroundColor: [
                                'rgba(220, 53, 69, 0.8)',
                                'rgba(255, 193, 7, 0.8)',
                                'rgba(0, 123, 255, 0.8)',
                                'rgba(40, 167, 69, 0.8)'
                            ],
                            borderColor: [
                                'rgba(220, 53, 69, 1)',
                                'rgba(255, 193, 7, 1)',
                                'rgba(0, 123, 255, 1)',
                                'rgba(40, 167, 69, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }
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
                    [10, 25, 50, 100, "All"]
                ],
                destroy: true,
                order: [
                    [3, 'desc']
                ],
                ajax: '{{ route('admin.desa.datatables') }}',
                columns: [{
                        data: null,
                        name: 'no',
                        orderable: false,
                        searchable: false,
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
                        className: 'text-right'
                    },
                    {
                        data: 'total_anggota',
                        name: 'total_anggota',
                        className: 'text-right'
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
                        orderable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false
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
