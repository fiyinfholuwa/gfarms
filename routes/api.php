<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;

Route::post('/webhook/dojah', [PackageController::class, 'handleWebhook']);
Route::get('/ping', function () {
    return response()->json([
        'message' => 'API is working 🚀',
    ]);
});