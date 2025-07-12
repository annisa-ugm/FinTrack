<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Siswa\KontrakController;
use App\Http\Controllers\Siswa\SiswaController;
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
use App\Http\Controllers\Pengeluaran\TambahPengeluaranController;
use App\Http\Controllers\Pengeluaran\UpdatePengeluaranController;
use App\Http\Controllers\Tagihan\TagihanController;
use App\Http\Controllers\Tunggakan\TunggakanController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

// Route::post('/login', [LoginController::class, 'login']);
// Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);
// Route::middleware('auth:sanctum')->get('/me', [LoginController::class, 'me']);

// Route::prefix('auth')->group(function () {
//     Route::post('/login', [LoginController::class, 'login']);

//     Route::middleware('auth:sanctum')->group(function () {
//         Route::post('/logout', [LoginController::class, 'logout']);
//         Route::get('/me', [LoginController::class, 'me']);

//         Route::get('/dashboard', [DashboardController::class, 'index']);
//     });
// });

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

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index']);

//     Route::get('/cari-siswa', [SiswaController::class, 'searchSiswa']);
//     Route::post('/kontrak', [KontrakController::class, 'createKontrak']);
//     Route::post('/pembayaran', [PembayaranUmumController::class, 'createPembayaran']);

//     Route::get('/monitoring-praxis', [MonitoringUmumController::class, 'indexPraxis']);
//     Route::get('/monitoring-praxis/detail-kontrak/{id}', [MonitoringUmumController::class, 'showKontrak']);
//     Route::get('/monitoring-praxis/pembayaran-siswa/{id}', [MonitoringUmumController::class, 'show']);

//     Route::get('/monitoring-techno', [MonitoringUmumController::class, 'indexTechno']);
//     Route::get('/monitoring-techno/detail-kontrak/{id}', [MonitoringUmumController::class, 'showKontrak']);
//     Route::get('/monitoring-techno/pembayaran-siswa/{id}', [MonitoringUmumController::class, 'show']);


//     Route::post('/create/siswa/boarding', [TambahSiswaBoardingKonsumsiController::class, 'createSiswaBoarding']);
//     Route::post('/create/siswa/konsumsi', [TambahSiswaBoardingKonsumsiController::class, 'createSiswaKonsumsi']);
//     Route::get('/monitoring/bk', [MonitoringBKController::class, 'index']);
//     Route::get('/monitoring/bk/pembayaran-siswa/{id}', [MonitoringBKController::class, 'show']);
//     Route::post('/pembayaran/bk', [PembayaranBKController::class, 'createPembayaran']);
//     Route::get('/monitoring/bk/detail-pembayaran/{id}', [MonitoringBKController::class, 'showPaymentHistory']); //get data pembayaran bk aja

//     Route::get('/monitoring-uang-saku', [MonitoringUangSakuController::class, 'index']);
//     Route::get('/monitoring-uang-saku/topup/{id}', [MonitoringUangSakuController::class, 'show']);
//     Route::get('/monitoring-uang-saku/pengeluaran/{id}', [MonitoringUangSakuController::class, 'show']);
//     Route::post('/monitoring-uang-saku/topup', [TopupUangSakuController::class, 'createTopup']);
//     Route::post('/monitoring-uang-saku/pengeluaran', [PengeluaranUangSakuController::class, 'createPengeluaran']);
//     Route::get('/monitoring-uang-saku/detail/{id}', [MonitoringUangSakuController::class, 'showUangSakuHistory']);

//     Route::get('/monitoring-ekstra/ekstra', [EkstraController::class, 'index']);
//     Route::post('/monitoring-ekstra/ekstra/create', [EkstraController::class, 'createEkstra']);
//     Route::get('/monitoring-ekstra', [MonitoringEkstraController::class, 'index']);
//     Route::post('/monitoring-ekstra/create-siswa', [TambahSiswaEkstraController::class, 'createSiswaEkstra']);
//     Route::get('/ekstra/list', [EkstraController::class, 'getAllEkstra']);
//     Route::get('/monitoring-ekstra/pembayaran/{id}', [MonitoringEkstraController::class, 'show']);
//     Route::post('/monitoring-ekstra/pembayaran', [PembayaranEkstraController::class, 'createPembayaran']);
//     Route::get('/monitoring-ekstra/detail/{id}', [MonitoringEkstraController::class, 'showPaymentHistory']);

//     Route::get('/monitoring-pengeluaran', [MonitoringPengeluaranController::class, 'index']);
//     Route::get('/monitoring-pengeluaran/kategori-pengeluaran', [KategoriPengeluaranController::class, 'index']);
//     Route::post('/monitoring-pengeluaran/kategori-pengeluaran/create', [KategoriPengeluaranController::class, 'createKategori']);
//     Route::post('/monitoring-pengeluaran/create', [TambahPengeluaranController::class, 'createPengeluaran']);
//     Route::get('/monitoring-pengeluaran/detail/{id}', [MonitoringPengeluaranController::class, 'detailPengeluaran']);
//     Route::put('/monitoring-pengeluaran/pengeluaran/update/{id}', [UpdatePengeluaranController::class, 'updatePengeluaran']);
//     Route::post('/monitoring-pengeluaran/sub-pengeluaran/update/{id}', [UpdatePengeluaranController::class, 'updateSubPengeluaran']);
//     Route::delete('/monitoring-pengeluaran/sub-pengeluaran/delete/{id}', [UpdatePengeluaranController::class, 'deleteSubPengeluaran']);

//     Route::get('/tagihan', [TagihanController::class, 'indexTagihan']);
//     Route::get('/tagihan/{nisn}', [TagihanController::class, 'detailTagihan']);
//     Route::post('/tagihan/create', [TagihanController::class, 'createTagihan']);

// });

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
        // Update status tunggakan
        Route::put('/update-status/{id}', [TunggakanController::class, 'updateStatus']);
    });


});
