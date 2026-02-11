@extends('admin.layout.main')
@section('title', 'Statistik Perkawinan')
@section('content-header', 'Statistik Perkawinan Kecamatan')

@push('styles')
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-2">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-ring"></i>
                                </div>

                                <div class="ml-3">
                                    <h5 class="font-weight-bold mb-1">Ringkasan Statistik Perkawinan</h5>
                                    <p class="stat-sublabel-premium mb-0">
                                        Data diperbarui secara otomatis berdasarkan database terkini
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


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

                                    <p class="stat-sublabel-premium mb-0">Seluruh Penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Total Kawin -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-heart"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalKawin">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Status Kawin
                                        <i class="fas fa-heart stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Sudah Menikah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Total Belum Kawin -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-info text-white">
                                    <i class="fas fa-user"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalBelumKawin">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Belum Kawin
                                        <i class="fas fa-user stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Belum Menikah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Total Cerai -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-unlink"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalCerai">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Total Cerai
                                        <i class="fas fa-unlink stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Cerai Hidup & Mati</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kawin Tercatat -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-teal text-white">
                                    <i class="fas fa-certificate"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalKawinTercatat">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Kawin Tercatat
                                        <i class="fas fa-certificate stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Resmi Tercatat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kawin Tidak Tercatat -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-orange text-white">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalKawinTidakTercatat">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Kawin Tidak Tercatat
                                        <i class="fas fa-exclamation-triangle stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Tidak Resmi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cerai Hidup -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-purple text-white">
                                    <i class="fas fa-user-times"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalCeraiHidup">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Cerai Hidup
                                        <i class="fas fa-user-times stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Bercerai</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cerai Mati -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-dark text-white">
                                    <i class="fas fa-praying-hands"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium" id="totalCeraiMati">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Cerai Mati
                                        <i class="fas fa-praying-hands stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Ditinggal Pasangan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <!-- ===============================
                                                                 STATISTIK USIA MENIKAH (PENTING!)
                                                            ================================= -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h4 class="section-title text-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Analisa Usia Menikah (Pernikahan Dini)
                    </h4>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Batas usia menikah sesuai UU No. 16 Tahun 2019: <strong>19
                            tahun</strong> (untuk laki-laki dan perempuan)
                    </p>
                </div>

                <!-- Menikah Di Bawah Umur Laki-laki -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-danger">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-male"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-danger" id="menikahDibawahUmurLaki">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Di Bawah Umur (L)
                                        <i class="fas fa-male stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium text-danger mb-0">Laki-laki &lt; 19 th</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menikah Di Bawah Umur Perempuan -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-danger">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-danger text-white">
                                    <i class="fas fa-female"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-danger" id="menikahDibawahUmurPerempuan">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Di Bawah Umur (P)
                                        <i class="fas fa-female stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium text-danger mb-0">Perempuan &lt; 19 th</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menikah Cukup Umur -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-check-circle"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium text-success" id="menikahCukupUmur">
                                        <span class="skeleton-premium skeleton-number-premium"></span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Cukup Umur
                                        <i class="fas fa-check-circle stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium text-success mb-0">&gt;= 19 tahun</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Persentase Di Bawah Umur -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3 border-warning">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-chart-line"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentaseDibawahUmur" class="text-warning">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentaseDibawahUmurPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        % Di Bawah Umur
                                        <i class="fas fa-chart-line stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Dari yang menikah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row mb-4">

                <div class="col-12 mb-3">
                    <h4 class="section-title">
                        <i class="fas fa-chart-pie mr-2"></i> Statistik Rasio
                    </h4>
                </div>


                <!-- Persentase Kawin -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-success text-white">
                                    <i class="fas fa-percentage"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentaseKawin">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentaseKawinPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Persentase Kawin
                                        <i class="fas fa-percentage stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Persentase Cerai -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-warning text-white">
                                    <i class="fas fa-chart-line"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="persentaseCerai">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="persentaseCeraiPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Persentase Cerai
                                        <i class="fas fa-chart-line stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Dari total penduduk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Rasio Tercatat -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="stat-card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-premium icon-teal text-white">
                                    <i class="fas fa-tasks"></i>
                                </div>

                                <div class="flex-grow-1 ml-3">
                                    <p class="stat-number-premium">
                                        <span id="rasioTercatat">
                                            <span class="skeleton-premium skeleton-number-premium"></span>
                                        </span>
                                        <span class="d-none" id="rasioTercatatPercent">%</span>
                                    </p>

                                    <p class="stat-label-premium mb-0">
                                        Rasio Tercatat
                                        <i class="fas fa-tasks stat-mini-icon"></i>
                                    </p>

                                    <p class="stat-sublabel-premium mb-0">Dari yang kawin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <!-- STATISTIK DISTRIBUSI -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h4 class="section-title">
                        <i class="fas fa-chart-bar mr-2"></i> Statistik Distribusi
                    </h4>
                </div>

                <!-- Distribusi Status Perkawinan -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon">
                                <i class="fas fa-ring"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Status Perkawinan</h3>
                                <p class="card-subtitle-premium">Berdasarkan status nikah</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartStatus" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartStatus" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Kawin Tercatat -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-success">
                            <div class="card-header-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Status Kawin Tercatat</h3>
                                <p class="card-subtitle-premium">Pencatatan pernikahan resmi</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartTercatat" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartTercatat" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Per Desa -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-info">
                            <div class="card-header-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Per Desa</h3>
                                <p class="card-subtitle-premium">Total penduduk per desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
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
                            <canvas id="chartDesa" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Berdasarkan Jenis Kelamin -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-warning">
                            <div class="card-header-icon">
                                <i class="fas fa-venus-mars"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Jenis Kelamin (Kawin)</h3>
                                <p class="card-subtitle-premium">Yang sudah menikah</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
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
                            <canvas id="chartJenkel" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Usia Menikah -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Distribusi Usia Menikah</h3>
                                <p class="card-subtitle-premium">Kelompok umur yang sudah kawin</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
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
                            <canvas id="chartUmur" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Kategori Usia Menikah Detail -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-warning">
                            <div class="card-header-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Kategori Usia Menikah</h3>
                                <p class="card-subtitle-premium">Dari sangat dini hingga usia lanjut</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartKategoriUsia" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartKategoriUsia" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Menikah Di Bawah Umur Per Desa -->
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Pernikahan Di Bawah Umur Per Desa</h3>
                                <p class="card-subtitle-premium">Monitoring pernikahan dini setiap desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium">
                            <div id="loadingChartDibawahUmurDesa" class="loading-premium">
                                <div class="spinner-premium">
                                    <div class="double-bounce1"></div>
                                    <div class="double-bounce2"></div>
                                </div>
                                <p class="loading-text">Memproses data...</p>
                            </div>
                            <canvas id="chartDibawahUmurDesa" style="display:none; max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Data Abnormal -->
                <div class="col-lg-12 mb-4">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-dark">
                            <div class="card-header-icon">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Data Abnormal Per Desa</h3>
                                <p class="card-subtitle-premium">Ketidaksesuaian data perkawinan</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
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
                            <canvas id="chartAbnormal" style="display:none; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Detail Menikah Di Bawah Umur -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-danger">
                            <div class="card-header-icon">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Detail Daftar Menikah Di Bawah Umur (&lt; 19 Tahun)</h3>
                                <p class="card-subtitle-premium">Daftar lengkap penduduk yang menikah di bawah umur per
                                    desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool-premium"
                                    onclick="exportTableToExcel('tableDetailDibawahUmur', 'Menikah_Dibawah_Umur')">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium p-0">
                            <div class="alert alert-warning m-3 mb-0">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Perhatian:</strong> Data ini menampilkan penduduk yang menikah di bawah batas usia
                                minimum
                                (19 tahun) sesuai UU No. 16 Tahun 2019. Perlu pendampingan dan perhatian khusus.
                            </div>
                            <div class="table-container-premium">
                                <div class="table-responsive">
                                    <table class="table-premium table-hover" id="tableDetailDibawahUmur">
                                        <thead>
                                            <tr>
                                                <th width="3%">#</th>
                                                <th width="15%">Desa</th>
                                                <th width="15%">NIK</th>
                                                <th width="20%">Nama</th>
                                                <th width="10%" class="text-center">Jenis Kelamin</th>
                                                <th width="8%" class="text-center">Umur</th>
                                                <th width="10%" class="text-center">Tgl Lahir</th>
                                                <th width="8%" class="text-center">RT/RW</th>
                                                <th width="11%" class="text-center">Status Tercatat</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBodyDibawahUmur">
                                            <tr>
                                                <td colspan="9" class="py-4 text-center">
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

            <!-- Tabel Menikah Di Bawah Umur Per Desa -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-warning">
                            <div class="card-header-icon">
                                <i class="fas fa-table"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Rekap Menikah Di Bawah Umur Per Desa</h3>
                                <p class="card-subtitle-premium">Statistik pernikahan dini setiap desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium p-0">
                            <div class="table-container-premium">
                                <div class="table-responsive">
                                    <table class="table-premium table-hover">
                                        <thead class="nowrap">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="25%">Desa</th>
                                                <th width="12%" class="text-center">Total Menikah</th>
                                                <th width="12%" class="text-center">Dibawah Umur (L)</th>
                                                <th width="12%" class="text-center">Dibawah Umur (P)</th>
                                                <th width="12%" class="text-center">Sangat Dini (&lt;16)</th>
                                                <th width="12%" class="text-center">Total Dibawah Umur</th>
                                                <th width="10%" class="text-center">% Dibawah Umur</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableDibawahUmurDesa" class="nowrap">
                                            <tr class="nowrap">
                                                <td colspan="8" class="py-4 text-center">
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

            <!-- Tabel Detail Per Desa -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="stat-card-premium elevation-3">
                        <div class="card-header-premium bg-gradient-primary">
                            <div class="card-header-icon">
                                <i class="fas fa-table"></i>
                            </div>
                            <div class="card-header-text">
                                <h3 class="card-title-premium">Detail Perkawinan Per Desa</h3>
                                <p class="card-subtitle-premium">Rincian lengkap setiap desa</p>
                            </div>
                            <div class="card-tools-premium">
                                <button type="button" class="btn btn-tool-premium" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body-premium p-0">
                            <div class="table-container-premium">
                                <div class="table-responsive">
                                    <table class="table-premium table-hover">
                                        <thead class="nowrap">
                                            <tr class="nowrap">
                                                <th width="3%">#</th>
                                                <th width="15%">Desa</th>
                                                <th width="10%" class="text-center">Total</th>
                                                <th width="10%" class="text-center">Kawin</th>
                                                <th width="10%" class="text-center">Belum Kawin</th>
                                                <th width="10%" class="text-center">Cerai Hidup</th>
                                                <th width="10%" class="text-center">Cerai Mati</th>
                                                <th width="10%" class="text-center">Tercatat</th>
                                                <th width="10%" class="text-center">Tidak Tercatat</th>
                                                <th width="12%" class="text-center">% Tercatat</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableDetailDesa" class="nowrap">
                                            <tr class="nowrap">
                                                <td colspan="10" class="py-4 text-center">
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
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let charts = {};

            const colors = {
                primary: ['#007bff', '#0056b3', '#004085', '#6610f2', '#6f42c1'],
                success: ['#28a745', '#20c997', '#17a2b8', '#138496', '#117a8b'],
                warning: ['#ffc107', '#ff9800', '#ff5722', '#e91e63', '#f44336'],
                info: ['#17a2b8', '#20c997', '#6610f2', '#007bff', '#6c757d'],
                danger: ['#dc3545', '#c82333', '#bd2130', '#a71d2a', '#8b0000'],
                mixed: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2', '#fd7e14', '#20c997',
                    '#e83e8c', '#6c757d', '#343a40'
                ],
                desa: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2', '#fd7e14', '#20c997',
                    '#e83e8c', '#6c757d', '#343a40'
                ]
            };

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function hideChartLoading(chartId) {
                $('#loading' + chartId.charAt(0).toUpperCase() + chartId.slice(1)).fadeOut(300, function() {
                    $('#' + chartId).fadeIn(400);
                });
            }

            function animateNumber(selector, target) {
                const element = $(selector);
                const duration = 1000;
                const increment = target / (duration / 16);
                let current = 0;

                const timer = setInterval(function() {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    element.text(formatNumber(Math.floor(current)));
                }, 16);
            }

            // PARALLEL LOADING - Semua request jalan bersamaan!
            function loadAllData() {
                // 1. Load Statistik Jumlah
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.jumlah') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            animateNumber('#totalPenduduk', data.total_penduduk);
                            animateNumber('#totalKawin', data.total_kawin);
                            animateNumber('#totalBelumKawin', data.total_belum_kawin);
                            animateNumber('#totalCerai', data.total_cerai_hidup + data
                                .total_cerai_mati);
                            animateNumber('#totalKawinTercatat', data.total_kawin_tercatat);
                            animateNumber('#totalKawinTidakTercatat', data.total_kawin_tidak_tercatat);
                            animateNumber('#totalCeraiHidup', data.total_cerai_hidup);
                            animateNumber('#totalCeraiMati', data.total_cerai_mati);
                        }
                    }
                });

                // 2. Load Statistik Rasio
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.rasio') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            $('#persentaseKawin').html(data.persentase_kawin);
                            $('#persentaseKawinPercent').removeClass('d-none');
                            $('#persentaseCerai').html(data.persentase_cerai);
                            $('#persentaseCeraiPercent').removeClass('d-none');
                            $('#rasioTercatat').html(data.rasio_tercatat);
                            $('#rasioTercatatPercent').removeClass('d-none');
                        }
                    }
                });

                // 2b. Load Analisa Usia Menikah
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.analisa.usia') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            animateNumber('#menikahDibawahUmurLaki', data.menikah_dibawah_umur_laki);
                            animateNumber('#menikahDibawahUmurPerempuan', data
                                .menikah_dibawah_umur_perempuan);
                            animateNumber('#menikahCukupUmur', data.menikah_cukup_umur);
                            $('#persentaseDibawahUmur').html(data.persentase_dibawah_umur);
                            $('#persentaseDibawahUmurPercent').removeClass('d-none');
                        }
                    }
                });

                // 3. Load Chart Status Perkawinan
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.distribusi.status') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderPieChart('chartStatus', 'Status Perkawinan', response.data, colors
                                .mixed);
                        }
                    }
                });

                // 4. Load Chart Tercatat
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.distribusi.tercatat') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderDoughnutChart('chartTercatat', 'Status Tercatat', response.data, [
                                '#28a745', '#dc3545', '#ffc107'
                            ]);
                        }
                    }
                });

                // 5. Load Chart Desa
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.distribusi.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartDesa', 'Distribusi Per Desa', response.data, colors
                                .desa);
                        }
                    }
                });

                // 6. Load Chart Jenis Kelamin
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.distribusi.jenkel') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderPieChart('chartJenkel', 'Jenis Kelamin', response.data, ['#007bff',
                                '#e83e8c'
                            ]);
                        }
                    }
                });

                // 7. Load Chart Umur
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.distribusi.umur') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderBarChart('chartUmur', 'Kelompok Umur', response.data, colors.danger);
                        }
                    }
                });

                // 7b. Load Chart Kategori Usia Menikah
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.distribusi.usia.kategori') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderDoughnutChart('chartKategoriUsia', 'Kategori Usia', response.data, [
                                '#dc3545', '#fd7e14', '#ffc107', '#28a745', '#17a2b8', '#6c757d'
                            ]);
                        }
                    }
                });

                // 7c. Load Chart Di Bawah Umur Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.dibawah.umur.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderDibawahUmurDesaChart(response.data);
                        }
                    }
                });

                // 8. Load Chart Abnormal
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.data.abnormal') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderAbnormalChart(response.data);
                        }
                    }
                });

                // 9. Load Table Detail Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.detail.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderTableDetailDesa(response.data);
                        }
                    }
                });

                // 10. Load Table Di Bawah Umur Per Desa
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.dibawah.umur.desa') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            renderTableDibawahUmurDesa(response.data);
                        }
                    }
                });

                // 11. Load Table Detail Menikah Di Bawah Umur
                $.ajax({
                    url: '{{ route('kecamatan.perkawinan.detail.dibawah.umur') }}',
                    type: 'GET',
                    success: function(response) {

                        if (response.success) {
                            renderTableDetailDibawahUmur(response.data);
                        }
                    }
                });
            }

            function renderBarChart(canvasId, title, data, colorPalette) {
                const ctx = document.getElementById(canvasId);
                if (charts[canvasId]) charts[canvasId].destroy();

                const labels = Object.keys(data);
                const values = Object.values(data);
                const backgroundColors = labels.map((_, index) => colorPalette[index % colorPalette.length]);

                charts[canvasId] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah',
                            data: values,
                            backgroundColor: backgroundColors,
                            borderColor: backgroundColors,
                            borderWidth: 1,
                            borderRadius: 10
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
                                        return 'Jumlah: ' + formatNumber(context.parsed.y) + ' orang';
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
                                    callback: function(value) {
                                        return formatNumber(value);
                                    },
                                    font: {
                                        size: 12
                                    }
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
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
                hideChartLoading(canvasId);
            }

            function renderPieChart(canvasId, title, data, colorPalette) {
                const ctx = document.getElementById(canvasId);
                if (charts[canvasId]) charts[canvasId].destroy();

                charts[canvasId] = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            data: Object.values(data),
                            backgroundColor: colorPalette,
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
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': ' + formatNumber(value) + ' (' + percentage +
                                            '%)';
                                    }
                                }
                            }
                        }
                    }
                });
                hideChartLoading(canvasId);
            }

            function renderDoughnutChart(canvasId, title, data, colorPalette) {
                const ctx = document.getElementById(canvasId);
                if (charts[canvasId]) charts[canvasId].destroy();

                charts[canvasId] = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            data: Object.values(data),
                            backgroundColor: colorPalette,
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
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': ' + formatNumber(value) + ' (' + percentage +
                                            '%)';
                                    }
                                }
                            }
                        }
                    }
                });
                hideChartLoading(canvasId);
            }

            function renderAbnormalChart(data) {
                const ctx = document.getElementById('chartAbnormal');
                if (charts['chartAbnormal']) charts['chartAbnormal'].destroy();

                const labels = data.map(item => item.desa);
                const kawinTanpaKet = data.map(item => item.kawin_tanpa_keterangan);
                const belumKawinAdaKet = data.map(item => item.belum_kawin_ada_keterangan);
                const ceraiAdaKet = data.map(item => item.cerai_ada_keterangan);

                charts['chartAbnormal'] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Kawin Tanpa Keterangan',
                                data: kawinTanpaKet,
                                backgroundColor: '#ffc107',
                                borderColor: '#ffc107',
                                borderWidth: 1
                            },
                            {
                                label: 'Belum Kawin Ada Keterangan',
                                data: belumKawinAdaKet,
                                backgroundColor: '#dc3545',
                                borderColor: '#dc3545',
                                borderWidth: 1
                            },
                            {
                                label: 'Cerai Ada Keterangan',
                                data: ceraiAdaKet,
                                backgroundColor: '#6c757d',
                                borderColor: '#6c757d',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 15,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + formatNumber(context
                                            .parsed.y);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                stacked: false,
                                grid: {
                                    color: 'rgba(0,0,0,0.03)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return formatNumber(value);
                                    }
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
                hideChartLoading('chartAbnormal');
            }

            function renderTableDetailDesa(data) {
                let html = '';
                const badgeColors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary', 'dark',
                    'primary', 'success', 'info', 'warning'
                ];

                data.forEach((item, index) => {
                    const badgeColor = badgeColors[index % badgeColors.length];
                    html += `
                        <tr>
                            <td class="font-weight-bold">${index + 1}</td>
                            <td>
                                <i class="fas fa-map-marker-alt text-${badgeColor} mr-2"></i>
                                <strong>${item.desa}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-${badgeColor} badge-stat">${formatNumber(item.total_penduduk)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success badge-stat">${formatNumber(item.kawin)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info badge-stat">${formatNumber(item.belum_kawin)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-warning badge-stat">${formatNumber(item.cerai_hidup)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-dark badge-stat">${formatNumber(item.cerai_mati)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success badge-stat">${formatNumber(item.tercatat)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-danger badge-stat">${formatNumber(item.tidak_tercatat)}</span>
                            </td>
                            <td class="text-center">
                                <strong class="text-${item.persentase_tercatat >= 80 ? 'success' : item.persentase_tercatat >= 50 ? 'warning' : 'danger'}">${item.persentase_tercatat}%</strong>
                            </td>
                        </tr>
                    `;
                });

                if (html === '') {
                    html = '<tr><td colspan="10" class="text-center text-muted py-4">Tidak ada data</td></tr>';
                }

                $('#tableDetailDesa').html(html);
            }

            function renderDibawahUmurDesaChart(data) {
                const ctx = document.getElementById('chartDibawahUmurDesa');
                if (charts['chartDibawahUmurDesa']) charts['chartDibawahUmurDesa'].destroy();

                const labels = data.map(item => item.desa);
                const dibawahUmurLaki = data.map(item => item.dibawah_umur_laki);
                const dibawahUmurPerempuan = data.map(item => item.dibawah_umur_perempuan);
                const sangatDini = data.map(item => item.sangat_dini);

                charts['chartDibawahUmurDesa'] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Laki-laki (< 19 th)',
                                data: dibawahUmurLaki,
                                backgroundColor: '#007bff',
                                borderColor: '#007bff',
                                borderWidth: 1
                            },
                            {
                                label: 'Perempuan (< 19 th)',
                                data: dibawahUmurPerempuan,
                                backgroundColor: '#e83e8c',
                                borderColor: '#e83e8c',
                                borderWidth: 1
                            },
                            {
                                label: 'Sangat Dini (< 16 th)',
                                data: sangatDini,
                                backgroundColor: '#dc3545',
                                borderColor: '#dc3545',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 13,
                                        weight: '600'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 15,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + formatNumber(context
                                            .parsed.y) + ' orang';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                stacked: false,
                                grid: {
                                    color: 'rgba(0,0,0,0.03)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return formatNumber(value);
                                    }
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
                hideChartLoading('chartDibawahUmurDesa');
            }

            function renderTableDibawahUmurDesa(data) {
                let html = '';
                const badgeColors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary', 'dark',
                    'primary', 'success', 'info', 'warning'
                ];

                data.forEach((item, index) => {
                    const badgeColor = badgeColors[index % badgeColors.length];
                    const statusColor = item.persentase_dibawah_umur >= 10 ? 'danger' :
                        item.persentase_dibawah_umur >= 5 ? 'warning' : 'success';

                    html += `
                        <tr>
                            <td class="font-weight-bold">${index + 1}</td>
                            <td>
                                <i class="fas fa-map-marker-alt text-${badgeColor} mr-2"></i>
                                <strong>${item.desa}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-${badgeColor} badge-stat">${formatNumber(item.total_menikah)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary badge-stat">${formatNumber(item.dibawah_umur_laki)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-danger badge-stat">${formatNumber(item.dibawah_umur_perempuan)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-danger badge-stat">${formatNumber(item.sangat_dini)}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-warning badge-stat">${formatNumber(item.total_dibawah_umur)}</span>
                            </td>
                            <td class="text-center">
                                <strong class="text-${statusColor}">${item.persentase_dibawah_umur}%</strong>
                            </td>
                        </tr>
                    `;
                });

                if (html === '') {
                    html = '<tr><td colspan="8" class="text-center text-muted py-4">Tidak ada data</td></tr>';
                }

                $('#tableDibawahUmurDesa').html(html);
            }

            function renderTableDetailDibawahUmur(data) {
                let html = '';
                if (data && data.length > 0) {

                    data.forEach((item, index) => {

                        const kategoriClass = item.kategori === 'Sangat Dini' ? 'danger' : 'warning';
                        const jenkelIcon = item.jenkel === 'Laki-laki' ?
                            'fa-male text-primary' :
                            'fa-female text-danger';

                        let statusBadge = '';
                        if (item.status_tercatat === 'kawin_tercatat') {
                            statusBadge = '<span class="badge badge-success">Tercatat</span>';
                        } else if (item.status_tercatat === 'kawin_tidak_tercatat') {
                            statusBadge = '<span class="badge badge-danger">Tidak Tercatat</span>';
                        } else {
                            statusBadge = '<span class="badge badge-secondary">Tidak Ada Ket</span>';
                        }

                        html += `
                <tr>
                    <td class="font-weight-bold">${index + 1}</td>
                    <td>${item.desa}</td>
                    <td><small class="text-muted">${item.no_nik}</small></td>
                    <td><strong>${item.nama}</strong></td>
                    <td class="text-center">
                        <i class="fas ${jenkelIcon} fa-lg"></i>
                        <small class="d-block">${item.jenkel}</small>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-${kategoriClass} badge-lg">${item.umur} th</span>
                    </td>
                    <td class="text-center"><small>${item.tgl_lahir}</small></td>
                    <td class="text-center"><strong>${item.rt_rw}</strong></td>
                    <td class="text-center">${statusBadge}</td>
                </tr>
            `;
                    });

                } else {
                    html = `
            <tr>
                <td colspan="9" class="text-center py-4">
                    <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                    <h5 class="text-success">Tidak ada data pernikahan di bawah umur</h5>
                    <p class="text-muted">Semua pernikahan sudah sesuai usia minimum</p>
                </td>
            </tr>
        `;
                }

                $('#tableBodyDibawahUmur').html(html);
            }


            // Export to Excel function
            function exportTableToExcel(tableId, filename = 'export') {
                const table = document.getElementById(tableId);
                const wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet1"
                });
                XLSX.writeFile(wb, filename + '.xlsx');
            }

            // INITIALIZE - Load semua data secara parallel
            loadAllData();
        });
    </script>
@endpush
