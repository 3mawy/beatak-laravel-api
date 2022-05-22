<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use \Illuminate\Database\Eloquent\ModelNotFoundException;


class OrderController extends Controller
{
    public function getUserOrders()
    {
        $user = JWTAuth::user();
        if ($user === null) {
            return response(['error' => 'please sign in, your token has expired'], 401);
        }
        $orders = $user->orders;

        if ($orders->count() === 0) {
            return response(['error' => 'you haven\'t placed an order yet'], 404);
        }
        return response(['orders' => OrderResource::collection($orders), 'message' => 'Retrieved successfully'], 200);
    }

    public function getOrderInfo($order_id)
    {
        $user = JWTAuth::user();
        if ($user === null) {
            return response(['error' => 'please sign in, your token has expired'], 401);
        }

        try {
            $order = Order::findOrFail($order_id);
        }
        catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'this order doesn\'t seem to exist on your orders list'], 404);
        }

        return response([new OrderResource($order)], 200);
    }

    // TODO
    public function placeOrder()
    {
        $user = JWTAuth::user();
        if ($user === null) {
            return response(['error' => 'please sign in, your token has expired'], 401);
        }
        if ($user->cart->cartItems->count() === 0) {
            return response(['error' => 'your cart is empty, Please add items first to your cart'], 500);
        }
        return response($user->cart, '200');
    }

    // TODO check for status of order if confirmed the user can't update or cancel the order
    public function updateOrderData()
    {
        return response([], '200');

    }

    // TODO
    public function cancelOrder()
    {
        return response([], '200');

    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
