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
    Route::post('/monitoring-uang-saku/topup', [PengeluaranUangSakuController::class, 'createPengeluaran']);
});
