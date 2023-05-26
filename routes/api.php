<?php

use App\Http\Controllers\API\Auth\SocialAuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\GenreController;
use App\Http\Controllers\API\LicenseController;
use App\Http\Controllers\API\ProviderController;
use App\Http\Controllers\API\TrackController;
use App\Http\Controllers\API\TypeController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
Route::get('login/{provider}', [SocialAuthController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);

// Cart routes for registered users
Route::group(['prefix' => 'cart', 'middleware' => 'auth:api',], function () {
    Route::get('/get', [CartController::class, 'getCartData']);
    Route::post('/add/{track}', [CartController::class, 'addToCart']);
    Route::patch('/update/{cartItem}', [CartController::class, 'updateCartData']);
    Route::delete('/clear', [CartController::class, 'clearCart']);
    Route::delete('/remove/{cartItem}', [CartController::class, 'removeFromCart']);

});

//Api Resources For Admin panel

Route::apiResource('users', UserController::class);
Route::apiResource('carts', UserController::class);
Route::apiResource('providers', ProviderController::class);
Route::apiResource('tracks', TrackController::class);
Route::apiResource('genres', GenreController::class);
Route::apiResource('types', TypeController::class);
Route::apiResource('licenses', LicenseController::class);


Route::fallback(function () {
    return response()->json([
        'error' => 'Page Not Found.'], 404);
});

//Route::group(['prefix' => 'tracks'], function () {
//    Route::get('', [TrackController::class, 'index']);
//    Route::post('', [TrackController::class, 'store']);
//    Route::get('/{track}', [TrackController::class, 'show']);
////    Route::post('/{track}/reviews', [ReviewController::class, 'store']);
//
//});

//Route::get('/genres', [GenreController::class, 'index']);
// Cart
// Route::resource('cart', CartController::class);
//Route::post('cart/add/{track_id}', [CartController::class, 'add'])->name('cart.add');
//Route::get('cart/remove/{track_id}', [CartController::class, 'remove'])->name('cart.remove');
//Route::get('clear/shopping/', [CartController::class, 'clearshoppingcart'])->name('clearshopping.cart');
//Route::post('/cart/update', [CartController::class, 'cartupdate'])->name('cart.update');
//Route::get('cart/', [CartController::class, 'cart'])->name('cart');

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
