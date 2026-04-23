<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContractController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes protégées de l'API Phase 2 (Sécurisées par JWT Sanctum et Rate Limiting)
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::apiResource('contracts', ContractController::class);
    Route::get('contracts/{contract}/consumptions', [ContractController::class, 'consumptions']);
});
