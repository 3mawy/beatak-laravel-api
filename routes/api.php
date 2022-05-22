<?php

use App\Http\Controllers\API\Auth\SocialAuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\FollowController;
use App\Http\Controllers\API\GenreController;
use App\Http\Controllers\API\LicenseController;
use App\Http\Controllers\API\OrderItemController;
use App\Http\Controllers\API\ProviderController;
use App\Http\Controllers\API\TrackController;
use App\Http\Controllers\API\TypeController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'api',], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
Route::get('login/{provider}', [SocialAuthController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);

Route::get('/tracks', [TrackController::class, 'index']);
Route::get('/tracks/{track}', [TrackController::class, 'show']);
Route::get('users/{user}/tracks', [TrackController::class, 'getTracksByUser']);
Route::get('genres/{genre}/tracks', [TrackController::class, 'getTracksByGenre']);

// Follow routes for registered users

Route::group(['prefix' => 'me', 'middleware' => 'auth:api',], function ($router) {
    Route::get('/followers', [FollowController::class, 'getCurrentUserFollowers']);
    Route::get('/followings', [FollowController::class, 'getCurrentUserFollowings']);
    Route::post('/followings', [FollowController::class, 'followUserById']);
    Route::delete('/followings/{following}', [FollowController::class, 'unfollowUserById']);
});

Route::get('users/{user}/followers', [FollowController::class, 'getFollowers']);
Route::get('users/{user}/followings', [FollowController::class, 'getFollowings']);

// Tracks routes for registered users
Route::group(['prefix' => 'tracks', 'middleware' => 'auth:api'], function () {
    Route::get('/me', [TrackController::class, 'getCurrentUserTracks']);
    Route::post('/', [TrackController::class, 'addToCurrentUserTracks']);
    Route::patch('/{track}', [TrackController::class, 'editTrack']);
    Route::delete('/{track}', [TrackController::class, 'removeTrack']);
});

// Cart routes for registered users
Route::group(['prefix' => 'cart', 'middleware' => 'auth:api'], function () {
    Route::get('/', [CartController::class, 'getCartData']);
    Route::post('/', [CartController::class, 'addToCart']);
    Route::patch('/{cartItem}', [CartController::class, 'updateCartItem']);
    Route::delete('/clear', [CartController::class, 'clearCart']);
    Route::delete('/remove/{cartItem}', [CartController::class, 'removeFromCart']);

});

// Order routes for registered users
Route::group(['prefix' => 'orders', 'middleware' => 'auth:api',], function () {
    Route::get('/', [OrderController::class, 'getUserOrders']);
    Route::get('/{order_id}', [OrderController::class, 'getOrderInfo']);
    Route::post('/', [OrderController::class, 'placeOrder']);
    Route::patch('/{order}', [OrderController::class, 'updateOrderData']);
    Route::delete('/{order}', [OrderController::class, 'cancelOrder']);

});

//Api Resources For Admin panel
Route::group(['prefix' => 'admin', 'middleware' => 'auth:api',], function () {
    Route::apiResource('users', UserController::class);
//    Route::apiResource('artists', ArtistController::class);
    Route::apiResource('carts', UserController::class);
    Route::apiResource('cart-items', UserController::class);
    Route::apiResource('providers', ProviderController::class);
    Route::apiResource('tracks', TrackController::class);
    Route::apiResource('genres', GenreController::class);
    Route::apiResource('types', TypeController::class);
    Route::apiResource('licenses', LicenseController::class);
//    Route::apiResource('orders', OrderController::class);
    Route::apiResource('order-items', OrderItemController::class);
    Route::apiResource('statuses', LicenseController::class);
});

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
