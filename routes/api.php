<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/connect-wallet', [AuthController::class, 'connectWallet']);
Route::get('/get-items', [ProductController::class, 'index']);
Route::get('/get-item/{product}', [ProductController::class, 'show']);

// Route::prefix('blaa')->group(function () {
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/create-item', [ProductController::class, 'store']);
    Route::put('/update-item', [ProductController::class, 'update']);
});
