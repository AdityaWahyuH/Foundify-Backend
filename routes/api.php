<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangHilangController;
use App\Http\Controllers\Api\BarangDitemukanController;
use App\Http\Controllers\Api\KlaimController;
use App\Http\Controllers\Api\PoinController;
use App\Http\Controllers\Api\KatalogRewardController;
use App\Http\Controllers\Api\TukarPoinController;

/*
|--------------------------------------------------------------------------
| API Routes - Foundify
|--------------------------------------------------------------------------
*/

// =============================================
// PUBLIC ROUTES (Tidak perlu login)
// =============================================

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
});

// Public: Lihat daftar barang (tanpa login)
Route::get('/barang-hilang', [BarangHilangController::class, 'index']);
Route::get('/barang-hilang/{id}', [BarangHilangController::class, 'show']);
Route::get('/barang-ditemukan', [BarangDitemukanController::class, 'index']);
Route::get('/barang-ditemukan/{id}', [BarangDitemukanController::class, 'show']);

// Public: Lihat katalog reward
Route::get('/katalog-reward', [KatalogRewardController::class, 'index']);
Route::get('/katalog-reward/{id}', [KatalogRewardController::class, 'show']);


// =============================================
// PROTECTED ROUTES (Perlu login - JWT)
// =============================================

Route::middleware('auth:api')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
    });

    // Barang Hilang
    Route::post('/barang-hilang', [BarangHilangController::class, 'store']);
    Route::put('/barang-hilang/{id}', [BarangHilangController::class, 'update']);
    Route::delete('/barang-hilang/{id}', [BarangHilangController::class, 'destroy']);
    Route::get('/my-barang-hilang', [BarangHilangController::class, 'myItems']);

    // Barang Ditemukan (Admin)
    Route::post('/barang-ditemukan', [BarangDitemukanController::class, 'store']);
    Route::put('/barang-ditemukan/{id}', [BarangDitemukanController::class, 'update']);
    Route::delete('/barang-ditemukan/{id}', [BarangDitemukanController::class, 'destroy']);

    // Klaim
    Route::get('/klaim', [KlaimController::class, 'index']);
    Route::post('/klaim', [KlaimController::class, 'store']);
    Route::get('/klaim/{id}', [KlaimController::class, 'show']);
    Route::put('/klaim/{id}/verify', [KlaimController::class, 'verify']);
    Route::get('/my-klaim', [KlaimController::class, 'myKlaims']);

    // Poin
    Route::get('/poin', [PoinController::class, 'index']);
    Route::get('/poin/riwayat', [PoinController::class, 'riwayat']);

    // Katalog Reward (Admin CRUD)
    Route::post('/katalog-reward', [KatalogRewardController::class, 'store']);
    Route::put('/katalog-reward/{id}', [KatalogRewardController::class, 'update']);
    Route::delete('/katalog-reward/{id}', [KatalogRewardController::class, 'destroy']);

    // Tukar Poin
    Route::get('/tukar-poin', [TukarPoinController::class, 'index']);
    Route::post('/tukar-poin', [TukarPoinController::class, 'store']);
    Route::get('/tukar-poin/riwayat', [TukarPoinController::class, 'riwayat']);
    Route::get('/tukar-poin/{id}', [TukarPoinController::class, 'show']);
    Route::put('/tukar-poin/{id}/verify', [TukarPoinController::class, 'verify']);
});
