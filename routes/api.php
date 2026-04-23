<?php

use App\Http\Controllers\Api\ContractController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes protégées de l'API Phase 2 (Sécurisées par JWT Sanctum et Rate Limiting)
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::apiResource('contracts', ContractController::class);
    Route::get('contracts/{contract}/consumptions', [ContractController::class, 'consumptions']);
});
