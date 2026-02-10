@extends('admin.layout.main')
@section('title', 'Statistik Kependudukan')
@section('content-header', 'Statistik Kependudukan')

@section('content')


    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card-premium elevation-2">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-users"></i>
                        </div>

                        <div class="ml-3">
                            <h5 class="font-weight-bold mb-1">Ringkasan Statistik Kependudukan</h5>
                            <p class="stat-sublabel-premium mb-0">
                                Data diperbarui secara otomatis berdasarkan database terkini
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium Info Cards Row 1 -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-primary text-white">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalKK">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>
                            <p class="stat-label-premium mb-0">
                                Total Keseluruhan
                                <i class="fas fa-users stat-mini-icon"></i>
                            </p>
                            <p class="stat-sublabel-premium mb-0">Kartu Keluarga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-secondary text-white">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalRW">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>
                            <p class="stat-label-premium mb-0">
                                Total RW
                                <i class="fas fa-layer-group stat-mini-icon"></i>
                            </p>
                            <p class="stat-sublabel-premium mb-0">Rukun Warga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-orange text-white">
                            <i class="fas fa-map-signs"></i>
                        </div>
                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalRT">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>
                            <p class="stat-label-premium mb-0">
                                Total RT
                                <i class="fas fa-map-signs stat-mini-icon"></i>
                            </p>
                            <p class="stat-sublabel-premium mb-0">Rukun Tetangga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-warning text-white">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalNIK">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>
                            <p class="stat-label-premium mb-0">
                                Total Keseluruhan
                                <i class="fas fa-id-card stat-mini-icon"></i>
                            </p>
                            <p class="stat-sublabel-premium mb-0">Nomor Induk Kependudukan</p>
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
                            <i class="fas fa-male"></i>
                        </div>
                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalLakilaki">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>
                            <p class="stat-label-premium mb-0">
                                Total Laki-laki
                                <i class="fas fa-male stat-mini-icon"></i>
                            </p>
                            <p class="stat-sublabel-premium mb-0">Penduduk Laki-laki</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-premium elevation-3">
                <div class="stat-card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon-premium icon-danger text-white">
                            <i class="fas fa-female"></i>
                        </div>
                        <div class="flex-grow-1 ml-3">
                            <p class="stat-number-premium" id="totalPerempuan">
                                <span class="skeleton-premium skeleton-number-premium"></span>
                            </p>
                            <p class="stat-label-premium mb-0">
                                Total Perempuan
                                <i class="fas fa-female stat-mini-icon"></i>
                            </p>
                            <p class="stat-sublabel-premium mb-0">Penduduk Perempuan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section - Premium Design -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-primary">
                    <div class="card-header-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Distribusi KK per RT di Setiap RW</h3>
                        <p class="card-subtitle-premium">Visualisasi jumlah Kartu Keluarga berdasarkan wilayah</p>
                    </div>
                    <div class="card-tools-premium">
                        <div class="custom-control custom-switch custom-switch-premium mr-3">
                            <input type="checkbox" class="custom-control-input" id="toggleLabel" checked>
                            <label class="custom-control-label text-white" for="toggleLabel">
                                <i class="fas fa-tags mr-1"></i>Tampilkan Label
                            </label>
                        </div>
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="loadingChart" class="loading-premium">
                        <div class="spinner-premium">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p class="loading-text">Memproses data chart...</p>
                    </div>
                    <canvas id="chartRwRt" style="display:none; max-height: 500px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Per RW Section - Premium Design -->
    <div class="row">
        <div class="col-12">
            <div class="card card-widget-premium elevation-3">
                <div class="card-header-premium bg-gradient-secondary">
                    <div class="card-header-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="card-header-text">
                        <h3 class="card-title-premium">Detail Per RW</h3>
                        <p class="card-subtitle-premium">Rincian Kartu Keluarga dan RT per Rukun Warga</p>
                    </div>
                    <div class="card-tools-premium">
                        <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body-premium">
                    <div id="rwDetails" class="row">
                        <!-- Loading state -->
                        <div class="col-12">
                            <div class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memuat detail RW...</p>
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
        let chartRwRt;

        fetch("{{ route('penduduk.chart.rwrt') }}")
            .then(res => res.json())
            .then(response => {
                // HITUNG STATISTIK
                let totalKKKeseluruhan = 0;
                let totalRW = Object.keys(response.rwData).length;
                let totalRTUnique = response.datasets.length;
                let totalRT = 0;
                let totalLakilaki = response.total_laki_laki;
                let totalPerempuan = response.total_perempuan;
                let totalNIK = response.total_nik;

                const detailsContainer = document.getElementById('rwDetails');
                detailsContainer.innerHTML = '';

                // DEFINISI WARNA PREMIUM
                const colorSchemes = [{
                        gradient: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        text: 'text-primary',
                        badge: 'badge-primary'
                    },
                    {
                        gradient: 'linear-gradient(135deg, #28a745 0%, #20c997 100%)',
                        text: 'text-success',
                        badge: 'badge-success'
                    },
                    {
                        gradient: 'linear-gradient(135deg, #ffc107 0%, #ff9800 100%)',
                        text: 'text-warning',
                        badge: 'badge-warning'
                    },
                    {
                        gradient: 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)',
                        text: 'text-danger',
                        badge: 'badge-danger'
                    },
                    {
                        gradient: 'linear-gradient(135deg, #17a2b8 0%, #138496 100%)',
                        text: 'text-info',
                        badge: 'badge-info'
                    },
                    {
                        gradient: 'linear-gradient(135deg, #343a40 0%, #23272b 100%)',
                        text: 'text-dark',
                        badge: 'badge-dark'
                    }
                ];

                let colorIndex = 0;

                // PROSES TIAP RW
                Object.entries(response.rwData).forEach(([rw, rts]) => {
                    // HITUNG TOTAL KK DI RW INI
                    const totalKK = rts.reduce((sum, rt) => sum + parseInt(rt.total_kk), 0);
                    totalKKKeseluruhan += totalKK;

                    const jumlahRT = rts.length;
                    totalRT += jumlahRT;

                    const colorScheme = colorSchemes[colorIndex % colorSchemes.length];
                    const rataRata = (totalKK / jumlahRT).toFixed(1);

                    // BUAT DETAIL RT DALAM RW INI
                    let rtDetails = '';
                    rts.forEach(rt => {
                        rtDetails += `
                            <div class="rw-rt-item">
                                <span class="rw-rt-label">
                                    <i class="fas fa-home"></i>RT ${rt.rt}
                                </span>
                                <span class="rw-rt-badge ${colorScheme.badge}">${rt.total_kk} KK</span>
                            </div>
                        `;
                    });

                    // BUAT CARD DETAIL PER RW
                    detailsContainer.innerHTML += `
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card rw-card-premium">
                                <div class="rw-card-header" style="background: ${colorScheme.gradient};">
                                    <h5 class="rw-card-title text-white">
                                        <span><i class="fas fa-map-marked-alt"></i></span>
                                        Rukun Warga ${rw}
                                    </h5>
                                </div>
                                <div class="rw-card-body">
                                    <div class="row rw-stats-container">
                                        <div class="col-6 pr-2">
                                            <div class="rw-stat-box">
                                                <div class="rw-stat-label">Total KK</div>
                                                <div class="rw-stat-value ${colorScheme.text}">${totalKK}</div>
                                            </div>
                                        </div>
                                        <div class="col-6 pl-2">
                                            <div class="rw-stat-box">
                                                <div class="rw-stat-label">Jumlah RT</div>
                                                <div class="rw-stat-value ${colorScheme.text}">${jumlahRT}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="rw-divider">

                                    <div class="rw-info-item">
                                        <span class="rw-info-label">
                                            <i class="fas fa-calculator mr-2 ${colorScheme.text}"></i>Rata-rata per RT
                                        </span>
                                        <span class="rw-info-value ${colorScheme.text}">
                                            <strong>${rataRata}</strong> KK
                                        </span>
                                    </div>

                                    <div class="mt-3">
                                        <strong class="d-block mb-3" style="font-size: 13px; color: #2c3e50;">
                                            <i class="fas fa-list-ul mr-2"></i>Detail per RT:
                                        </strong>
                                        <div class="rw-rt-details">
                                            ${rtDetails}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    colorIndex++;
                });

                // UPDATE STATISTIK DI ATAS
                document.getElementById('totalKK').textContent =
                    Number(totalKKKeseluruhan).toLocaleString('id-ID');

                document.getElementById('totalRW').textContent =
                    Number(totalRW).toLocaleString('id-ID');

                document.getElementById('totalRT').textContent =
                    Number(totalRT).toLocaleString('id-ID');

                document.getElementById('totalNIK').textContent =
                    Number(totalNIK).toLocaleString('id-ID');

                document.getElementById('totalLakilaki').textContent =
                    Number(totalLakilaki).toLocaleString('id-ID');

                document.getElementById('totalPerempuan').textContent =
                    Number(totalPerempuan).toLocaleString('id-ID');

                // Tambahkan total KK ke label legend
                response.datasets.forEach(ds => {
                    const totalKK = ds.data.reduce((a, b) => a + b, 0);
                    ds.label = `${ds.label} (${totalKK} KK)`;
                });

                // RENDER CHART
                $('#loadingChart').fadeOut(300, function() {
                    $('#chartRwRt').fadeIn(400);

                    chartRwRt = new Chart(
                        document.getElementById('chartRwRt'), {
                            type: 'bar',
                            data: response,
                            plugins: [ChartDataLabels],
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            font: {
                                                size: 13,
                                                weight: 'bold'
                                            },
                                            padding: 20,
                                            boxWidth: 15,
                                            boxHeight: 15,
                                            usePointStyle: true
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Jumlah Kartu Keluarga per RT di Setiap RW',
                                        font: {
                                            size: 16,
                                            weight: 'bold'
                                        },
                                        padding: {
                                            top: 10,
                                            bottom: 20
                                        }
                                    },
                                    datalabels: {
                                        display: true,
                                        color: '#000',
                                        rotation: -90,
                                        anchor: 'end',
                                        align: 'end',
                                        offset: -4,
                                        font: {
                                            weight: 'bold',
                                            size: 10
                                        },
                                        formatter: (value) => value > 0 ? value : null
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
                                                return context.dataset.label.split(' (')[0] + ': ' +
                                                    context
                                                    .parsed.y + ' KK';
                                            }
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
                                        title: {
                                            display: true,
                                            text: 'Jumlah KK',
                                            font: {
                                                size: 13,
                                                weight: 'bold'
                                            }
                                        },
                                        grid: {
                                            color: 'rgba(0,0,0,0.03)'
                                        }
                                    },
                                    x: {
                                        ticks: {
                                            font: {
                                                size: 12,
                                                weight: 'bold'
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: 'Rukun Warga (RW)',
                                            font: {
                                                size: 13,
                                                weight: 'bold'
                                            }
                                        },
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        }
                    );
                });

                // TOGGLE LABEL
                document.getElementById('toggleLabel').addEventListener('change', function() {
                    chartRwRt.options.plugins.datalabels.display = this.checked;
                    chartRwRt.update();
                });
            })
            .catch(error => {
                console.error('Error loading chart data:', error);

                // Show error in chart area
                $('#loadingChart').html(`
                    <div class="alert-premium alert-danger-premium">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="alert-content">
                            <h5 class="alert-title">Error</h5>
                            <p class="alert-text">Gagal memuat data chart. Silakan refresh halaman.</p>
                        </div>
                    </div>
                `);

                // Show error in RW details
                document.getElementById('rwDetails').innerHTML = `
                    <div class="col-12">
                        <div class="alert-premium alert-danger-premium">
                            <div class="alert-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="alert-content">
                                <h5 class="alert-title">Error</h5>
                                <p class="alert-text">Gagal memuat detail RW. Silakan refresh halaman.</p>
                            </div>
                        </div>
                    </div>
                `;
            });
    </script>
@endpush
