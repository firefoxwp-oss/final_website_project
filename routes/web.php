<?php

use App\Http\Controllers\SitioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SitioController::class, 'inicio'])->name('inicio');
Route::get('/legal', [SitioController::class, 'legal'])->name('legal');
Route::post('/contacto', [SitioController::class, 'contacto'])->middleware('throttle:5,1')->name('contacto');
Route::post('/agente', [SitioController::class, 'agente'])->middleware('throttle:15,1')->name('agente');
