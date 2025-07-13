<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Siswa\KontrakController;
use App\Http\Controllers\Siswa\SiswaController;
use App\Http\Controllers\Siswa\SiswaTechnoController;
use App\Http\Controllers\Umum\MonitoringUmumController;
use App\Http\Controllers\Umum\PembayaranUmumController;
use App\Http\Controllers\BoardingKonsumsi\TambahSiswaBoardingKonsumsiController;
use App\Http\Controllers\BoardingKonsumsi\MonitoringBKController;
use App\Http\Controllers\BoardingKonsumsi\PembayaranBKController;
use App\Http\Controllers\BoardingKonsumsi\UpdateBKController;
use App\Http\Controllers\UangSaku\MonitoringUangSakuController;
use App\Http\Controllers\UangSaku\TopupUangSakuController;
use App\Http\Controllers\UangSaku\PengeluaranUangSakuController;
use App\Http\Controllers\Ekstra\EkstraController;
use App\Http\Controllers\Ekstra\MonitoringEkstraController;
use App\Http\Controllers\Ekstra\TambahSiswaEkstraController;
use App\Http\Controllers\Ekstra\PembayaranEkstraController;
use App\Http\Controllers\Ekstra\UpdateSiswaEkstraController;
use App\Http\Controllers\Pengeluaran\MonitoringPengeluaranController;
use App\Http\Controllers\Pengeluaran\KategoriPengeluaranController;
use App\Http\Controllers\Pengeluaran\TambahPengeluaranController;
use App\Http\Controllers\Pengeluaran\UpdatePengeluaranController;
use App\Http\Controllers\Tagihan\TagihanController;
use App\Http\Controllers\Tunggakan\TunggakanController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

/**
 * Authentication Routes
 */
Route::prefix('auth')->group(function () {
    // Login user
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        // Logout user
        Route::post('/logout', [LoginController::class, 'logout']);

        // Get current authenticated user
        Route::get('/users', [LoginController::class, 'users']);
    });
});

/**
 * Routes that require authentication
 */
