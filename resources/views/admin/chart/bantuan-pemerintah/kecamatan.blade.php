@extends('admin.layout.main')
@section('title', 'Statistik Bantuan Pemerintah')
@section('content-header', 'Statistik Bantuan Pemerintah Kecamatan')

@push('styles')
    <style>
        .table {
            font-size: 0.9rem;
        }

        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge-lg {
            font-size: 0.9rem;
            padding: 0.4rem 0.6rem;
        }

        .badge-stat {
            font-size: 0.85rem;
            padding: 0.35rem 0.6rem;
            font-weight: 600;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #495057;
            border-bottom: 3px solid #28a745;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .badge-purple {
            background-color: #6f42c1;
            color: white;
        }

        .border-warning {
            border-left: 4px solid #ffc107 !important;
        }

        .border-danger {
            border-left: 4px solid #dc3545 !important;
        }

        /* ── Gradients tambahan ── */
        .bg-gradient-purple {
            background: linear-gradient(135deg, #6f42c1 0%, #563d7c 100%) !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">

            {{-- ══════════════════════════════════════
         HEADER CARD
    ══════════════════════════════════════ --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-2">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <div class="ml-3">
                                    <h5 class="font-weight-bold mb-1">Ringkasan Statistik Bantuan Pemerintah</h5>
                                    <p class="stat-sublabel-premium mb-0">
                                        Data kelayakan & distribusi bantuan pemerintah di seluruh desa
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════
         STATISTIK JUMLAH
    ══════════════════════════════════════ --}}
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h4 class="section-title">
                        <i class="fas fa-calculator mr-2"></i> Statistik Jumlah
                    </h4>
                </div>

                @php
                    $statCards = [
                        [
                            'id' => 'totalPenduduk',
                            'icon' => 'users',
                            'color' => 'icon-primary',
                            'label' => 'Total Penduduk',
                            'sub' => 'Seluruh Penduduk',
                        ],
                        [
                            'id' => 'totalLaki',
                            'icon' => 'male',
                            'color' => 'icon-info',
                            'label' => 'Laki-laki',
                            'sub' => 'Jumlah Laki-laki',
                        ],
                        [
                            'id' => 'totalPerempuan',
                            'icon' => 'female',
                            'color' => 'icon-danger',
                            'label' => 'Perempuan',
                            'sub' => 'Jumlah Perempuan',
                        ],
                        [
                            'id' => 'layak',
                            'icon' => 'check-circle',
                            'color' => 'icon-success',
                            'label' => 'Layak Bantuan',
                            'sub' => 'Dinyatakan Layak',
                        ],
                        [
                            'id' => 'tidakLayak',
                            'icon' => 'times-circle',
                            'color' => 'icon-danger',
                            'label' => 'Tidak Layak',
                            'sub' => 'Dinyatakan Tidak Layak',
                        ],
                        [
                            'id' => 'belumDapat',
                            'icon' => 'clock',
                            'color' => 'icon-secondary',
                            'label' => 'Belum Pernah Dapat',
                            'sub' => 'Belum Ada Bantuan',
                        ],
                        [
                            'id' => 'bpnt',
                            'icon' => 'shopping-basket',
                            'color' => 'icon-primary',
                            'label' => 'BPNT',
                            'sub' => 'Bantuan Pangan Non Tunai',
                        ],
                        [
                            'id' => 'blt',
                            'icon' => 'money-bill-wave',
                            'color' => 'icon-warning',
                            'label' => 'BLT',
                            'sub' => 'Bantuan Langsung Tunai',
                        ],
                        [
                            'id' => 'pkh',
                            'icon' => 'home',
                            'color' => 'icon-info',
                            'label' => 'PKH',
                            'sub' => 'Program Keluarga Harapan',
                        ],
                        [
                            'id' => 'bsu',
                            'icon' => 'hard-hat',
                            'color' => 'icon-success',
                            'label' => 'BSU Ketenagakerjaan',
                            'sub' => 'Bantuan Subsidi Upah',
                        ],
                        [
                            'id' => 'lainnya',
                            'icon' => 'gift',
                            'color' => 'icon-danger',
                            'label' => 'Bantuan Lainnya',
                            'sub' => 'Program Lainnya',
                        ],
                    ];
                @endphp

                @foreach ($statCards as $card)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card-premium elevation-3">
                            <div class="stat-card-body">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon-premium {{ $card['color'] }} text-white">
                                        <i class="fas fa-{{ $card['icon'] }}"></i>
                                    </div>
                                    <div class="flex-grow-1 ml-3">
                                        <p class="stat-number-premium" id="{{ $card['id'] }}">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </p>
                                        <p class="stat-label-premium mb-0">
                                            {{ $card['label'] }}
                                            <i class="fas fa-{{ $card['icon'] }} stat-mini-icon"></i>
                                        </p>
                                        <p class="stat-sublabel-premium mb-0">{{ $card['sub'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ══════════════════════════════════════
         STATISTIK RASIO
    ══════════════════════════════════════ --}}
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h4 class="section-title">
                        <i class="fas fa-chart-pie mr-2"></i> Statistik Rasio
                    </h4>
                </div>

                <!-- % Layak -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="pctLayak"><span
                                                class="skeleton-premium skeleton-number-premium"></span></span>
                                        <span class="d-none" id="pctLayakSfx">%</span>
                                    </p>
                                    <p class="stat-label-premium mb-0">% Layak Bantuan <i
                                            class="fas fa-percentage stat-mini-icon"></i></p>
                                    <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- % Tidak Layak -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="pctTidakLayak"><span
                                                class="skeleton-premium skeleton-number-premium"></span></span>
                                        <span class="d-none" id="pctTidakLayakSfx">%</span>
                                    </p>
                                    <p class="stat-label-premium mb-0">% Tidak Layak <i
                                            class="fas fa-chart-line stat-mini-icon"></i></p>
                                    <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rasio -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-balance-scale"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="rasioKelayakan"><span
                                                class="skeleton-premium skeleton-number-premium"></span></span>
                                        <span class="d-none" id="rasioKelayakanSfx">:1</span>
                                    </p>
                                    <p class="stat-label-premium mb-0">Rasio Kelayakan <i
                                            class="fas fa-balance-scale stat-mini-icon"></i></p>
                                    <p class="stat-sublabel-premium mb-0">Layak : Tidak Layak</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════
         STATISTIK DISTRIBUSI – CHARTS
    ══════════════════════════════════════ --}}
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h4 class="section-title">
                        <i class="fas fa-chart-bar mr-2"></i> Statistik Distribusi
                    </h4>
                </div>

                {{-- Distribusi Jenis Bantuan --}}
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon"><i class="fas fa-hand-holding-usd"></i></div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Jenis Bantuan</h3>
                                <p class="card-subtitle-premium">Jenis bantuan yang diterima penduduk</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartJenisBantuan" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartJenisBantuan" style="display:none; max-height:400px;"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Distribusi Jenis Kelamin --}}
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-info">
                            <div class="card-header-icon"><i class="fas fa-venus-mars"></i></div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Jenis Kelamin</h3>
                                <p class="card-subtitle-premium">Penerima bantuan berdasarkan gender</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartJenkel" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartJenkel" style="display:none; max-height:350px;"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Layak Per Desa --}}
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-warning">
                            <div class="card-header-icon"><i class="fas fa-map-marked-alt"></i></div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Penerima Layak Per Desa</h3>
                                <p class="card-subtitle-premium">Jumlah penduduk layak bantuan tiap desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartDesa" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartDesa" style="display:none; max-height:350px;"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Distribusi Kelompok Umur --}}
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-purple">
                            <div class="card-header-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Kelompok Umur</h3>
                                <p class="card-subtitle-premium">Penduduk berdasarkan kelompok umur</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartUmur" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartUmur" style="display:none; max-height:350px;"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Umur & Gender --}}
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon"><i class="fas fa-chart-bar"></i></div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Bantuan per Umur & Gender</h3>
                                <p class="card-subtitle-premium">Distribusi berdasarkan umur dan jenis kelamin</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartUmurJenkel" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartUmurJenkel" style="display:none; max-height:350px;"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Kelayakan Per Desa (Layak vs Tidak) --}}
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon"><i class="fas fa-balance-scale"></i></div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Kelayakan Per Desa</h3>
                                <p class="card-subtitle-premium">Layak vs Tidak Layak tiap desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartKelayakanDesa" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartKelayakanDesa" style="display:none; max-height:350px;"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Jenis Bantuan Per Desa (Full width – Stacked) --}}
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon"><i class="fas fa-layer-group"></i></div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Jenis Bantuan Per Desa</h3>
                                <p class="card-subtitle-premium">Perbandingan jenis bantuan di setiap desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartBantuanDesa" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartBantuanDesa" style="display:none; max-height:450px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════
         TABEL DETAIL PER DESA
    ══════════════════════════════════════ --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon"><i class="fas fa-table"></i></div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Detail Bantuan Per Desa</h3>
                                <p class="card-subtitle-premium">Rincian lengkap setiap desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body-premium p-0">
                            <div class="table-container-premium">
                                <div class="table-responsive">
                                    <table class="table-premium table-hover">
                                        <thead class="nowrap">
                                            <tr>
                                                <th width="3%">#</th>
                                                <th width="15%">Desa</th>
                                                <th width="7%" class="text-center">Total</th>
                                                <th width="7%" class="text-center">L</th>
                                                <th width="7%" class="text-center">P</th>
                                                <th width="8%" class="text-center">Layak</th>
                                                <th width="8%" class="text-center">Tidak Layak</th>
                                                <th width="9%" class="text-center">BPNT</th>
                                                <th width="7%" class="text-center">BLT</th>
                                                <th width="7%" class="text-center">PKH</th>
                                                <th width="7%" class="text-center">BSU</th>
                                                <th width="9%" class="text-center">Blm Dapat</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableDetailDesa">
                                            <tr>
                                                <td colspan="12" class="py-4 text-center">
                                                    <div class="spinner-premium">
                                                        <div class="double-bounce1"></div>
                                                        <div class="double-bounce2"></div>
                                                    </div>
                                                    <p class="loading-text mt-2">Memproses data...</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════
         ANALISIS DATA ABNORMAL
    ══════════════════════════════════════ --}}
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <div class="alert alert-warning border-left-warning">
                        <h5 class="alert-heading">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Analisis Data Abnormal &amp; Validasi Data
                        </h5>
                        <p class="mb-0">
                            <strong>Catatan Penting:</strong> Data berikut menampilkan
                            <strong>inkonsistensi</strong> pengisian data bantuan pemerintah yang perlu
                            <strong>diverifikasi dan diperbaiki</strong>.
                        </p>
                    </div>
                </div>

                {{-- Chart Data Abnormal --}}
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon"><i class="fas fa-exclamation-circle"></i></div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Kategori Data Abnormal</h3>
                                <p class="card-subtitle-premium">Inkonsistensi pengisian data</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartAbnormal" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartAbnormal" style="display:none; max-height:350px;"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Info boxes abnormal --}}
                <div class="col-lg-6 mb-4">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="stat-card-premium elevation-3 border-warning">
                                <div class="stat-card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon-premium icon-warning text-white"><i
                                                class="fas fa-exclamation-circle"></i></div>
                                        <div class="flex-grow-1 ml-3">
                                            <p class="stat-number-premium text-warning" id="abnormalLayakTanpaBantuan">0
                                            </p>
                                            <p class="stat-label-premium mb-0">Layak Tanpa Data Bantuan</p>
                                            <p class="stat-sublabel-premium text-warning mb-0">Status layak, kolom bantuan
                                                kosong</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="stat-card-premium elevation-3 border-warning">
                                <div class="stat-card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon-premium icon-warning text-white"><i
                                                class="fas fa-clock"></i></div>
                                        <div class="flex-grow-1 ml-3">
                                            <p class="stat-number-premium text-warning" id="abnormalLayakBelumDapat">0</p>
                                            <p class="stat-label-premium mb-0">Layak tapi Belum Pernah Dapat</p>
                                            <p class="stat-sublabel-premium text-warning mb-0">Diisi "Belum Pernah Dapat
                                                Bantuan"</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="stat-card-premium elevation-3 border-danger">
                                <div class="stat-card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon-premium icon-danger text-white"><i
                                                class="fas fa-times-circle"></i></div>
                                        <div class="flex-grow-1 ml-3">
                                            <p class="stat-number-premium text-danger" id="abnormalTidakLayakAdaBantuan">0
                                            </p>
                                            <p class="stat-label-premium mb-0">Tidak Layak tapi Ada Bantuan</p>
                                            <p class="stat-sublabel-premium text-danger mb-0">Data bertentangan (tidak
                                                layak tapi punya bantuan)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DataTable Abnormal --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon"><i class="fas fa-list-alt"></i></div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Data Lengkap Abnormal untuk Verifikasi</h3>
                                <p class="card-subtitle-premium">Daftar data yang perlu diperbaiki</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div class="alert alert-danger mb-3">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Tindak Lanjut yang Diperlukan:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Verifikasi data lapangan untuk penduduk yang dinyatakan <strong>Layak</strong> namun
                                        belum/tidak ada bantuan</li>
                                    <li>Verifikasi data penduduk <strong>Tidak Layak</strong> yang tercatat memiliki bantuan
                                    </li>
                                    <li>Lengkapi data jenis bantuan yang masih kosong</li>
                                    <li>Update database dengan data yang benar</li>
                                </ul>
                            </div>

                            {{-- Filter --}}
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-filter mr-1"></i> Kategori Abnormal</label>
                                        <select class="form-control select2" id="filterKategoriAbnormal"
                                            style="width:100%;">
                                            <option value="">-- Semua Kategori --</option>
                                            <option value="Layak Tanpa Data Bantuan">Layak Tanpa Data Bantuan</option>
                                            <option value="Layak tapi Belum Pernah Dapat">Layak tapi Belum Pernah Dapat
                                            </option>
                                            <option value="Tidak Layak tapi Ada Bantuan">Tidak Layak tapi Ada Bantuan
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-map-marker-alt mr-1"></i> Desa</label>
                                        <select class="form-control select2" id="filterDesaAbnormal" style="width:100%;">
                                            <option value="">-- Semua Desa --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-danger flex-grow-1 mr-2"
                                                id="btnFilterAbnormal">
                                                <i class="fas fa-search mr-1"></i> Filter
                                            </button>
                                            <button type="button" class="btn btn-secondary flex-grow-1"
                                                id="btnResetFilterAbnormal">
                                                <i class="fas fa-redo mr-1"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table-bordered table-hover table" id="tableAbnormal" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="4%">No</th>
                                            <th width="10%">Desa</th>
                                            <th width="12%">NIK</th>
                                            <th width="15%">Nama</th>
                                            <th width="8%" class="text-center">JK</th>
                                            <th width="6%" class="text-center">Umur</th>
                                            <th width="10%" class="text-center">Tgl Lahir</th>
                                            <th width="8%" class="text-center">RT/RW</th>
                                            <th width="12%" class="text-center">Kategori Abnormal</th>
                                            <th width="15%">Detail Masalah</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════
         DATATABLE LENGKAP PENDUDUK
    ══════════════════════════════════════ --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon"><i class="fas fa-users"></i></div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Data Lengkap Penduduk &amp; Bantuan Pemerintah</h3>
                                <p class="card-subtitle-premium">Daftar seluruh penduduk beserta informasi bantuan</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            {{-- Filter --}}
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fas fa-map-marker-alt mr-1"></i> Filter Desa</label>
                                        <select class="form-control select2" id="filterDesa" style="width:100%;">
                                            <option value="">-- Semua Desa --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fas fa-check-circle mr-1"></i> Status Kelayakan</label>
                                        <select class="form-control select2" id="filterStatusBantuan"
                                            style="width:100%;">
                                            <option value="">-- Semua Status --</option>
                                            <option value="Layak">Layak</option>
                                            <option value="Tidak Layak">Tidak Layak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fas fa-venus-mars mr-1"></i> Jenis Kelamin</label>
                                        <select class="form-control select2" id="filterJenkel" style="width:100%;">
                                            <option value="">-- Semua --</option>
                                            <option value="1">Laki-laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fas fa-gift mr-1"></i> Jenis Bantuan</label>
                                        <select class="form-control select2" id="filterJenisBantuan" style="width:100%;">
                                            <option value="">-- Semua Bantuan --</option>
                                            <option value="Belum Pernah Dapat Bantuan">Belum Pernah Dapat Bantuan</option>
                                            <option value="Bantuan Pangan Non Tunai (BPNT)">BPNT</option>
                                            <option value="Bantuan Langsung Tunai (BLT)">BLT</option>
                                            <option value="Program Keluarga Harapan (PKH)">PKH</option>
                                            <option value="BSU Ketenagakerjaan">BSU Ketenagakerjaan</option>
                                            <option value="Bantuan Pemerintah Lainnya">Bantuan Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success mr-2" id="btnFilter">
                                        <i class="fas fa-search mr-1"></i> Filter
                                    </button>
                                    <button type="button" class="btn btn-secondary" id="btnResetFilter">
                                        <i class="fas fa-redo mr-1"></i> Reset
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table-bordered table-hover table" id="tablePendudukBantuan"
                                    style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="4%">No</th>
                                            <th width="10%">Desa</th>
                                            <th width="12%">NIK</th>
                                            <th width="15%">Nama</th>
                                            <th width="8%" class="text-center">Jenis Kelamin</th>
                                            <th width="6%" class="text-center">Umur</th>
                                            <th width="10%" class="text-center">Tgl Lahir</th>
                                            <th width="8%" class="text-center">RT/RW</th>
                                            <th width="10%" class="text-center">Status</th>
                                            <th width="17%">Jenis Bantuan</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /col-sm-12 --}}
    </div>{{-- /row --}}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            /* ──────────────────────────────────────────
               Config & Helpers
            ────────────────────────────────────────── */
            let charts = {};
            const COLORS = {
                mixed: ['#28a745', '#007bff', '#6f42c1', '#ffc107', '#17a2b8', '#fd7e14', '#20c997', '#e83e8c',
                    '#6c757d', '#343a40', '#dc3545'
                ],
                danger: ['#dc3545', '#c82333', '#bd2130', '#a71d2a', '#8b0000'],
                warning: ['#ffc107', '#ff9800', '#ff5722', '#e91e63', '#f44336'],
            };

            function fmt(n) {
                return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function hideLoading(canvasId) {
                const cap = canvasId.charAt(0).toUpperCase() + canvasId.slice(1);
                $('#loading' + cap).fadeOut(300, function() {
                    $('#' + canvasId).fadeIn(400);
                });
            }

            function animateNum(selector, target) {
                const el = $(selector);
                const dur = 1000;
                const inc = target / (dur / 16);
                let cur = 0;
                const t = setInterval(() => {
                    cur += inc;
                    if (cur >= target) {
                        cur = target;
                        clearInterval(t);
                    }
                    el.text(fmt(Math.floor(cur)));
                }, 16);
            }

            /* ──────────────────────────────────────────
               Chart Factories
            ────────────────────────────────────────── */
            function renderBar(id, data, palette) {
                const ctx = document.getElementById(id);
                if (charts[id]) charts[id].destroy();
                const labels = Object.keys(data);
                const values = Object.values(data);
                const bg = labels.map((_, i) => palette[i % palette.length]);
                charts[id] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Jumlah',
                            data: values,
                            backgroundColor: bg,
                            borderColor: bg,
                            borderWidth: 1,
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: ctx => 'Jumlah: ' + fmt(ctx.parsed.y) + ' orang'
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
                                    callback: v => fmt(v)
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45,
                                    font: {
                                        size: 11,
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
                hideLoading(id);
            }

            function renderDoughnut(id, data, palette) {
                const ctx = document.getElementById(id);
                if (charts[id]) charts[id].destroy();
                charts[id] = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            data: Object.values(data),
                            backgroundColor: palette,
                            borderWidth: 4,
                            borderColor: '#fff',
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 18,
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
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: ctx => {
                                        const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                        return ctx.label + ': ' + fmt(ctx.parsed) + ' (' + ((ctx
                                            .parsed / total) * 100).toFixed(1) + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
                hideLoading(id);
            }

            function renderPie(id, data, palette) {
                const ctx = document.getElementById(id);
                if (charts[id]) charts[id].destroy();
                charts[id] = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            data: Object.values(data),
                            backgroundColor: palette,
                            borderWidth: 4,
                            borderColor: '#fff',
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 18,
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
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: ctx => {
                                        const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                        return ctx.label + ': ' + fmt(ctx.parsed) + ' (' + ((ctx
                                            .parsed / total) * 100).toFixed(1) + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
                hideLoading(id);
            }

            function renderGroupedBar(id, data) {
                const ctx = document.getElementById(id);
                if (charts[id]) charts[id].destroy();
                const labels = Object.values(data).map(d => d.label);
                const dataLaki = Object.values(data).map(d => d.laki);
                const dataPerem = Object.values(data).map(d => d.perempuan);
                charts[id] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                                label: 'Laki-laki',
                                data: dataLaki,
                                backgroundColor: '#007bff',
                                borderColor: '#007bff',
                                borderWidth: 1
                            },
                            {
                                label: 'Perempuan',
                                data: dataPerem,
                                backgroundColor: '#e83e8c',
                                borderColor: '#e83e8c',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ctx.dataset.label + ': ' + fmt(ctx.parsed.y) + ' orang'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                stacked: false,
                                ticks: {
                                    callback: v => fmt(v)
                                }
                            },
                            x: {
                                stacked: false,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45,
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
                hideLoading(id);
            }

            function renderStacked(id, data) {
                const ctx = document.getElementById(id);
                if (charts[id]) charts[id].destroy();
                charts[id] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 14,
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ctx.dataset.label + ': ' + fmt(ctx.parsed.y) + ' orang'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                stacked: true,
                                ticks: {
                                    callback: v => fmt(v)
                                }
                            },
                            x: {
                                stacked: true,
                                grid: {
                                    display: false
                                },
                                ticks: {
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
                hideLoading(id);
            }

            /* ──────────────────────────────────────────
               Tabel Detail Per Desa
            ────────────────────────────────────────── */
            function renderTableDetail(rows) {
                const colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary', 'dark'];
                let html = '';
                rows.forEach((r, i) => {
                    const c = colors[i % colors.length];
                    html += `
            <tr>
              <td class="font-weight-bold">${i+1}</td>
              <td><i class="fas fa-map-marker-alt text-${c} mr-1"></i><strong>${r.desa}</strong></td>
              <td class="text-center"><span class="badge badge-${c} badge-stat">${fmt(r.total_penduduk)}</span></td>
              <td class="text-center"><span class="badge badge-info badge-stat">${fmt(r.laki_laki)}</span></td>
              <td class="text-center"><span class="badge badge-danger badge-stat">${fmt(r.perempuan)}</span></td>
              <td class="text-center"><span class="badge badge-success badge-stat">${fmt(r.layak)}</span></td>
              <td class="text-center"><span class="badge badge-secondary badge-stat">${fmt(r.tidak_layak)}</span></td>
              <td class="text-center"><span class="badge badge-primary badge-stat">${fmt(r.bpnt)}</span></td>
              <td class="text-center"><span class="badge badge-warning badge-stat">${fmt(r.blt)}</span></td>
              <td class="text-center"><span class="badge badge-info badge-stat">${fmt(r.pkh)}</span></td>
              <td class="text-center"><span class="badge badge-purple badge-stat">${fmt(r.bsu)}</span></td>
              <td class="text-center"><span class="badge badge-dark badge-stat">${fmt(r.belum_dapat)}</span></td>
            </tr>`;
                });
                if (!html) html =
                    '<tr><td colspan="12" class="text-center text-muted py-4">Tidak ada data</td></tr>';
                $('#tableDetailDesa').html(html);
            }

            /* ──────────────────────────────────────────
               DataTable: Abnormal
            ────────────────────────────────────────── */
            let tableAbnormal;

            function initTableAbnormal() {
                if ($.fn.DataTable.isDataTable('#tableAbnormal')) $('#tableAbnormal').DataTable().destroy();
                tableAbnormal = $('#tableAbnormal').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('kecamatan.bantuan.pemerintah.datatable.abnormal') }}',
                        type: 'GET',
                        data: d => {
                            d.kategori = $('#filterKategoriAbnormal').val();
                            d.desa = $('#filterDesaAbnormal').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'desa'
                        },
                        {
                            data: 'no_nik',
                            render: d => '<small class="text-muted">' + d + '</small>'
                        },
                        {
                            data: 'nama',
                            render: d => '<strong>' + d + '</strong>'
                        },
                        {
                            data: 'jenkel_display',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'umur_display',
                            className: 'text-center'
                        },
                        {
                            data: 'tgl_lahir_display',
                            className: 'text-center'
                        },
                        {
                            data: 'rt_rw',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'kategori_badge',
                            className: 'text-center'
                        },
                        {
                            data: 'detail_masalah',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    order: [
                        [1, 'asc'],
                        [3, 'asc']
                    ],
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, 'Semua']
                    ],
                    language: dtLang('Tidak ada data abnormal – semua data konsisten ✓'),
                    responsive: false,
                    autoWidth: false
                });
            }

            /* ──────────────────────────────────────────
               DataTable: Penduduk
            ────────────────────────────────────────── */
            let tablePenduduk;

            function initTablePenduduk() {
                if ($.fn.DataTable.isDataTable('#tablePendudukBantuan')) $('#tablePendudukBantuan').DataTable()
                    .destroy();
                tablePenduduk = $('#tablePendudukBantuan').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('kecamatan.bantuan.pemerintah.datatable.penduduk') }}',
                        data: d => {
                            d.desa = $('#filterDesa').val();
                            d.status_bantuan = $('#filterStatusBantuan').val();
                            d.jenkel = $('#filterJenkel').val();
                            d.jenis_bantuan = $('#filterJenisBantuan').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'desa'
                        },
                        {
                            data: 'no_nik',
                            render: d => '<small class="text-muted">' + d + '</small>'
                        },
                        {
                            data: 'nama',
                            render: d => '<strong>' + d + '</strong>'
                        },
                        {
                            data: 'jenkel_display',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'umur_display',
                            className: 'text-center'
                        },
                        {
                            data: 'tgl_lahir_display',
                            className: 'text-center'
                        },
                        {
                            data: 'rt_rw',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'status_badge',
                            className: 'text-center'
                        },
                        {
                            data: 'bantuan_display'
                        },
                    ],
                    order: [
                        [1, 'asc'],
                        [3, 'asc']
                    ],
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, 'Semua']
                    ],
                    language: dtLang('Tidak ada data yang ditemukan'),
                    responsive: false,
                    autoWidth: false
                });
            }

            function dtLang(emptyMsg) {
                return {
                    processing: '<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>',
                    search: '<i class="fas fa-search"></i>',
                    searchPlaceholder: 'Cari data...',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ – _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(difilter dari _MAX_ total)',
                    zeroRecords: '<div class="alert alert-success text-center"><i class="fas fa-check-circle fa-2x mb-2"></i><br>' +
                        emptyMsg + '</div>',
                    emptyTable: '<div class="alert alert-info text-center"><i class="fas fa-info-circle fa-2x mb-2"></i><br>Tidak ada data</div>',
                    paginate: {
                        first: '<<',
                        last: '>>',
                        next: '>',
                        previous: '<'
                    }
                };
            }

            /* ──────────────────────────────────────────
               Load All (AJAX calls)
            ────────────────────────────────────────── */
            function loadAll() {

                // 1. Jumlah
                $.get('{{ route('kecamatan.bantuan.pemerintah.jumlah') }}', function(r) {
                    if (!r.success) return;
                    const d = r.data;
                    animateNum('#totalPenduduk', d.total_penduduk);
                    animateNum('#totalLaki', d.total_laki);
                    animateNum('#totalPerempuan', d.total_perempuan);
                    animateNum('#layak', d.layak);
                    animateNum('#tidakLayak', d.tidak_layak);
                    animateNum('#belumDapat', d.belum_dapat);
                    animateNum('#bpnt', d.bpnt);
                    animateNum('#blt', d.blt);
                    animateNum('#pkh', d.pkh);
                    animateNum('#bsu', d.bsu);
                    animateNum('#lainnya', d.lainnya);
                });

                // 2. Rasio
                $.get('{{ route('kecamatan.bantuan.pemerintah.rasio') }}', function(r) {
                    if (!r.success) return;
                    const d = r.data;
                    $('#pctLayak').html(d.persentase_layak);
                    $('#pctLayakSfx').removeClass('d-none');
                    $('#pctTidakLayak').html(d.persentase_tidak_layak);
                    $('#pctTidakLayakSfx').removeClass('d-none');
                    $('#rasioKelayakan').html(d.rasio_kelayakan);
                    $('#rasioKelayakanSfx').removeClass('d-none');
                });

                // 3. Jenis Bantuan
                $.get('{{ route('kecamatan.bantuan.pemerintah.jenis') }}', function(r) {
                    if (r.success) renderDoughnut('chartJenisBantuan', r.data, COLORS.mixed);
                });

                // 4. Jenis Kelamin
                $.get('{{ route('kecamatan.bantuan.pemerintah.jenkel') }}', function(r) {
                    if (r.success) renderPie('chartJenkel', r.data, ['#007bff', '#e83e8c']);
                });

                // 5. Per Desa – Layak
                $.get('{{ route('kecamatan.bantuan.pemerintah.desa') }}', function(r) {
                    if (r.success) renderBar('chartDesa', r.data, COLORS.mixed);
                });

                // 6. Kelompok Umur
                $.get('{{ route('kecamatan.bantuan.pemerintah.umur') }}', function(r) {
                    if (r.success) renderBar('chartUmur', r.data, COLORS.warning);
                });

                // 7. Umur & Gender
                $.get('{{ route('kecamatan.bantuan.pemerintah.umur.jenkel') }}', function(r) {
                    if (r.success) renderGroupedBar('chartUmurJenkel', r.data);
                });

                // 8. Bantuan per Desa (stacked)
                $.get('{{ route('kecamatan.bantuan.pemerintah.jenis.desa') }}', function(r) {
                    if (r.success) renderStacked('chartBantuanDesa', r.data);
                });

                // 9. Kelayakan Per Desa (grouped layak vs tidak)
                $.get('{{ route('kecamatan.bantuan.pemerintah.detail.desa') }}', function(r) {
                    if (!r.success) return;
                    // Stacked: Layak vs Tidak Layak
                    const rows = r.data;
                    const labels = rows.map(x => x.desa);
                    const layak = rows.map(x => x.layak);
                    const tidak = rows.map(x => x.tidak_layak);
                    renderStacked('chartKelayakanDesa', {
                        labels,
                        datasets: [{
                                label: 'Layak',
                                data: layak,
                                backgroundColor: '#28a745',
                                borderColor: '#28a745',
                                borderWidth: 1,
                                borderRadius: 4
                            },
                            {
                                label: 'Tidak Layak',
                                data: tidak,
                                backgroundColor: '#dc3545',
                                borderColor: '#dc3545',
                                borderWidth: 1,
                                borderRadius: 4
                            },
                        ]
                    });
                    // Tabel
                    renderTableDetail(rows);
                });

                // 10. Abnormal
                $.get('{{ route('kecamatan.bantuan.pemerintah.abnormal') }}', function(r) {
                    if (!r.success) return;
                    renderBar('chartAbnormal', r.data, COLORS.danger);
                    $('#abnormalLayakTanpaBantuan').text(fmt(r.data['Layak Tanpa Data Bantuan'] || 0));
                    $('#abnormalLayakBelumDapat').text(fmt(r.data['Layak tapi Belum Pernah Dapat'] || 0));
                    $('#abnormalTidakLayakAdaBantuan').text(fmt(r.data['Tidak Layak tapi Ada Bantuan'] ||
                        0));
                });

                // 11. List Desa (select2)
                $.get('{{ route('kecamatan.bantuan.pemerintah.list.desa') }}', function(r) {
                    if (!r.success) return;
                    let opts = '<option value="">-- Semua Desa --</option>';
                    r.data.forEach(d => {
                        opts += `<option value="${d.code}">${d.name}</option>`;
                    });
                    $('#filterDesa, #filterDesaAbnormal').html(opts);
                    $('select.select2').select2({
                        theme: 'bootstrap4',
                        allowClear: true
                    });
                });
            }

            /* ──────────────────────────────────────────
               Event Handlers
            ────────────────────────────────────────── */
            // Filter Penduduk
            $('#btnFilter').on('click', () => tablePenduduk.ajax.reload());
            $('#btnResetFilter').on('click', () => {
                ['#filterDesa', '#filterStatusBantuan', '#filterJenkel', '#filterJenisBantuan']
                .forEach(s => $(s).val('').trigger('change'));
                tablePenduduk.ajax.reload();
            });

            // Filter Abnormal
            $('#btnFilterAbnormal').on('click', () => tableAbnormal.ajax.reload());
            $('#btnResetFilterAbnormal').on('click', () => {
                ['#filterKategoriAbnormal', '#filterDesaAbnormal']
                .forEach(s => $(s).val('').trigger('change'));
                tableAbnormal.ajax.reload();
            });

            /* ──────────────────────────────────────────
               Init
            ────────────────────────────────────────── */
            initTableAbnormal();
            initTablePenduduk();
            loadAll();
        });
    </script>
@endpush
