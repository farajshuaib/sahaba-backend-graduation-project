<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\KYCsController;
use App\Http\Controllers\NftController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubscribesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WatchController;
use App\Http\Middleware\CheckSaleStateMiddleware;
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

Route::middleware([CheckSaleStateMiddleware::class])->get('/nfts', [NftController::class, 'index']);
Route::middleware([CheckSaleStateMiddleware::class])->get('/latest-nfts', [NftController::class, 'latest']);
Route::middleware([CheckSaleStateMiddleware::class])->get('/nfts/{nft}', [NftController::class, 'show']);

Route::get('/collections', [CollectionController::class, 'index']);
Route::get('/collections/{collection}', [CollectionController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);


Route::post('/contact', [ContactUsController::class, 'sendEmail']);
Route::post('/subscribe', [SubscribesController::class, 'store']);


Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::get('/collections/{user}', [UserController::class, 'userCollections']);
    Route::get('/owned-nfts/{user}', [UserController::class, 'ownedNfts']);
    Route::get('/created-nfts/{user}', [UserController::class, 'createdNfts']);
    Route::get('/liked-nfts/{user}', [UserController::class, 'likedNfts']);
    Route::get('/following/{user}', [UserController::class, 'following']);
    Route::get('/followers/{user}', [UserController::class, 'followers']);

});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/my-profile', [AuthController::class, 'update']);
    Route::get('/my-collections', [CollectionController::class, 'myCollections']);
    Route::get('/subscribed', [SubscribesController::class, 'index']);


    Route::post('users/report/{user}', [ReportController::class, 'user_report']);
    Route::post('users/toggle-follow/{user}', [UserController::class, 'toggleFollow']);


    Route::prefix('nfts')->group(function () {
        Route::post('/', [NftController::class, 'store']);
        Route::put('/update-price/{nft}', [NftController::class, 'updatePrice']);
        Route::post('/buy/{nft}', [NftController::class, 'buyNft']);
        Route::post('/toggle-like/{nft}', [NftController::class, 'toggleLike']);
        Route::post('/report/{nft}', [ReportController::class, 'nft_report']);
        Route::put('/sale/{nft}', [NftController::class, 'setForSale']);
        Route::put('/stop-sale/{nft}', [NftController::class, 'stopSale']);
        Route::post('/watch', [WatchController::class, 'store']);
    });


    Route::prefix('collections')->group(function () {
        Route::post('/', [CollectionController::class, 'store']);
        Route::put('/{collection}', [CollectionController::class, 'update']);
        Route::delete('/{collection}', [CollectionController::class, 'destroy']);
        Route::post('/add-collaboration/{collection}', [CollectionController::class, 'addCollaboration']);
        Route::post('/report/{collection}', [ReportController::class, 'collection_report']);
    });


    Route::prefix('categories')->group(function () {
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::delete('/{category}', [CategoryController::class, 'destroy']);
    });

    Route::prefix('kyc')->group(function () {
        Route::get('/', [KYCsController::class, 'store']);
        Route::post('/', [KYCsController::class, 'store']);
        Route::put('/{kyc}', [KYCsController::class, 'update']);
    });


});
