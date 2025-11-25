<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapaController; // O un controlador API dedicado
use App\Models\Cafe;

// Ruta para obtener los datos de las cafeterías
Route::get('/cafes', [MapaController::class, 'getCafesApi'])
    ->name('api.cafes');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
