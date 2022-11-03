<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionCollaboratorsController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\KYCsController;
use App\Http\Controllers\NftController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SubscribesController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WatchController;
use App\Http\Middleware\CheckSaleStateMiddleware;
use App\Http\Middleware\IsActiveUserMiddleware;
use App\Http\Middleware\IsAdminMiddleware;
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
Route::post('/login', [AuthController::class, 'adminLogin']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->middleware('guest')->name('password.email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');

Route::middleware([CheckSaleStateMiddleware::class])->get('/nfts', [NftController::class, 'index']);
Route::middleware([CheckSaleStateMiddleware::class])->get('/latest-nfts', [NftController::class, 'latest']);
Route::middleware([CheckSaleStateMiddleware::class])->get('/nfts/{nft}', [NftController::class, 'show']);

Route::get('/collections', [CollectionController::class, 'index']);
Route::get('/collections/{collection}', [CollectionController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/transactions', [TransactionController::class, 'index']);

Route::post('/contact', [ContactUsController::class, 'sendEmail']);
Route::post('/subscribe', [SubscribesController::class, 'store']);
Route::get('/general-statistics', [StatisticsController::class, 'general']);


Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::get('/collections/{user}', [UserController::class, 'userCollections']);
    Route::get('/owned-nfts/{user}', [UserController::class, 'ownedNfts']);
    Route::get('/created-nfts/{user}', [UserController::class, 'createdNfts']);
    Route::get('/liked-nfts/{user}', [UserController::class, 'likedNfts']);
    Route::get('/following/{user}', [UserController::class, 'following']);
    Route::get('/followers/{user}', [UserController::class, 'followers']);
    Route::get('/transactions/{user}', [UserController::class, 'userTransactions']);

});


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/my-profile', [AuthController::class, 'update']);
    Route::get('/me', [AuthController::class, 'IsLoggedIn']);
    Route::get('/my-collections', [CollectionController::class, 'myCollections']);


    Route::middleware([IsActiveUserMiddleware::class])->post('users/report/{user}', [ReportController::class, 'user_report']);
    Route::middleware([IsActiveUserMiddleware::class])->post('users/toggle-follow/{user}', [UserController::class, 'toggleFollow']);


    Route::prefix('nfts')->middleware([IsActiveUserMiddleware::class])->group(function () {
        Route::post('/', [NftController::class, 'store']);
        Route::put('/update-price/{nft}', [NftController::class, 'updatePrice']);
        Route::post('/buy/{nft}', [NftController::class, 'buyNft']);
        Route::post('/toggle-like/{nft}', [NftController::class, 'toggleLike']);
        Route::post('/report/{nft}', [ReportController::class, 'nft_report']);
        Route::put('/sale/{nft}', [NftController::class, 'setForSale']);
        Route::put('/stop-sale/{nft}', [NftController::class, 'stopSale']);
        Route::delete('/burn/{nft}', [NftController::class, 'destroy']);
    });

    Route::post('nfts/watch', [WatchController::class, 'store']);


    Route::prefix('collections')->middleware([IsActiveUserMiddleware::class])->group(function () {
        Route::post('/', [CollectionController::class, 'store']);
        Route::put('/{collection}', [CollectionController::class, 'update']);
        Route::post('/report/{collection}', [ReportController::class, 'collection_report']);
        Route::post('/add-collaboration/{collection}', [CollectionCollaboratorsController::class, 'store']);
        Route::delete('/delete-collaborator', [CollectionCollaboratorsController::class, 'destroy']);
    });

    Route::prefix('collections-collaborators')->middleware([IsActiveUserMiddleware::class])->group(function () {
        Route::post('/', [CollectionCollaboratorsController::class, 'store']);
        Route::delete('/{collaboration}', [CollectionCollaboratorsController::class, 'destroy']);
    });


    Route::prefix('kyc')->middleware([IsActiveUserMiddleware::class])->group(function () {
        Route::post('/', [KYCsController::class, 'store']);
        Route::put('/{kyc}', [KYCsController::class, 'update']);
    });


    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationsController::class, 'index']);
        Route::put('/mark-all-as-read', [NotificationsController::class, 'markAllAsRead']);
        Route::put('/{id}', [NotificationsController::class, 'markAsRead']);
    });


    Route::middleware([IsAdminMiddleware::class])->group(function () {
        Route::post('/create-admin', [AuthController::class, 'createAdmin']);
        Route::put('/update-password', [AuthController::class, 'updateAdminPassword']);

        Route::prefix('subscribers')->group(function () {
            Route::get('/', [SubscribesController::class, 'index']);
            Route::post('/send-email', [SubscribesController::class, 'sendEmail']);
        });


        Route::prefix('categories')->group(function () {
            Route::post('/', [CategoryController::class, 'store']);
            Route::get('/{category}', [CategoryController::class, 'show']);
            Route::put('/{category}', [CategoryController::class, 'update']);
        });

        Route::prefix('transactions')->group(function () {
            Route::get('/{transaction}', [TransactionController::class, 'show']);
        });

        Route::prefix('kyc')->group(function () {
            Route::get('/', [KYCsController::class, 'index']);
            Route::put('/change-account-status/{kyc}', [KYCsController::class, 'changeAccountStatus']);
        });

        Route::prefix('users')->group(function () {
            Route::post('/toggle-status/{user}', [UserController::class, 'toggleStatus']);

        });

        Route::prefix('reports')->group(function () {
            Route::get('/', [ReportController::class, 'index']);
        });

        Route::prefix('nfts')->group(function () {
            Route::put('/change-status/{nft}', [NftController::class, 'changeNFTStatus']);
        });

        Route::prefix('collections-collaborators')->group(function () {
            Route::get('/', [CollectionCollaboratorsController::class, 'index']);
            Route::get('/{collaboration}', [CollectionCollaboratorsController::class, 'show']);
        });


        Route::prefix('statistics')->group(function () {
            Route::get('/categories-nfts', [StatisticsController::class, 'categoriesNfts']);
            Route::get('/transactions', [StatisticsController::class, 'transactions']);
            Route::get('/kyc', [StatisticsController::class, 'kyc']);
        });

    });


});
