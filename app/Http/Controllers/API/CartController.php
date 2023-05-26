<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Track;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class CartController extends Controller
{
    public function getCartData()
    {
        $user = JWTAuth::user();
        if ($user === null) {
            return response(['error' => 'please sign in, your token has expired'], 401);
        }
        return response([new CartResource($user->cart)], 200);

    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'track_id' => 'required',
            'license_id' => 'required',

        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()
            ], 200);
        }

        $user = JWTAuth::user();
        if ($user === null) {
            return response(['error' => 'please sign in, your token has expired'], 401);
        }
        $cart = $user->cart;
        $cartItem = new CartItem;
        // TODO:refactor cycle
        $track = Track::findorFail($request->track_id);

        $license = $request->input('license_id', '1');
        $cartItem->track_id = $request->track_id;
        $cartItem->license_id = $request->license_id;
        $cartItem->item_price = $track->getPrice($license);
        $cart->cartItems()->save($cartItem);
        $cart->total_price = $cart->total_price + $cartItem->item_price;
        $cart->save();
        return response([new CartResource($cart)], 200);

    }

    public function updateCartItem(Request $request, CartItem $cartItem)
    {
        if ($cartItem->license_id === $request->license_id) {
            return response()->json(['error' => 'nothing to update', 'status' => 422], 422);
        }
        try {
            $cartItem->license_id = $request->license_id;
            $cartItem->item_price = $cartItem->track->getPrice($request->license_id);
            $cartItem->save();
        } catch (QueryException $exception) {
            return response()->json(['error' => 'cannot use a non existing license', 'status' => 422], 422);
        }
        return response([$cartItem], 200);
    }

    public function clearCart()
    {
        $user = JWTAuth::user();
        if ($user === null) {
            return response(['error' => 'please sign in, your token has expired'], 401);
        }
        try {
            $cart = $user->cart;
            $cart->total_price = 0;
            $cart->cartItems()->delete();
            $cart->save();
        }
        catch (QueryException $exception){
            return response()->json(['error' => 'your cart is already empty', 'status' => 422], 422);

        }
        return response([new CartResource($cart)], 200);

    }

    public function removeFromCart(CartItem $cartItem)
    {
        $user = JWTAuth::user();
        if ($user === null) {
            return response(['error' => 'please sign in, your token has expired'], 401);
        }
        try {
            $user->cart->total_price = $user->cart->total_price - $cartItem->item_price;
            $cartItem->delete();
            $user->cart->save();
            $user->save();
        }
        catch (QueryException $exception){
            return response()->json(['error' => 'this item is not in your cart', 'status' => 422], 422);
        }

        return response([new CartResource($user->cart)], 200);

    }

    public function index()
    {
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Cart $cart)
    {
        //
    }

    public function edit(Cart $cart)
    {
        //
    }

    public function update(Request $request, Cart $cart)
    {
        //
    }


    public function destroy(Cart $cart)
    {
        //
    }
}
