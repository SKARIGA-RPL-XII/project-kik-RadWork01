<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\MapelController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelGuruController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('jwt')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

});

Route::middleware('jwt')->group(function () {

    // ========== ADMIN ==========
    // USER
    Route::middleware('role:admin')->prefix('user')->group(function () {
        Route::post('/create', [UserController::class, 'store']);
        Route::get('/get-all', [UserController::class, 'index']);
        Route::get('/get-all/{id}', [UserController::class, 'show']);
        Route::put('/update/{id}', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);
    });

    // SISWA
    Route::middleware('role:admin')->prefix('siswa')->group(function () {
        Route::post('/create', [SiswaController::class, 'store']);
        Route::get('/get-all', [SiswaController::class, 'index']);
        Route::get('/get-all/{id}', [SiswaController::class, 'show']);
        Route::put('/update/{id}', [SiswaController::class, 'update']);
        Route::delete('/delete/{id}', [SiswaController::class, 'destroy']);
    });

    // GURU
    Route::middleware('role:admin')->prefix('guru')->group(function () {
        Route::post('/create', [GuruController::class, 'store']);
        Route::get('/get-all', [GuruController::class, 'index']);
        Route::get('/get-all/{id}', [GuruController::class, 'show']);
        Route::put('/update/{id}', [GuruController::class, 'update']);
        Route::delete('/delete/{id}', [GuruController::class, 'destroy']);
    });

    // KELAS
    Route::middleware('role:admin')->prefix('kelas')->group(function () {
        Route::post('/create', [KelasController::class, 'store']);
        Route::get('/get-all', [KelasController::class, 'index']);
        Route::get('/get-all/{id}', [KelasController::class, 'show']);
        Route::put('/update/{id}', [KelasController::class, 'update']);
        Route::delete('/delete/{id}', [KelasController::class, 'destroy']);
    });

    // MAPEL
    Route::middleware('role:admin')->prefix('mapel')->group(function () {
        Route::post('/create', [MapelController::class, 'store']);
        Route::get('/get-all', [MapelController::class, 'index']);
        Route::get('/get-all/{id}', [MapelController::class, 'show']);
        Route::put('/update/{id}', [MapelController::class, 'update']);
        Route::delete('/delete/{id}', [MapelController::class, 'destroy']);
    });

    // MAPEL GURU
    Route::middleware('role:admin')->prefix('mapel-guru')->group(function () {
        Route::post('/create', [MapelGuruController::class, 'store']);
        Route::get('/get-all', [MapelGuruController::class, 'index']);
        Route::get('/get-all/{id}', [MapelGuruController::class, 'show']);
        Route::put('/update/{id}', [MapelGuruController::class, 'update']);
        Route::delete('/delete/{id}', [MapelGuruController::class, 'destroy']);
    });
    









    // GURU
    Route::middleware('role:guru')->prefix('guru')->group(function () {
        Route::get('/test', fn() => 'Guru OK');
    });

    // SISWA
    Route::middleware('role:siswa')->prefix('siswa')->group(function () {
        Route::get('/test', fn() => 'Siswa OK');
    });

});

