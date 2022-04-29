<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'cart_id' => $this->id,
            'total_price' => $this->total_price,
            'user_id' => $this->user_id,
            'cart_items' => CartItemResource::collection($this->cartItems),
        ];
    }
}
