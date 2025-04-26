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
    Route::get('/monitoring', [MonitoringUmumController::class, 'index']);
    Route::get('/monitoring/detail-kontrak/{id}', [MonitoringUmumController::class, 'showKontrak']);
    Route::get('/monitoring/pembayaran-siswa/{id}', [MonitoringUmumController::class, 'show']);
    Route::post('/pembayaran', [PembayaranUmumController::class, 'createPembayaran']);
    Route::post('/create/siswa/boarding', [TambahSiswaBoardingKonsumsiController::class, 'createSiswaBoarding']);
    Route::post('/create/siswa/konsumsi', [TambahSiswaBoardingKonsumsiController::class, 'createSiswaKonsumsi']);
    Route::get('/monitoring/bk', [MonitoringBKController::class, 'index']);
    Route::get('/monitoring/bk/pembayaran-siswa/{id}', [MonitoringBKController::class, 'show']);
    Route::post('/pembayaran/bk', [PembayaranBKController::class, 'createPembayaran']);
});
