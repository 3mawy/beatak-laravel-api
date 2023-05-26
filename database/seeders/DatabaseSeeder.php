<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

//        $this->call(DataRowsTableSeeder::class);
//        $this->call(ArtistSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(LicenseSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(TrackSeeder::class);
//        $this->call(TrackSeeder::class);

//       $this->call(TrackLicenseSeeder::class);
//        $this->call(ReviewSeeder::class);
//        $this->call(ExtraSeeder::class);

//        $this->call(CartSeeder::class);
//        $this->call(CartItemSeeder::class);
//        $this->call(CartItemExtraSeeder::class);

//        $this->call(AreaSeeder::class);
//        $this->call(AddressSeeder::class);
//        $this->call(StatusSeeder::class);
//        $this->call(PlacedOrderSeeder::class);
//  $this->call(OrderItemSeeder::class);
// $this->call(OrderItemExtraSeeder::class);


    }
}
