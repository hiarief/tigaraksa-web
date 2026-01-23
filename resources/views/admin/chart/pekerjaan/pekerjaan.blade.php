@extends('admin.layout.main')
@section('title', 'Statistik Umur')
@section('content-header', 'Statistik Umur')

@section('content')
    <div class="container-fluid">
        <!-- Tabs -->
        <ul class="nav nav-tabs" id="umurTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="semua-tab" data-toggle="tab" href="#semua" role="tab">
                    <i class="fas fa-users"></i> Semua Penduduk
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pemilih-tab" data-toggle="tab" href="#pemilih" role="tab">
                    <i class="fas fa-vote-yea"></i> Pemilih (17+ Tahun)
                </a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="umurTabContent">
            <!-- Tab Semua Penduduk -->
            <div class="tab-pane fade show active" id="semua" role="tabpanel">
                <div class="row mt-3">
                    <!-- Card Piramida Penduduk -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-bar"></i> Piramida Penduduk
                                </h3>
                            </div>
                            <div class="card-body">
                                <div id="loadingPiramida" class="py-5 text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <p class="mt-2">Memuat data...</p>
                                </div>
                                <canvas id="piramidaChart" style="display:none; height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Card Distribusi Kelompok Umur -->
                    <div class="col-md-6 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie"></i> Distribusi Kelompok Umur
                                </h3>
                            </div>
                            <div class="card-body">
                                <div id="loadingDistribusi" class="py-5 text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <canvas id="distribusiChart" style="display:none;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Card Statistik -->
                    <div class="col-md-6 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-info-circle"></i> Ringkasan Statistik
                                </h3>
                            </div>
                            <div class="card-body">
                                <div id="loadingStats" class="py-5 text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="statistikContent" style="display:none;">
                                    <table class="table-sm table">
                                        <tr>
                                            <td><strong>Total Penduduk</strong></td>
                                            <td class="text-right"><span id="totalPenduduk">-</span> orang</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Laki-laki</strong></td>
                                            <td class="text-right"><span id="totalLaki">-</span> orang</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Perempuan</strong></td>
                                            <td class="text-right"><span id="totalPerempuan">-</span> orang</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Rasio Jenis Kelamin</strong></td>
                                            <td class="text-right"><span id="rasio">-</span> <span> : 100</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Pemilih -->
            <div class="tab-pane fade" id="pemilih" role="tabpanel">
                <div class="row mt-3">
                    <!-- Card Piramida Pemilih -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-bar"></i> Piramida Pemilih (17+ Tahun)
                                </h3>
                            </div>
                            <div class="card-body">
                                <div id="loadingPiramidaPemilih" class="py-5 text-center">
                                    <div class="spinner-border text-success" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <p class="mt-2">Memuat data...</p>
                                </div>
                                <canvas id="piramidaPemilihChart" style="display:none; height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Card Statistik Pemilih -->
                    <div class="col-md-12 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-info-circle"></i> Ringkasan Pemilih
                                </h3>
                            </div>
                            <div class="card-body">
                                <div id="loadingStatsPemilih" class="py-5 text-center">
                                    <div class="spinner-border text-success" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="statistikPemilihContent" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="info-box bg-success">
                                                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Total Pemilih</span>
                                                    <span class="info-box-number" id="totalPemilih">-</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-box bg-info">
                                                <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Laki-laki</span>
                                                    <span class="info-box-number" id="pemilihLaki">-</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-box bg-warning">
                                                <span class="info-box-icon"><i class="fas fa-female"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Perempuan</span>
                                                    <span class="info-box-number" id="pemilihPerempuan">-</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-box bg-danger">
                                                <span class="info-box-icon"><i class="fas fa-percentage"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">% dari Total</span>
                                                    <span class="info-box-number" id="persenPemilih">-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    <style>
        .nav-tabs .nav-link {
            color: #495057;
        }

        .nav-tabs .nav-link.active {
            font-weight: bold;
        }

        .info-box {
            min-height: 80px;
            color: white;
        }

        .info-box-icon {
            font-size: 2rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        let piramidaChart, distribusiChart, piramidaPemilihChart;
        let dataLoaded = false;

        $(document).ready(function() {
            // Load data saat halaman pertama kali dibuka
            loadData();

            // Handle tab change
            $('#umurTab a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                // Resize charts ketika tab berubah
                if (piramidaChart) piramidaChart.resize();
                if (distribusiChart) distribusiChart.resize();
                if (piramidaPemilihChart) piramidaPemilihChart.resize();
            });
        });

        function loadData() {
            if (dataLoaded) return; // Prevent double loading

            $.ajax({
                url: '{{ route('admin.umur.data') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    dataLoaded = true;
                    processDataSemua(response.kelompok_umur);
                    processDataPemilih(response.pemilih, response.kelompok_umur);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading data:', error);
                    alert('Gagal memuat data. Silakan refresh halaman.');
                }
            });
        }

        function processDataSemua(data) {
            // Kelompokkan data
            let kelompokUmur = ['0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49',
                '50-54', '55-59', '60-64', '65-69', '70-74', '75+'
            ];
            let lakiLaki = new Array(kelompokUmur.length).fill(0);
            let perempuan = new Array(kelompokUmur.length).fill(0);

            data.forEach(item => {
                let index = kelompokUmur.indexOf(item.kelompok_umur);
                if (index !== -1) {
                    if (item.jenkel == 1) {
                        lakiLaki[index] = parseInt(item.jumlah);
                    } else if (item.jenkel == 2) {
                        perempuan[index] = parseInt(item.jumlah);
                    }
                }
            });

            // Hitung statistik
            let totalLaki = lakiLaki.reduce((a, b) => a + b, 0);
            let totalPerempuan = perempuan.reduce((a, b) => a + b, 0);
            let totalPenduduk = totalLaki + totalPerempuan;
            let rasio = totalPerempuan > 0 ? (totalLaki / totalPerempuan * 100).toFixed(2) : 0;

            // Update statistik
            $('#totalPenduduk').text(totalPenduduk.toLocaleString());
            $('#totalLaki').text(totalLaki.toLocaleString());
            $('#totalPerempuan').text(totalPerempuan.toLocaleString());

            $('#rasio').text(rasio + ' : 100');

            // Sembunyikan loading
            $('#loadingPiramida, #loadingDistribusi, #loadingStats').hide();
            $('#piramidaChart, #distribusiChart, #statistikContent').show();

            // Render charts
            renderPiramida(kelompokUmur, lakiLaki, perempuan);
            renderDistribusi(kelompokUmur, lakiLaki, perempuan);
        }

        function processDataPemilih(dataPemilih, dataAll) {
            // Kelompokkan data pemilih
            let kelompokUmur = ['17-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60-64',
                '65-69', '70-74', '75+'
            ];
            let lakiLaki = new Array(kelompokUmur.length).fill(0);
            let perempuan = new Array(kelompokUmur.length).fill(0);

            dataPemilih.forEach(item => {
                let index = kelompokUmur.indexOf(item.kelompok_umur);
                if (index !== -1) {
                    if (item.jenkel == 1) {
                        lakiLaki[index] = parseInt(item.jumlah);
                    } else if (item.jenkel == 2) {
                        perempuan[index] = parseInt(item.jumlah);
                    }
                }
            });

            // Hitung statistik pemilih
            let pemilihLaki = lakiLaki.reduce((a, b) => a + b, 0);
            let pemilihPerempuan = perempuan.reduce((a, b) => a + b, 0);
            let totalPemilih = pemilihLaki + pemilihPerempuan;

            // Hitung total penduduk untuk persentase
            let totalPenduduk = 0;
            dataAll.forEach(item => {
                totalPenduduk += parseInt(item.jumlah);
            });

            let persenPemilih = totalPenduduk > 0 ? ((totalPemilih / totalPenduduk) * 100).toFixed(2) : 0;

            // Update statistik
            $('#totalPemilih').text(totalPemilih.toLocaleString());
            $('#pemilihLaki').text(pemilihLaki.toLocaleString());
            $('#pemilihPerempuan').text(pemilihPerempuan.toLocaleString());
            $('#persenPemilih').text(persenPemilih + '%');

            // Sembunyikan loading
            $('#loadingPiramidaPemilih, #loadingStatsPemilih').hide();
            $('#piramidaPemilihChart, #statistikPemilihContent').show();

            // Render chart
            renderPiramidaPemilih(kelompokUmur, lakiLaki, perempuan);
        }

        function renderPiramida(labels, lakiLaki, perempuan) {
            const ctx = document.getElementById('piramidaChart').getContext('2d');

            // Destroy existing chart
            if (piramidaChart) {
                piramidaChart.destroy();
            }

            piramidaChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Laki-laki',
                            data: lakiLaki.map(val => -val), // Negative for left side
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Perempuan',
                            data: perempuan,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
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
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    let value = Math.abs(context.parsed.x);
                                    return label + ': ' + value.toLocaleString() + ' orang';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                callback: function(value) {
                                    return Math.abs(value).toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        function renderDistribusi(labels, lakiLaki, perempuan) {
            const ctx = document.getElementById('distribusiChart').getContext('2d');

            if (distribusiChart) {
                distribusiChart.destroy();
            }

            let total = lakiLaki.map((val, idx) => val + perempuan[idx]);

            distribusiChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: total,
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                            '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384',
                            '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(1);
                                    return label + ': ' + value.toLocaleString() + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

        function renderPiramidaPemilih(labels, lakiLaki, perempuan) {
            const ctx = document.getElementById('piramidaPemilihChart').getContext('2d');

            if (piramidaPemilihChart) {
                piramidaPemilihChart.destroy();
            }

            piramidaPemilihChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Laki-laki',
                            data: lakiLaki.map(val => -val),
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Perempuan',
                            data: perempuan,
                            backgroundColor: 'rgba(255, 159, 64, 0.7)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
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
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    let value = Math.abs(context.parsed.x);
                                    return label + ': ' + value.toLocaleString() + ' orang';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                callback: function(value) {
                                    return Math.abs(value).toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
@endpush