Route::middleware('auth:sanctum')->group(function () {
    /**
     * Dashboard
     */
    Route::get('/dashboard', [DashboardController::class, 'index']);

    /**
     * Siswa & Kontrak
     */
    // Search siswa by keyword
    Route::get('/cari-siswa', [SiswaController::class, 'searchSiswa']);

    // Create new kontrak
    Route::post('/kontrak', [KontrakController::class, 'createKontrak']);

    /**
     * Siswa Techno
     */
    Route::prefix('techno/siswa')->group(function () {
        Route::get('/', [SiswaTechnoController::class, 'index']);
        Route::post('/create', [SiswaTechnoController::class, 'store']);
        Route::get('/detail/{id}', [SiswaTechnoController::class, 'show']);
        Route::put('/update/{id}', [SiswaTechnoController::class, 'update']);
        Route::delete('/delete/{id}', [SiswaTechnoController::class, 'destroy']);
    });


    /**
     * Pembayaran Umum
     */
    // Create umum pembayaran
    Route::post('/pembayaran', [PembayaranUmumController::class, 'createPembayaran']);

    /**
     * Monitoring Umum
     */
    Route::prefix('/monitoring-praxis')->group(function () {
        // Get all siswa in praxis
        Route::get('/', [MonitoringUmumController::class, 'indexPraxis']);
        // Show kontrak detail
        Route::get('/detail-kontrak/{id}', [MonitoringUmumController::class, 'showKontrak']);
        // Show pembayaran detail for siswa
        Route::get('/pembayaran-siswa/{id}', [MonitoringUmumController::class, 'show']);
    });


    Route::prefix('/monitoring-techno')->group(function () {
        // Get all siswa in techno
        Route::get('/', [MonitoringUmumController::class, 'indexTechno']);
        // Show kontrak detail
        Route::get('/detail-kontrak/{id}', [MonitoringUmumController::class, 'showKontrak']);
        // Show pembayaran detail for siswa
        Route::get('/pembayaran-siswa/{id}', [MonitoringUmumController::class, 'show']);
    });

    /**
     * Boarding Konsumsi
     */
    Route::prefix('/monitoring-bk')->group(function () {
        // Get list siswa boarding konsumsi
        Route::get('/', [MonitoringBKController::class, 'index']);
        // Get pembayaran siswa BK
        Route::get('/pembayaran-siswa/{id}', [MonitoringBKController::class, 'show']);
        // Get riwayat pembayaran siswa BK
        Route::get('/detail-pembayaran/{id}', [MonitoringBKController::class, 'showPaymentHistory']);
        // Buat pembayaran boarding konsumsi
        Route::post('/pembayaran', [PembayaranBKController::class, 'createPembayaran']);
        // Create new siswa boarding
        Route::post('/create-siswa/boarding', [TambahSiswaBoardingKonsumsiController::class, 'createSiswaBoarding']);
        // Create new siswa konsumsi
        Route::post('/create-siswa/konsumsi', [TambahSiswaBoardingKonsumsiController::class, 'createSiswaKonsumsi']);
        // Show detail siswa boarding konsumsi
        Route::get('/detail/{id}', [UpdateBKController::class, 'show']);
        // Update siswa boarding konsumsi
        Route::put('/update/{id}', [UpdateBKController::class, 'update']);
    });


    /**
     * Uang Saku
     */
    Route::prefix('/monitoring-uang-saku')->group(function () {
        // Get all siswa uang saku
        Route::get('/', [MonitoringUangSakuController::class, 'index']);
        // Show topup data
        Route::get('/topup/{id}', [MonitoringUangSakuController::class, 'show']);
        // Show pengeluaran data
        Route::get('/pengeluaran/{id}', [MonitoringUangSakuController::class, 'show']);
        // Create topup uang saku
        Route::post('/topup', [TopupUangSakuController::class, 'createTopup']);
        // Create pengeluaran uang saku
        Route::post('/pengeluaran', [PengeluaranUangSakuController::class, 'createPengeluaran']);
        // Show detail uang saku history
        Route::get('/detail/{id}', [MonitoringUangSakuController::class, 'showUangSakuHistory']);
    });

    /**
     * Ekstra
     */
    Route::prefix('/monitoring-ekstra')->group(function () {
        // Get monitoring data for ekstra
        Route::get('/', [MonitoringEkstraController::class, 'index']);
        // Create new siswa ekstra
        Route::post('/create-siswa', [TambahSiswaEkstraController::class, 'createSiswaEkstra']);
        // Get pembayaran siswa
        Route::get('/pembayaran/{id}', [MonitoringEkstraController::class, 'show']);
        // Buat pembayaran ekstra
        Route::post('/pembayaran', [PembayaranEkstraController::class, 'createPembayaran']);
        // Show detail pembayaran history
        Route::get('/detail/{id}', [MonitoringEkstraController::class, 'showPaymentHistory']);
        // Show detail ekstra siswa untuk form update
        Route::get('/detail/ekstra-siswa/{id}', [UpdateSiswaEkstraController::class, 'detail']);
        // Update ekstra siswa
        Route::put('/update/{id}', [UpdateSiswaEkstraController::class, 'update']);

        /**
         * Master Data Ekstra
         */
        Route::prefix('/ekstra')->group(function () {
            // Get monitoring master data for ekstra
            Route::get('/', [EkstraController::class, 'index']);
            // Create new ekstra
            Route::post('/create', [EkstraController::class, 'createEkstra']);
        });
    });

    // List Ekstra
    Route::get('/ekstra/list', [EkstraController::class, 'getAllEkstra']);

    /**
     * Pengeluaran
     */
    Route::prefix('/monitoring-pengeluaran')->group(function () {
        // Get list pengeluaran
        Route::get('/', [MonitoringPengeluaranController::class, 'index']);
        // Get list kategori pengeluaran
        Route::get('/kategori-pengeluaran', [KategoriPengeluaranController::class, 'index']);
        // Create kategori pengeluaran baru
        Route::post('/kategori-pengeluaran/create', [KategoriPengeluaranController::class, 'createKategori']);
        // Tambah pengeluaran baru
        Route::post('/create', [TambahPengeluaranController::class, 'createPengeluaran']);
        // Show detail pengeluaran
        Route::get('/detail/{id}', [MonitoringPengeluaranController::class, 'detailPengeluaran']);
        // Update pengeluaran utama
        Route::put('/pengeluaran/update/{id}', [UpdatePengeluaranController::class, 'updatePengeluaran']);
        // Create sub pengeluaran di detail pengeluaran
        Route::post('/pengeluaran/{id}/sub-pengeluaran', [UpdatePengeluaranController::class, 'storeSubPengeluaran']);
        // Update sub pengeluaran
        Route::post('/sub-pengeluaran/update/{id}', [UpdatePengeluaranController::class, 'updateSubPengeluaran']);
        // Delete sub pengeluaran
        Route::delete('/sub-pengeluaran/delete/{id}', [UpdatePengeluaranController::class, 'deleteSubPengeluaran']);
    });

    /**
     * Tagihan
     */
    Route::prefix('/tagihan')->group(function () {
        // Get all tagihan
        Route::get('/', [TagihanController::class, 'indexTagihan']);
        // Get detail tagihan by NISN
        Route::get('/{nisn}', [TagihanController::class, 'detailTagihan']);
        // Create tagihan baru
        Route::post('/create', [TagihanController::class, 'createTagihan']);
    });


    /**
     * Tunggakan
     */
    Route::prefix('/tunggakan')->group(function () {
        // Get all tunggakan
        Route::get('/', [TunggakanController::class, 'index']);
        // Create new tunggakan
        Route::post('/create', [TunggakanController::class, 'store']);
        // Show detail tunggakan by ID
        Route::get('/detail/{id}', [TunggakanController::class, 'show']);
        // Update tunggakan
        Route::put('/update/{id}', [TunggakanController::class, 'update']);
        // Delete tunggakan
        Route::delete('/delete/{id}', [TunggakanController::class, 'destroy']);
    });


});

