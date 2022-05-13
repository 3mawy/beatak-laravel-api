<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $track = Track::all()->random();
        $license_id = $track->licenses->random()->id;
        return [
            'item_price' => $track->getPrice($license_id),
            'cart_id' => Cart::all()->random(),
            'track_id' => $track->id,
            'license_id' => $license_id,
        ];
    }
}
