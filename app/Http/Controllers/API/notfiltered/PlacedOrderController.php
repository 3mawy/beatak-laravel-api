<?php

namespace App\Http\Controllers\API\notfiltered;

use App\Models\PlacedOrder;
use TCG\Voyager\Http\Controllers\VoyagerBreadController;

class PlacedOrderController extends VoyagerBreadController
{
    public function getTracksAttribute(PlacedOrder $placedOrder)
    {
        return $placedOrder->orderItems()->whereNotNull('product_id')->get()->map(function ($oi) {
            return $oi->product->name . ' : ' . $oi->size->size;
        });
//        return $this->hasManyThrough(Track::class, OrderItem::class);
    }
}
