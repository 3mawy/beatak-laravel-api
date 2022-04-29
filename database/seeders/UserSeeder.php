<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Area;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(10)->create();
        $users->each(function ($user) {
            $user->cart()->save(Cart::factory()->make());
        });
    }
}
//        User::factory(10)
//            ->has(Address::factory(3)->for(Area::factory()))
//            ->create();

