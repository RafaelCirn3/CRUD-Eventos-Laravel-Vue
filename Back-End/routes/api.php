<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;

// Rota de Login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Rota de Registro
Route::post('/register', [AuthController::class, 'register'])->name('register');
// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('events', EventController::class);
});
