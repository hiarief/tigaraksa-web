<?php

use App\Http\Controllers\Admin\AdminDesaController;
use App\Http\Controllers\Admin\Auth\PermissionController;
use App\Http\Controllers\Admin\Auth\RoleController;
use App\Http\Controllers\Admin\Auth\UserController;
use App\Http\Controllers\Admin\BantuanPemerintahController;
use App\Http\Controllers\Admin\BpjsController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataHilangController;
use App\Http\Controllers\Admin\KartuKeluargaAnggotaController;
use App\Http\Controllers\Admin\KartuKeluargaController;
use App\Http\Controllers\Admin\Kecamatan\KependudukanKecamatanContrroller;
use App\Http\Controllers\Admin\Kecamatan\PendidikanKecamatanController;
use App\Http\Controllers\Admin\Kecamatan\PerkawinanKecamatanController;
use App\Http\Controllers\Admin\Kecamatan\UmurKecamatanController;
use App\Http\Controllers\Admin\KepemilikanRumahController;
use App\Http\Controllers\Admin\KependudukanController;
use App\Http\Controllers\Admin\PekerjaanController;
use App\Http\Controllers\Admin\PendapatanController;
use App\Http\Controllers\Admin\PendidikanController;
use App\Http\Controllers\Admin\PerkawinanController;
use App\Http\Controllers\Admin\UmurController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

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

    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{id}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{id}', [RoleController::class, 'destroy'])->name('destroy');
            Route::get('/get-users/{id}', [RoleController::class, 'getUsersByRole'])->name('get.users');
            Route::get('/get-permissions/{id}', [RoleController::class, 'getPermissionsByRole'])->name('get.permissions');
        });

        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::get('/create', [PermissionController::class, 'create'])->name('create');
            Route::post('/', [PermissionController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PermissionController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PermissionController::class, 'update'])->name('update');
            Route::delete('/{id}', [PermissionController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [PermissionController::class, 'bulkDelete'])->name('bulk-delete');
        });
    });

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
        Route::get('/kpi', [PekerjaanController::class, 'getKpiData'])->name('api.kpi');
        Route::get('/distribusi-pekerjaan', [PekerjaanController::class, 'getDistribusiPekerjaan'])->name('api.distribusi.pekerjaan');
        Route::get('/distribusi-pendapatan', [PekerjaanController::class, 'getDistribusiPendapatan'])->name('api.distribusi.pendapatan');
        Route::get('/pekerjaan-vs-pendapatan', [PekerjaanController::class, 'getPekerjaanVsPendapatan'])->name('api.pekerjaan.pendapatan');
        Route::get('/pekerjaan-by-gender', [PekerjaanController::class, 'getPekerjaanByGender'])->name('api.pekerjaan.gender');
        Route::get('/pekerjaan-by-usia', [PekerjaanController::class, 'getPekerjaanByUsia'])->name('api.pekerjaan.usia');
        Route::get('/distribusi-usia', [PekerjaanController::class, 'getDistribusiUsia'])->name('api.distribusi.usia');
        Route::get('/status-pekerjaan', [PekerjaanController::class, 'getStatusPekerjaan'])->name('api.status.pekerjaan');
        Route::get('/analisis-pendapatan', [PekerjaanController::class, 'getAnalisisPendapatanProduktif'])->name('api.analisis.pendapatan');
        Route::get('/detail-pekerjaan', [PekerjaanController::class, 'getDetailByPekerjaan'])->name('dt.detail.pekerjaan');
        Route::get('/detail-pendapatan', [PekerjaanController::class, 'getDetailByPendapatan'])->name('dt.detail.pendapatan');
        Route::get('/detail-status', [PekerjaanController::class, 'getDetailByStatus'])->name('dt.detail.status');
        Route::get('/detail-gender', [PekerjaanController::class, 'getDetailByGender'])->name('dt.detail.gender');
        Route::get('/detail-usia', [PekerjaanController::class, 'getDetailByUsia'])->name('dt.detail.usia');
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

    Route::group(['prefix' => '/kecamatan', 'as' => 'kecamatan.'], function () {
        Route::group(['prefix' => '/kependudukan', 'as' => 'kependudukan.'], function () {
            Route::get('/', [KependudukanKecamatanContrroller::class, 'index'])->name('index');
            Route::get('/jumlah', [KependudukanKecamatanContrroller::class, 'getJumlah'])->name('jumlah');
            Route::get('/rasio', [KependudukanKecamatanContrroller::class, 'getRasio'])->name('rasio');
            Route::get('/distribusi/desa', [KependudukanKecamatanContrroller::class, 'getDistribusiDesa'])->name('distribusi.desa');
            Route::get('/distribusi/hubungan', [KependudukanKecamatanContrroller::class, 'getDistribusiHubungan'])->name('distribusi.hubungan');
            Route::get('/distribusi/umur', [KependudukanKecamatanContrroller::class, 'getDistribusiUmur'])->name('distribusi.umur');
            Route::get('/distribusi/produktif', [KependudukanKecamatanContrroller::class, 'getProduktif'])->name('distribusi.produktif');
            Route::get('/distribusi/anggota-kk', [KependudukanKecamatanContrroller::class, 'getDistribusiAnggotaKK'])->name('distribusi.anggota_kk');
            Route::get('/pertumbuhan', [KependudukanKecamatanContrroller::class, 'getPertumbuhan'])->name('pertumbuhan');
            Route::get('/distribusi/wilayah', [KependudukanKecamatanContrroller::class, 'getDistribusiWilayah'])->name('distribusi.wilayah');
        });

        Route::group(['prefix' => '/umur', 'as' => 'umur.'], function () {
            Route::get('/', [UmurKecamatanController::class, 'index'])->name('index');
            Route::get('/clear-cache', [UmurKecamatanController::class, 'clearCache'])->name('clear_cache');
            Route::get('/distribusi-umur', [UmurKecamatanController::class, 'distribusiUmur'])->name('distribusi.umur');
            Route::get('/distribusi-umur-desa', [UmurKecamatanController::class, 'distribusiUmurPerDesa'])->name('distribusi.umur.desa');
            Route::get('/kategori-umur', [UmurKecamatanController::class, 'kategoriUmur'])->name('kategori.umur');
            Route::get('/produktif-desa', [UmurKecamatanController::class, 'produktifPerDesa'])->name('produktif.desa');
            Route::get('/layak-memilih-desa', [UmurKecamatanController::class, 'layakMemilihPerDesa'])->name('layak_memilih.desa');
            Route::get('/statistik-lanjutan', [UmurKecamatanController::class, 'statistikLanjutan'])->name('statistik.lanjutan');
            Route::get('/tren-pertumbuhan', [UmurKecamatanController::class, 'trenPertumbuhan'])->name('tren.pertumbuhan');
        });

        Route::group(['prefix' => '/perkawinan', 'as' => 'perkawinan.'], function () {
            Route::get('/', [PerkawinanKecamatanController::class, 'index'])->name('index');
            Route::get('/jumlah', [PerkawinanKecamatanController::class, 'jumlah'])->name('jumlah');
            Route::get('/rasio', [PerkawinanKecamatanController::class, 'rasio'])->name('rasio');
            Route::get('/distribusi/status', [PerkawinanKecamatanController::class, 'distribusiStatus'])->name('distribusi.status');
            Route::get('/distribusi/tercatat', [PerkawinanKecamatanController::class, 'distribusiTercatat'])->name('distribusi.tercatat');
            Route::get('/distribusi/desa', [PerkawinanKecamatanController::class, 'distribusiDesa'])->name('distribusi.desa');
            Route::get('/distribusi/jenkel', [PerkawinanKecamatanController::class, 'distribusiJenkel'])->name('distribusi.jenkel');
            Route::get('/distribusi/umur', [PerkawinanKecamatanController::class, 'distribusiUmur'])->name('distribusi.umur');
            Route::get('/analisa/usia', [PerkawinanKecamatanController::class, 'analisaUsiaMenikah'])->name('analisa.usia');
            Route::get('/distribusi/usia-kategori', [PerkawinanKecamatanController::class, 'distribusiMenikahDibawahUmur'])->name('distribusi.usia.kategori');
            Route::get('/dibawah-umur/desa', [PerkawinanKecamatanController::class, 'menikahDibawahUmurPerDesa'])->name('dibawah.umur.desa');
            Route::get('/detail/dibawah-umur', [PerkawinanKecamatanController::class, 'detailMenikahDibawahUmur'])->name('detail.dibawah.umur');
            Route::get('/data/abnormal', [PerkawinanKecamatanController::class, 'dataAbnormal'])->name('data.abnormal');
            Route::get('/detail/desa', [PerkawinanKecamatanController::class, 'detailPerDesa'])->name('detail.desa');
        });

        Route::group(['prefix' => '/pendidikan', 'as' => 'pendidikan.'], function () {

            // Main View
            Route::get('/', [PendidikanKecamatanController::class, 'index'])->name('index');

            // Statistics APIs
            Route::get('/jumlah', [PendidikanKecamatanController::class, 'getStatistikJumlah'])->name('jumlah');
            Route::get('/rasio', [PendidikanKecamatanController::class, 'getStatistikRasio'])->name('rasio');

            // Distribution APIs
            Route::get('/distribusi/tingkat', [PendidikanKecamatanController::class, 'getDistribusiTingkatPendidikan'])->name('distribusi.tingkat');
            Route::get('/distribusi/jenkel', [PendidikanKecamatanController::class, 'getDistribusiJenisKelamin'])->name('distribusi.jenkel');
            Route::get('/distribusi/desa', [PendidikanKecamatanController::class, 'getDistribusiPerDesa'])->name('distribusi.desa');
            Route::get('/distribusi/umur', [PendidikanKecamatanController::class, 'getDistribusiUmur'])->name('distribusi.umur');
            Route::get('/distribusi/non-formal', [PendidikanKecamatanController::class, 'getDistribusiPendidikanNonFormal'])->name('distribusi.non.formal');

            // Status & Details APIs
            Route::get('/status/sedang-sekolah', [PendidikanKecamatanController::class, 'getStatusSedangSekolah'])->name('status.sedang.sekolah');
            Route::get('/detail/desa', [PendidikanKecamatanController::class, 'getDetailPerDesa'])->name('detail.desa');
            Route::get('/umur-jenkel', [PendidikanKecamatanController::class, 'getPendidikanByUmurJenkel'])->name('umur.jenkel');

            // Analysis APIs
            Route::get('/analisa/usia-sekolah', [PendidikanKecamatanController::class, 'getAnalisaUsiaSekolah'])->name('analisa.usia.sekolah');
            Route::get('/kesesuaian-usia-desa', [PendidikanKecamatanController::class, 'getKesesuaianUsiaPerDesa'])->name('kesesuaian.usia.desa');

            // DataTable & Filters
            Route::get('/datatable/tidak-sekolah-wajib-belajar', [PendidikanKecamatanController::class, 'getDetailTidakSekolahWajibBelajarDatatable'])->name('datatable.tidak.sekolah.wajib.belajar');
            Route::get('/list-desa', [PendidikanKecamatanController::class, 'getListDesa'])->name('list.desa');
            Route::get('/summary/tidak-sekolah-wajib-belajar', [PendidikanKecamatanController::class, 'getSummaryTidakSekolahWajibBelajar'])->name('summary.tidak.sekolah.wajib.belajar');

        });

    });

});