<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

// Rota de Login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Rota de Registro
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Logout
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Rota para inscrição em evento
Route::middleware('auth:sanctum')->post('/event/{id}/subscribe', [EventController::class, 'subscribe']);

// Rota para cancelar inscrição em evento
Route::middleware('auth:sanctum')->post('/event/{id}/unsubscribe', [EventController::class, 'unsubscribe']);

// Evento criado pelo usuário logado
Route::middleware('auth:sanctum')->get('/my-events', [EventController::class, 'MyEvents']);

// Evento no qual o usuário está inscrito
Route::middleware('auth:sanctum')->get('/subscribed-event', [EventController::class, 'subscribedEvents']);

// Rotas protegidas com autenticação (necessário token)
Route::middleware('auth:sanctum')->group(function () {
    // Evento disponível para inscrição
    Route::get('/available-event', [EventController::class, 'availableEvents']);
    
    // Outras rotas para eventos
    Route::apiResource('event', EventController::class);
});

