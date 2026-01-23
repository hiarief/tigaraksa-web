@extends('admin.layout.main')
@section('title', 'Dashboard')
@section('content-header', 'Dashboard Statistik Kependudukan')

@section('content')
    <div class="container-fluid">

        <!-- Filter Desa -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <label for="filterDesa" class="form-label"><strong>Filter Desa:</strong></label>
                        <select id="filterDesa" class="form-control">
                            <option value="">Semua Desa</option>
                            @foreach ($desaList as $desa)
                                <option value="{{ $desa->code }}">{{ $desa->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Pilih desa untuk melihat statistik detail. Data akan dimuat secara
                    otomatis.
                </div>
            </div>
        </div>

        <!-- Statistik Kependudukan -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="totalPenduduk"><i class="fas fa-spinner fa-spin"></i></h3>
                        <p>Total Penduduk</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="totalKK"><i class="fas fa-spinner fa-spin"></i></h3>
                        <p>Total Kepala Keluarga</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-home"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="rataKK"><i class="fas fa-spinner fa-spin"></i></h3>
                        <p>Rata-rata Anggota/KK</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="persenBPJS"><i class="fas fa-spinner fa-spin"></i></h3>
                        <p>Kepesertaan BPJS</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 1: Gender & Umur -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-venus-mars"></i> Statistik Jenis Kelamin</h3>
                    </div>
                    <div class="card-body">
                        <div id="loadingGender" class="text-center">
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                            <p>Memuat data...</p>
                        </div>
                        <canvas id="chartGender" style="display:none;"></canvas>
                        <div id="statsGenderText" class="mt-3" style="display:none;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-birthday-cake"></i> Statistik Kelompok Umur</h3>
                    </div>
                    <div class="card-body">
                        <div id="loadingUmur" class="text-center">
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                            <p>Memuat data...</p>
                        </div>
                        <canvas id="chartUmur" style="display:none;"></canvas>
                        <div id="statsUmurText" class="mt-3" style="display:none;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2: BPJS & Perkawinan -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-heartbeat"></i> Statistik Kepesertaan BPJS</h3>
                    </div>
                    <div class="card-body">
                        <div id="loadingBPJS" class="text-center">
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                            <p>Memuat data...</p>
                        </div>
                        <canvas id="chartBPJS" style="display:none;"></canvas>
                        <div id="statsBPJSText" class="mt-3" style="display:none;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-ring"></i> Statistik Status Perkawinan</h3>
                    </div>
                    <div class="card-body">
                        <div id="loadingPerkawinan" class="text-center">
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                            <p>Memuat data...</p>
                        </div>
                        <canvas id="chartPerkawinan" style="display:none;"></canvas>
                        <div id="statsPerkawinanText" class="mt-3" style="display:none;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: Pendapatan & Kepemilikan Rumah -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-money-bill-wave"></i> Statistik Pendapatan</h3>
                    </div>
                    <div class="card-body">
                        <div id="loadingPendapatan" class="text-center">
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                            <p>Memuat data...</p>
                        </div>
                        <canvas id="chartPendapatan" style="display:none;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-home"></i> Statistik Kepemilikan Rumah</h3>
                    </div>
                    <div class="card-body">
                        <div id="loadingRumah" class="text-center">
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                            <p>Memuat data...</p>
                        </div>
                        <canvas id="chartRumah" style="display:none;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 4: Distribusi RT/RW & Golongan Darah -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marker-alt"></i> Distribusi RT/RW</h3>
                    </div>
                    <div class="card-body">
                        <div id="loadingRTRW" class="text-center">
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                            <p>Memuat data...</p>
                        </div>
                        <div id="tableRTRW" style="display:none; max-height: 400px; overflow-y: auto;">
                            <table class="table-striped table-sm table">
                                <thead>
                                    <tr>
                                        <th>RT/RW</th>
                                        <th class="text-right">Jumlah Penduduk</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyRTRW"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-tint"></i> Statistik Golongan Darah</h3>
                    </div>
                    <div class="card-body">
                        <div id="loadingGolDarah" class="text-center">
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                            <p>Memuat data...</p>
                        </div>
                        <canvas id="chartGolDarah" style="display:none;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Summary Per Desa -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-table"></i> Ringkasan Statistik Per Desa</h3>
                    </div>
                    <div class="card-body">
                        <div id="loadingPerDesa" class="text-center">
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                            <p>Memuat data...</p>
                        </div>
                        <div id="tablePerDesa" style="display:none; overflow-x: auto;">
                            <table class="table-bordered table-hover table" id="tblPerDesa">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Desa</th>
                                        <th class="text-right">Penduduk</th>
                                        <th class="text-right">KK</th>
                                        <th class="text-right">Laki-laki</th>
                                        <th class="text-right">Perempuan</th>
                                        <th class="text-right">Punya BPJS</th>
                                        <th class="text-right">% BPJS</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyPerDesa"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let charts = {};

            // Load semua data saat pertama kali
            loadAllStats();

            // Reload saat filter desa berubah
            $('#filterDesa').change(function() {
                loadAllStats();
            });

            function loadAllStats() {
                const desa = $('#filterDesa').val();

                loadKependudukan(desa);
                loadGender(desa);
                loadUmur(desa);
                loadBPJS(desa);
                loadPerkawinan(desa);
                loadPendapatan(desa);
                loadKepemilikanRumah(desa);
                loadGolDarah(desa);
                loadPerDesa();
            }

            // 1. Load Statistik Kependudukan
            function loadKependudukan(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.kependudukan') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        $('#totalPenduduk').html(data.total_penduduk.toLocaleString('id-ID'));
                        $('#totalKK').html(data.total_kk.toLocaleString('id-ID'));
                        $('#rataKK').html(data.rata_anggota_kk);

                        // Distribusi RT/RW
                        $('#loadingRTRW').hide();
                        $('#tableRTRW').show();
                        let html = '';
                        data.distribusi_rt_rw.forEach(function(item) {
                            html += `<tr>
                        <td>RT/RW ${item.rt_rw}</td>
                        <td class="text-right">${item.jumlah.toLocaleString('id-ID')}</td>
                    </tr>`;
                        });
                        $('#tbodyRTRW').html(html);
                    }
                });
            }

            // 2. Load Statistik Gender
            function loadGender(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.gender') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        $('#loadingGender').hide();
                        $('#chartGender').show();
                        $('#statsGenderText').show();

                        // Destroy existing chart
                        if (charts.gender) charts.gender.destroy();

                        // Create pie chart
                        const ctx = document.getElementById('chartGender').getContext('2d');
                        charts.gender = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: ['#3b82f6', '#ec4899']
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }
                        });

                        $('#statsGenderText').html(`
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary">${data.laki_laki.toLocaleString('id-ID')}</h4>
                            <p>Laki-laki</p>
                        </div>
                        <div class="col-6">
                            <h4 class="text-danger">${data.perempuan.toLocaleString('id-ID')}</h4>
                            <p>Perempuan</p>
                        </div>
                    </div>
                    <p class="text-center text-muted mt-2">Rasio: ${data.rasio} laki-laki per 100 perempuan</p>
                `);
                    }
                });
            }

            // 3. Load Statistik Umur
            function loadUmur(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.umur') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        $('#loadingUmur').hide();
                        $('#chartUmur').show();
                        $('#statsUmurText').show();

                        if (charts.umur) charts.umur.destroy();

                        const ctx = document.getElementById('chartUmur').getContext('2d');
                        charts.umur = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    label: 'Jumlah Penduduk',
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: '#3b82f6'
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
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

                        $('#statsUmurText').html(`
                    <div class="row text-center">
                        <div class="col-4">
                            <h5 class="text-success">${data.produktif.toLocaleString('id-ID')}</h5>
                            <small>Usia Produktif</small>
                        </div>
                        <div class="col-4">
                            <h5 class="text-warning">${data.non_produktif.toLocaleString('id-ID')}</h5>
                            <small>Non Produktif</small>
                        </div>
                        <div class="col-4">
                            <h5 class="text-info">${data.lansia.toLocaleString('id-ID')}</h5>
                            <small>Lansia (60+)</small>
                        </div>
                    </div>
                `);
                    }
                });
            }

            // 4. Load Statistik BPJS
            function loadBPJS(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.bpjs') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        $('#loadingBPJS').hide();
                        $('#chartBPJS').show();
                        $('#statsBPJSText').show();
                        $('#persenBPJS').html(data.persentase + '%');

                        if (charts.bpjs) charts.bpjs.destroy();

                        const ctx = document.getElementById('chartBPJS').getContext('2d');
                        charts.bpjs = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: ['#10b981', '#ef4444']
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }
                        });

                        let jenisBPJSHtml = '<h6>Jenis BPJS:</h6><ul>';
                        data.jenis_bpjs.forEach(function(item) {
                            jenisBPJSHtml +=
                                `<li>${item.jenis_bpjs || 'Tidak Diketahui'}: <strong>${item.jumlah.toLocaleString('id-ID')}</strong></li>`;
                        });
                        jenisBPJSHtml += '</ul>';

                        $('#statsBPJSText').html(jenisBPJSHtml);
                    }
                });
            }

            // 5. Load Statistik Perkawinan
            function loadPerkawinan(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.perkawinan') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        $('#loadingPerkawinan').hide();
                        $('#chartPerkawinan').show();
                        $('#statsPerkawinanText').show();

                        if (charts.perkawinan) charts.perkawinan.destroy();

                        const ctx = document.getElementById('chartPerkawinan').getContext('2d');
                        charts.perkawinan = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: ['#f59e0b', '#8b5cf6']
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }
                        });

                        $('#statsPerkawinanText').html(`
                    <p class="text-center">
                        <strong>Perkawinan Tercatat:</strong> ${data.kawin_tercatat.toLocaleString('id-ID')} orang
                    </p>
                `);
                    }
                });
            }

            // 6. Load Statistik Pendapatan
            function loadPendapatan(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.pendapatan') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        $('#loadingPendapatan').hide();
                        $('#chartPendapatan').show();

                        if (charts.pendapatan) charts.pendapatan.destroy();

                        const ctx = document.getElementById('chartPendapatan').getContext('2d');
                        charts.pendapatan = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    label: 'Jumlah Penduduk',
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: '#10b981'
                                }]
                            },
                            options: {
                                responsive: true,
                                indexAxis: 'y',
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                });
            }

            // 7. Load Statistik Kepemilikan Rumah
            function loadKepemilikanRumah(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.kepemilikan.rumah') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        $('#loadingRumah').hide();
                        $('#chartRumah').show();

                        if (charts.rumah) charts.rumah.destroy();

                        const ctx = document.getElementById('chartRumah').getContext('2d');
                        charts.rumah = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b',
                                        '#ef4444'
                                    ]
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }
                        });
                    }
                });
            }

            // 8. Load Statistik Golongan Darah
            function loadGolDarah(desa = '') {
                $.ajax({
                    url: '{{ route('dashboard.gol.darah') }}',
                    data: {
                        desa: desa
                    },
                    success: function(data) {
                        $('#loadingGolDarah').hide();
                        $('#chartGolDarah').show();

                        if (charts.goldarah) charts.goldarah.destroy();

                        const ctx = document.getElementById('chartGolDarah').getContext('2d');
                        charts.goldarah = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.chart_data.map(d => d.label),
                                datasets: [{
                                    label: 'Jumlah',
                                    data: data.chart_data.map(d => d.value),
                                    backgroundColor: '#ef4444'
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
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
                });
            }

            // 9. Load Statistik Per Desa
            function loadPerDesa() {
                $.ajax({
                    url: '{{ route('dashboard.per.desa') }}',
                    success: function(data) {
                        $('#loadingPerDesa').hide();
                        $('#tablePerDesa').show();

                        let html = '';
                        data.forEach(function(item) {
                            const persenBPJS = item.total_penduduk > 0 ?
                                ((item.punya_bpjs / item.total_penduduk) * 100).toFixed(2) :
                                0;

                            html += `<tr>
                        <td><strong>${item.desa || 'Tidak Diketahui'}</strong></td>
                        <td class="text-right">${item.total_penduduk.toLocaleString('id-ID')}</td>
                        <td class="text-right">${item.total_kk.toLocaleString('id-ID')}</td>
                        <td class="text-right">${item.laki_laki.toLocaleString('id-ID')}</td>
                        <td class="text-right">${item.perempuan.toLocaleString('id-ID')}</td>
                        <td class="text-right">${item.punya_bpjs.toLocaleString('id-ID')}</td>
                        <td class="text-right">${persenBPJS}%</td>
                    </tr>`;
                        });
                        $('#tbodyPerDesa').html(html);
                    }
                });
            }
        });
    </script>
@endpush
