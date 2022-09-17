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
Route::get('/nft/{nft}', [NftController::class, 'show']);

Route::get('/collections', [CollectionController::class, 'index']);
Route::get('/collection/{collection}', [CollectionController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/category/{category}', [CategoryController::class, 'show']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/my-profile', [AuthController::class, 'show']);
    Route::put('/my-profile', [AuthController::class, 'update']);


    Route::prefix('nft')->group(function () {
        Route::put('/{nft}', [NftController::class, 'update']);
        Route::post('/', [NftController::class, 'store']);
        Route::get('/liked-by-me', [NftController::class, 'likedByUser']);
        Route::post('/toggle-like/{nft}', [NftController::class, 'toggleLike']);
    });


    Route::prefix('collection')->group(function () {
        Route::put('/{collection}', [CollectionController::class, 'update']);
        Route::post('/', [CollectionController::class, 'store']);
        Route::delete('/{collection}', [CollectionController::class, 'destroy']);
    });


    Route::prefix('category')->group(function () {
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::delete('/{category}', [CategoryController::class, 'destroy']);
    });


});
