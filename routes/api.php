<?php

use App\Http\Controllers\API\Users\{SupportController};
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('supports', SupportController::class);
});
