<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BpjsController;
use App\Http\Controllers\Admin\UmurController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PendapatanController;
use App\Http\Controllers\Admin\PendidikanController;
use App\Http\Controllers\Admin\KependudukanController;
use App\Http\Controllers\Admin\KartuKeluargaController;
use App\Http\Controllers\Admin\KepemilikanRumahController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => '/dashboard', 'as' => 'dashboard.'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => '/penduduk', 'as' => 'penduduk.'], function () {
        Route::get('/', [KependudukanController::class, 'index'])->name('index');
        Route::get('/chart/rw-rt', [KependudukanController::class, 'chartRwRt'])->name('chart.rwrt');
    });

    Route::group(['prefix' => '/pendidikan', 'as' => 'pendidikan.'], function () {
        Route::get('/', [PendidikanController::class, 'pendidikan'])->name('pendidikan');
        Route::get('/datatable', [PendidikanController::class, 'pendidikanDatatable'])->name('datatable');
        Route::get('/json', [PendidikanController::class,'pendidikanJson'])->name('json');
    });

    Route::group(['prefix' => '/umur', 'as' => 'umur.'], function () {
        Route::get('/', [UmurController::class, 'umur'])->name('umur');
        Route::get('/umur/data', [UmurController::class, 'getDataUmur'])->name('data');
        Route::get('/umur/rw-list', [UmurController::class, 'getRwList'])->name('rw.list');
        Route::get('/umur/rt-list', [UmurController::class, 'getRtList'])->name('rt.list');
        Route::get('/umur/data-pemilih', [UmurController::class, 'getDataPemilih'])->name('pemilih');
        Route::get('/umur/data-semua', [UmurController::class, 'getDataSemua'])->name('semua');
    });

    Route::group(['prefix' => '/bpjs', 'as' => 'bpjs.'], function () {
        Route::get('/', [BpjsController::class, 'bpjs'])->name('bpjs');
        Route::get('/statistik', [BpjsController::class, 'getStatistik'])->name('statistik');
        Route::get('/detail', [BpjsController::class, 'getDetailData'])->name('detail');
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

    Route::group(['prefix' => 'kependudukan', 'as' => 'kependudukan.'], function () {
        Route::group(['prefix' => '/kartu-keluarga', 'as' => 'kartu.keluarga.'], function () {
            Route::get('/index', [KartuKeluargaController::class, 'index'])->name('index');
            Route::get('/index-data', [KartuKeluargaController::class, 'indexData'])->name('index.data');
            Route::get('/create', [KartuKeluargaController::class, 'create'])->name('create');
            Route::post('/create', [KartuKeluargaController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [KartuKeluargaController::class, 'edit'])->name('edit');
            Route::post('/edit/{id}', [KartuKeluargaController::class, 'update'])->name('update');
            Route::get('/show/{id}', [KartuKeluargaController::class, 'show'])->name('show');
            Route::post('/delete/{id}', [KartuKeluargaController::class, 'delete'])->name('delete');
        });
    });


});