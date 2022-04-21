<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PlacedOrder;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBreadController;

class PlacedOrderController extends VoyagerBreadController
{
    public function getProductsAttribute(PlacedOrder $placedOrder)
    {
        return $placedOrder->orderItems()->whereNotNull('product_id')->get()->map(function ($oi) {
            return $oi->product->name . ' : ' . $oi->size->size;
        });
//        return $this->hasManyThrough(Product::class, OrderItem::class);
    }
}
