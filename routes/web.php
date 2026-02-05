<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BpjsController;
use App\Http\Controllers\Admin\UmurController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\AdminDesaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PekerjaanController;
use App\Http\Controllers\Admin\DataHilangController;
use App\Http\Controllers\Admin\PendapatanController;
use App\Http\Controllers\Admin\PendidikanController;
use App\Http\Controllers\Admin\PerkawinanController;
use App\Http\Controllers\Admin\KependudukanController;
use App\Http\Controllers\Admin\KartuKeluargaController;
use App\Http\Controllers\Admin\KepemilikanRumahController;
use App\Http\Controllers\Admin\BantuanPemerintahController;
use App\Http\Controllers\Admin\KartuKeluargaAnggotaController;

Route::get('/', [LandingPageController::class, 'page'])->name('landing.page');
Route::prefix('api')->group(function () {
    Route::get('/basic-stats', [LandingPageController::class, 'getBasicStats'])->name('api.basic.stats');
    Route::get('/key-metrics', [LandingPageController::class, 'getKeyMetrics'])->name('api.key.metrics');
    Route::get('/demografi-kk', [LandingPageController::class, 'getDemografiKK'])->name('api.demografi.kk');
    Route::get('/ekonomi', [LandingPageController::class, 'getEkonomi'])->name('api.ekonomi');
    Route::get('/bantuan', [LandingPageController::class, 'getBantuan'])->name('api.bantuan');
    Route::get('/kesehatan', [LandingPageController::class, 'getKesehatan'])->name('api.kesehatan');
    Route::get('/pendidikan-pekerjaan', [LandingPageController::class, 'getPendidikanPekerjaan'])->name('api.pendidikan.pekerjaan');
    Route::get('/statistik-penduduk', [LandingPageController::class, 'getStatistikPenduduk'])->name('api.statistik.penduduk');
    Route::get('/data-desa', [LandingPageController::class, 'getDataDesa'])->name('api.data.desa');
    Route::get('/all-stats', [LandingPageController::class, 'getAllStats'])->name('api.all.stats');
    Route::post('/clear-cache', [LandingPageController::class, 'clearCache'])->name('api.clear.cache');
});

Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => '/dashboard', 'as' => 'dashboard.'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::prefix('/stats')->group(function () {
            Route::get('/kependudukan', [DashboardController::class, 'statsKependudukan'])->name('kependudukan');
            Route::get('/gender', [DashboardController::class, 'statsGender'])->name('gender');
            Route::get('/umur', [DashboardController::class, 'statsUmur'])->name('umur');
            Route::get('/perkawinan', [DashboardController::class, 'statsPerkawinan'])->name('perkawinan');
            Route::get('/bpjs', [DashboardController::class, 'statsBPJS'])->name('bpjs');
            Route::get('/pendapatan', [DashboardController::class, 'statsPendapatan'])->name('pendapatan');
            Route::get('/kepemilikan-rumah', [DashboardController::class, 'statsKepemilikanRumah'])->name('kepemilikan.rumah');
            Route::get('/gol-darah', [DashboardController::class, 'statsGolDarah'])->name('gol.darah');
            Route::get('/per-desa', [DashboardController::class, 'statsPerDesa'])->name('per.desa');
        });
    });

    Route::group(['prefix' => '/penduduk', 'as' => 'penduduk.'], function () {
        Route::get('/', [KependudukanController::class, 'index'])->name('index');
        Route::get('/chart/rw-rt', [KependudukanController::class, 'chartRwRt'])->name('chart.rwrt');
    });

    Route::group(['prefix' => '/admin-desa', 'as' => 'admin.desa.'], function () {
        Route::get('/', [AdminDesaController::class, 'index'])->name('index');
        Route::get('/statistics', [AdminDesaController::class, 'getStatistics'])->name('statistics');
        Route::get('/datatables', [AdminDesaController::class, 'getDatatables'])->name('datatables');
    });

    Route::group(['prefix' => '/data-hilang', 'as' => 'data.hilang.'], function () {
        Route::get('/', [DataHilangController::class, 'index'])->name('index');
        Route::get('/kepala-keluarga-ganda', [DataHilangController::class, 'checkKepalaKeluargaGanda'])->name('kepala.ganda');
    });

    Route::group(['prefix' => '/pendidikan', 'as' => 'pendidikan.'], function () {
        Route::get('/', [PendidikanController::class, 'pendidikan'])->name('pendidikan');
        Route::get('/datatable', [PendidikanController::class, 'pendidikanDatatable'])->name('datatable');
        Route::get('/json', [PendidikanController::class,'pendidikanJson'])->name('json');
    });

    Route::group(['prefix' => '/umur', 'as' => 'umur.'], function () {
        Route::get('/', [UmurController::class, 'umur'])->name('umur');
        Route::get('/data', [UmurController::class, 'getDataUmur'])->name('data');
        Route::get('/rw-list', [UmurController::class, 'getRwList'])->name('rw.list');
        Route::get('/rt-list', [UmurController::class, 'getRtList'])->name('rt.list');
        Route::get('/data-pemilih', [UmurController::class, 'getDataPemilih'])->name('pemilih');
        Route::get('/data-semua', [UmurController::class, 'getDataSemua'])->name('semua');
    });

    Route::group(['prefix' => '/bpjs', 'as' => 'bpjs.'], function () {
        Route::get('/', [BpjsController::class, 'bpjs'])->name('bpjs');
        Route::get('/statistik', [BpjsController::class, 'getStatistik'])->name('statistik');
        Route::get('/detail', [BpjsController::class, 'getDetailData'])->name('detail');
    });

    Route::group(['prefix' => '/perkawinan', 'as' => 'perkawinan.'], function () {
        Route::get('/', [PerkawinanController::class, 'index'])->name('index');
        Route::get('/get-data', [PerkawinanController::class, 'getData'])->name('get-data');
        Route::get('/datatable', [PerkawinanController::class, 'getDataTable'])->name('datatable');
        Route::get('/filter-options', [PerkawinanController::class, 'getFilterOptions'])->name('filter-options');
    });

    Route::group(['prefix' => '/pekerjaan', 'as' => 'pekerjaan.'], function () {
        Route::get('/', [PekerjaanController::class, 'index'])->name('index');
        Route::get('/api/kpi', [PekerjaanController::class, 'getKpiData'])->name('api.kpi');
        Route::get('/api/distribusi-pekerjaan', [PekerjaanController::class, 'getDistribusiPekerjaan'])->name('api.distribusi.pekerjaan');
        Route::get('/api/distribusi-pendapatan', [PekerjaanController::class, 'getDistribusiPendapatan'])->name('api.distribusi.pendapatan');
        Route::get('/api/pekerjaan-vs-pendapatan', [PekerjaanController::class, 'getPekerjaanVsPendapatan'])->name('api.pekerjaan.pendapatan');
        Route::get('/api/pekerjaan-by-gender', [PekerjaanController::class, 'getPekerjaanByGender'])->name('api.pekerjaan.gender');
        Route::get('/api/pekerjaan-by-usia', [PekerjaanController::class, 'getPekerjaanByUsia'])->name('api.pekerjaan.usia');
        Route::get('/api/distribusi-usia', [PekerjaanController::class, 'getDistribusiUsia'])->name('api.distribusi.usia');
        Route::get('/api/status-pekerjaan', [PekerjaanController::class, 'getStatusPekerjaan'])->name('api.status.pekerjaan');
        Route::get('/api/analisis-pendapatan', [PekerjaanController::class, 'getAnalisisPendapatanProduktif'])->name('api.analisis.pendapatan');

        // DataTables API
        Route::get('/dt/detail-pekerjaan', [PekerjaanController::class, 'getDetailByPekerjaan'])->name('dt.detail.pekerjaan');
        Route::get('/dt/detail-pendapatan', [PekerjaanController::class, 'getDetailByPendapatan'])->name('dt.detail.pendapatan');
        Route::get('/dt/detail-status', [PekerjaanController::class, 'getDetailByStatus'])->name('dt.detail.status');
        Route::get('/dt/detail-gender', [PekerjaanController::class, 'getDetailByGender'])->name('dt.detail.gender');
        Route::get('/dt/detail-usia', [PekerjaanController::class, 'getDetailByUsia'])->name('dt.detail.usia');
    });

    Route::group(['prefix' => '/kepemilikan-rumah', 'as' => 'kepemilikan.rumah.'], function () {
        Route::get('/', [KepemilikanRumahController::class, 'kepemilikanRumah'])->name('index');
        Route::get('/distribusi-kk', [KepemilikanRumahController::class, 'getDistribusiPerKK'])->name('distribusi.kk');
        Route::get('/kerentanan', [KepemilikanRumahController::class, 'getKerentananPerumahan'])->name('kerentanan');
        Route::get('/by-umur', [KepemilikanRumahController::class, 'getKepemilikanByUmur'])->name('by.umur');
        Route::get('/per-wilayah', [KepemilikanRumahController::class, 'getDistribusiPerWilayah'])->name('per.wilayah');
        Route::get('/anomali', [KepemilikanRumahController::class, 'getAnomaliData'])->name('anomali');
        Route::get('/datatable', [KepemilikanRumahController::class, 'getDataTable'])->name('datatable');
        Route::get('/rw-rt-list', [KepemilikanRumahController::class, 'getRwRtList'])->name('rw.rt.list');
        Route::get('/rt-by-rw', [KepemilikanRumahController::class, 'getRtByRw'])->name('rt.by.rw');
        Route::get('/export', [KepemilikanRumahController::class, 'export'])->name('export');
    });

    Route::group(['prefix' => '/pendapatan', 'as' => 'pendapatan.'], function () {
        Route::get('/', [PendapatanController::class, 'pendapatan'])->name('pendapatan');
        Route::get('/statistik-dasar', [PendapatanController::class, 'getStatistikDasar'])->name('statistik.dasar');
        Route::get('/distribusi-pendapatan', [PendapatanController::class, 'getDistribusiPendapatan'])->name('distribusi.pendapatan');
        Route::get('/pendapatan-per-umur', [PendapatanController::class, 'getPendapatanPerUmur'])->name('pendapatan.per.umur');
        Route::get('/pendapatan-per-jenkel', [PendapatanController::class, 'getPendapatanPerJenkel'])->name('pendapatan.per.jenkel');
        Route::get('/pendapatan-per-rt', [PendapatanController::class, 'getPendapatanPerRT'])->name('pendapatan.per.rt');
        Route::get('/kelompok-rentan', [PendapatanController::class, 'getKelompokRentan'])->name('kelompok.rentan');
        Route::get('/datatable-penduduk', [PendapatanController::class, 'datatablePenduduk'])->name('datatable.penduduk');
        Route::get('/datatable-lansia-rentan', [PendapatanController::class, 'datatableLansiaRentan'])->name('datatable.lansia.rentan');
        Route::get('/datatable-per-rt/{rt_rw}', [PendapatanController::class, 'datatablePerRT'])->name('datatable.per.rt');
    });

    Route::group(['prefix' => '/bantuan-pemerintah', 'as' => 'bantuan.pemerintah.'], function () {
        Route::get('/', [BantuanPemerintahController::class, 'index'])->name('index');
        Route::get('/statistik', [BantuanPemerintahController::class, 'getStatistik'])->name('statistik');
        Route::get('/datatables', [BantuanPemerintahController::class, 'getDatatables'])->name('datatables');
    });

    Route::group(['prefix' => 'kependudukan', 'as' => 'kependudukan.'], function () {
        Route::group(['prefix' => '/kartu-keluarga', 'as' => 'kartu.keluarga.'], function () {
            Route::get('/index', [KartuKeluargaController::class, 'index'])->name('index');
            Route::get('/index-data', [KartuKeluargaController::class, 'indexData'])->name('index.data');
            Route::get('/create', [KartuKeluargaController::class, 'create'])->name('create');
            Route::post('/create', [KartuKeluargaController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [KartuKeluargaController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [KartuKeluargaController::class, 'update'])->name('update');
            Route::get('/show/{id}', [KartuKeluargaController::class, 'show'])->name('show');
            Route::get('/print/{id}', [KartuKeluargaController::class, 'print'])->name('print');
            Route::post('/delete/{id}', [KartuKeluargaController::class, 'delete'])->name('delete');
            Route::get('/trash', [KartuKeluargaController::class, 'trash'])->name('trash');
            Route::get('/trash/data', [KartuKeluargaController::class, 'trashData'])->name('trash.data');
            Route::get('/trash/data', [KartuKeluargaController::class, 'trashData'])->name('trash.data');
            Route::post('/{id}/restore', [KartuKeluargaController::class, 'restore'])->name('restore');
            Route::post('/{id}/delete-permanent', [KartuKeluargaController::class, 'deletePermanent'])->name('delete.permanent');
        });

        Route::group(['prefix' => '/anggota-keluarga', 'as' => 'anggota.keluarga.'], function () {
            Route::get('/index', [KartuKeluargaAnggotaController::class, 'index'])->name('index');
            Route::get('/index-data', [KartuKeluargaAnggotaController::class, 'indexData'])->name('index.data');
            Route::get('/index-data/kepala-keluarga', [KartuKeluargaAnggotaController::class, 'kepalaKeluarga'])->name('index.kepala.keluarga.data');
            Route::get('/create', [KartuKeluargaAnggotaController::class, 'create'])->name('create');
            Route::post('/create', [KartuKeluargaAnggotaController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [KartuKeluargaAnggotaController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [KartuKeluargaAnggotaController::class, 'update'])->name('update');
            Route::get('/show/{id}', [KartuKeluargaAnggotaController::class, 'show'])->name('show');
            Route::get('/print/{id}', [KartuKeluargaAnggotaController::class, 'print'])->name('print');
            Route::post('/delete/{id}', [KartuKeluargaAnggotaController::class, 'delete'])->name('delete');
            Route::get('/trash', [KartuKeluargaAnggotaController::class, 'trash'])->name('trash');
            Route::get('/trash/data', [KartuKeluargaAnggotaController::class, 'trashData'])->name('trash.data');
            Route::get('/trash/data', [KartuKeluargaAnggotaController::class, 'trashData'])->name('trash.data');
            Route::post('/{id}/restore', [KartuKeluargaAnggotaController::class, 'restore'])->name('restore');
            Route::post('/{id}/delete-permanent', [KartuKeluargaAnggotaController::class, 'deletePermanent'])->name('delete.permanent');
            Route::post('/restore-all', [KartuKeluargaAnggotaController::class, 'restoreAll'])->name('restore.all');
            Route::post('/delete-all-permanent', [KartuKeluargaAnggotaController::class, 'deleteAllPermanent'])->name('delete.all.permanent');
        });
    });


});
