<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KontrakController;
use App\Http\Controllers\Umum\MonitoringUmumController;
use App\Http\Controllers\Umum\PembayaranUmumController;
use App\Http\Controllers\BoardingKonsumsi\TambahSiswaBoardingKonsumsiController;
use App\Http\Controllers\BoardingKonsumsi\MonitoringBKController;
use App\Http\Controllers\BoardingKonsumsi\PembayaranBKController;
use App\Http\Controllers\UangSaku\MonitoringUangSakuController;
use App\Http\Controllers\UangSaku\TopupUangSakuController;
use App\Http\Controllers\UangSaku\PengeluaranUangSakuController;
use App\Http\Controllers\Ekstra\EkstraController;
use App\Http\Controllers\Ekstra\MonitoringEkstraController;
use App\Http\Controllers\Ekstra\TambahSiswaEkstraController;
use App\Http\Controllers\Ekstra\PembayaranEkstraController;
use App\Http\Controllers\Pengeluaran\MonitoringPengeluaranController;
use App\Http\Controllers\Pengeluaran\KategoriPengeluaranController;

Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/me', [LoginController::class, 'me']);

Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout']);
        Route::get('/me', [LoginController::class, 'me']);

        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::post('/kontrak', [KontrakController::class, 'createKontrak']);
    Route::post('/pembayaran', [PembayaranUmumController::class, 'createPembayaran']);

    Route::get('/monitoring-praxis', [MonitoringUmumController::class, 'indexPraxis']);
    Route::get('/monitoring-praxis/detail-kontrak/{id}', [MonitoringUmumController::class, 'showKontrak']);
    Route::get('/monitoring-praxis/pembayaran-siswa/{id}', [MonitoringUmumController::class, 'show']);

    Route::get('/monitoring-techno', [MonitoringUmumController::class, 'indexTechno']);
    Route::get('/monitoring-techno/detail-kontrak/{id}', [MonitoringUmumController::class, 'showKontrak']);
    Route::get('/monitoring-techno/pembayaran-siswa/{id}', [MonitoringUmumController::class, 'show']);


    Route::post('/create/siswa/boarding', [TambahSiswaBoardingKonsumsiController::class, 'createSiswaBoarding']);
    Route::post('/create/siswa/konsumsi', [TambahSiswaBoardingKonsumsiController::class, 'createSiswaKonsumsi']);
    Route::get('/monitoring/bk', [MonitoringBKController::class, 'index']);
    Route::get('/monitoring/bk/pembayaran-siswa/{id}', [MonitoringBKController::class, 'show']);
    Route::post('/pembayaran/bk', [PembayaranBKController::class, 'createPembayaran']);
    Route::get('/monitoring/bk/detail-pembayaran/{id}', [MonitoringBKController::class, 'showPaymentHistory']); //get data pembayaran bk aja

    Route::get('/monitoring-uang-saku', [MonitoringUangSakuController::class, 'index']);
    Route::get('/monitoring-uang-saku/topup/{id}', [MonitoringUangSakuController::class, 'show']);
    Route::get('/monitoring-uang-saku/pengeluaran/{id}', [MonitoringUangSakuController::class, 'show']);
    Route::post('/monitoring-uang-saku/topup', [TopupUangSakuController::class, 'createTopup']);
    Route::post('/monitoring-uang-saku/pengeluaran', [PengeluaranUangSakuController::class, 'createPengeluaran']);
    Route::get('/monitoring-uang-saku/detail/{id}', [MonitoringUangSakuController::class, 'showUangSakuHistory']);

    Route::get('/monitoring-ekstra/ekstra', [EkstraController::class, 'index']);
    Route::post('/monitoring-ekstra/ekstra/create', [EkstraController::class, 'createEkstra']);
    Route::get('/monitoring-ekstra', [MonitoringEkstraController::class, 'index']);
    Route::post('/monitoring-ekstra/create-siswa', [TambahSiswaEkstraController::class, 'createSiswaEkstra']);
    Route::get('/ekstra/list', [EkstraController::class, 'getAllEkstra']);
    Route::get('/monitoring-ekstra/pembayaran/{id}', [MonitoringEkstraController::class, 'show']);
    Route::post('/monitoring-ekstra/pembayaran', [PembayaranEkstraController::class, 'createPembayaran']);
    Route::get('/monitoring-ekstra/detail/{id}', [MonitoringEkstraController::class, 'showPaymentHistory']);

    Route::get('/monitoring-pengeluaran', [MonitoringPengeluaranController::class, 'index']);
    Route::get('/monitoring-pengeluaran/kategori-pengeluaran', [KategoriPengeluaranController::class, 'index']);
    Route::post('/monitoring-pengeluaran/kategori-pengeluaran/create', [KategoriPengeluaranController::class, 'createKategori']);


});
