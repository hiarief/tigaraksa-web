@extends('admin.layout.main')
@section('title', 'Kependudukan')
@section('content-header', 'Kependudukan')

@section('content')
    {{-- STATISTIK RINGKASAN --}}
    <div class="row mb-4">
        <!-- Total Kartu Keluarga -->
        <div class="col-md-4">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Total Keseluruhan</h6>
                            <h2 class="font-weight-bold mb-0" id="totalKK">0</h2>
                            <small>Kartu Keluarga</small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total RW -->
        <div class="col-md-4">
            <div class="card bg-gradient-secondary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Total RW</h6>
                            <h2 class="font-weight-bold mb-0" id="totalRW">0</h2>
                            <small>Rukun Warga</small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-layer-group fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total RT -->
        <div class="col-md-4">
            <div class="card bg-gradient-dark text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Total RT</h6>
                            <h2 class="font-weight-bold mb-0" id="totalRT">0</h2>
                            <small>Rukun Tetangga</small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-map-signs fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Total NIK -->
        <div class="col-md-4">
            <div class="card bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Total Keseluruhan</h6>
                            <h2 class="font-weight-bold mb-0" id="totalNIK">0</h2>
                            <small>Nomor Induk Kependudukan</small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-id-card fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Laki-laki -->
        <div class="col-md-4">
            <div class="card bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Total Laki-laki</h6>
                            <h2 class="font-weight-bold mb-0" id="totalLakilaki">0</h2>
                            <small>Laki-laki</small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-male fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Perempuan -->
        <div class="col-md-4">
            <div class="card bg-gradient-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Total Perempuan</h6>
                            <h2 class="font-weight-bold mb-0" id="totalPerempuan">0</h2>
                            <small>Perempuan</small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-female fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- CHART --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title text-white">
                        <i class="fas fa-chart-bar mr-2"></i>Distribusi KK per RT di Setiap RW
                    </h3>
                    <div class="card-tools">
                        <div class="custom-control custom-switch custom-switch-on-primary">
                            <input type="checkbox" class="custom-control-input" id="toggleLabel" checked>
                            <label class="custom-control-label text-white" for="toggleLabel">Tampilkan Label</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="chartRwRt" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- DETAIL PER RW --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-secondary">
                    <h3 class="card-title text-white">
                        <i class="fas fa-list mr-2"></i>Detail Per RW
                    </h3>
                </div>
                <div class="card-body">
                    <div id="rwDetails" class="row"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let chartRwRt;

        fetch("{{ route('penduduk.chart.rwrt') }}")
            .then(res => res.json())
            .then(response => {
                // console.log('Data dari backend:', response);

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

                // DEFINISI WARNA
                const colorClass = ['primary', 'success', 'warning', 'danger', 'info', 'dark'];

                let colorIndex = 0;

                // PROSES TIAP RW
                Object.entries(response.rwData).forEach(([rw, rts]) => {
                    // HITUNG TOTAL KK DI RW INI
                    const totalKK = rts.reduce((sum, rt) => sum + parseInt(rt.total_kk), 0);
                    totalKKKeseluruhan += totalKK;

                    const jumlahRT = rts.length;
                    totalRT += jumlahRT;

                    const cardColor = colorClass[colorIndex % colorClass.length];

                    // BUAT DETAIL RT DALAM RW INI
                    let rtDetails = '';
                    rts.forEach(rt => {
                        rtDetails += `
                            <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                                <span class="small"><i class="fas fa-home mr-1"></i>RT ${rt.rt}</span>
                                <span class="badge badge-${cardColor}">${rt.total_kk} KK</span>
                            </div>
                        `;
                    });

                    // BUAT CARD DETAIL PER RW
                    detailsContainer.innerHTML += `
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card card-outline card-${cardColor}">
                                <div class="card-header">
                                    <h5 class="card-title font-weight-bold">
                                        <i class="fas fa-map-marked-alt mr-2"></i>RW ${rw}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-6 text-center border-right">
                                            <div class="text-muted small">Total KK</div>
                                            <h3 class="font-weight-bold text-${cardColor}">${totalKK}</h3>
                                        </div>
                                        <div class="col-6 text-center">
                                            <div class="text-muted small">Jumlah RT</div>
                                            <h3 class="font-weight-bold text-${cardColor}">${jumlahRT}</h3>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="small mb-2">
                                        <strong>Rata-rata per RT:</strong>
                                        <span class="float-right">${(totalKK / jumlahRT).toFixed(1)} KK</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="small">
                                        <strong class="d-block mb-2">Detail per RT:</strong>
                                        <div style="max-height: 200px; overflow-y: auto;">
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
                                            size: 12,
                                            weight: 'bold'
                                        },
                                        padding: 12,
                                        boxWidth: 15,
                                        boxHeight: 15
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
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label.split(' (')[0] + ': ' + context.parsed
                                                .y + ' KK';
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
                                            size: 11
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Jumlah KK',
                                        font: {
                                            size: 12,
                                            weight: 'bold'
                                        }
                                    }
                                },
                                x: {
                                    ticks: {
                                        font: {
                                            size: 11
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Rukun Warga (RW)',
                                        font: {
                                            size: 12,
                                            weight: 'bold'
                                        }
                                    }
                                }
                            }
                        }
                    }
                );

                // TOGGLE LABEL
                document.getElementById('toggleLabel').addEventListener('change', function() {
                    chartRwRt.options.plugins.datalabels.display = this.checked;
                    chartRwRt.update();
                });
            })
            .catch(error => {
                console.error('Error loading chart data:', error);
                alert('Gagal memuat data chart. Silakan refresh halaman.');
            });
    </script>
@endpush
