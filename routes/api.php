<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\NftController;
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

Route::get('/nfts', [NftController::class, 'index']);
Route::get('/nfts/{nft}', [NftController::class, 'show']);

Route::get('/collections', [CollectionController::class, 'index']);
Route::get('/collections/{collection}', [CollectionController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/my-profile', [AuthController::class, 'show']);
    Route::put('/my-profile', [AuthController::class, 'update']);
    Route::get('/liked-nfts', [NftController::class, 'likedByUser']);


    Route::prefix('nfts')->group(function () {
        Route::post('/', [NftController::class, 'store']);
        Route::put('/{nft}', [NftController::class, 'update']);
        Route::get('/liked-by-me', [NftController::class, 'likedByUser']);
        Route::post('/toggle-like/{nft}', [NftController::class, 'toggleLike']);
        Route::post('/report/{nft}', [NftController::class, 'report']);
    });


    Route::prefix('collections')->group(function () {
        Route::post('/', [CollectionController::class, 'store']);
        Route::put('/{collection}', [CollectionController::class, 'update']);
        Route::delete('/{collection}', [CollectionController::class, 'destroy']);
    });


    Route::prefix('categories')->group(function () {
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::delete('/{category}', [CategoryController::class, 'destroy']);
    });


});
