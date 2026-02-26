<?php

use App\Http\Controllers\Api\ApiCategoryController;
use App\Http\Controllers\Api\ApiPostController;
use App\Http\Controllers\Api\CommandController;
use Illuminate\Support\Facades\Route;

// Public API Routes - with rate limiting
Route::middleware('throttle:posts')->group(function () {
    Route::apiResource('/posts', ApiPostController::class, ['only' => ['index', 'show']]);
    Route::apiResource('/categories', ApiCategoryController::class, ['only' => ['index', 'show']]);
});

// Command execution endpoint - RESTRICTED
// Only accessible in debug mode and with specific whitelisted commands
Route::middleware(['throttle:60,1', 'DebugModeOnly'])->group(function () {
    Route::get('/run-command', [CommandController::class, 'runCommand'])->name('run-command');
});
