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

// Rota para se inscrever em um evento
Route::middleware('auth:sanctum')->post('/events/{id}/subscribe', [EventController::class, 'subscribe']);

    
// Rota para cancelar a inscrição em um evento
Route::middleware('auth:sanctum')->post('/events/{id}/unsubscribe', [EventController::class, 'unsubscribe']);


// api.php
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('events', EventController::class);
});
