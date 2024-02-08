<?php

use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\DepartemenController;
use App\Http\Controllers\Api\LokasiController;
use App\Http\Controllers\Api\PermintaanController;
use App\Http\Controllers\Api\DetailPermintaanController;
use App\Http\Controllers\Api\StaffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::prefix('permintaans')->group(function () {
        Route::get('/', [PermintaanController::class, 'index']);
        Route::get('/{id}', [PermintaanController::class, 'show']);
        Route::post('/', [PermintaanController::class, 'store']);
        Route::delete('/', [PermintaanController::class, 'destroy']);
        //Route::put('/{id}', [PermintaanController::class, 'update']);
    });

    
    Route::prefix('details')->group(function () {
        Route::get('/', [DetailPermintaanController::class, 'index']);
    });

    Route::prefix('staff')->group(function () {
        Route::get('/', [StaffController::class, 'index']);
    });
    Route::prefix('lokasi')->group(function () {
        Route::get('/', [LokasiController::class, 'index']);
    });
    Route::prefix('departemen')->group(function () {
        Route::get('/', [DepartemenController::class, 'index']);
    });
    Route::prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index']);
    });
});