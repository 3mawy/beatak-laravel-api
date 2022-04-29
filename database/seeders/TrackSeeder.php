<?php

namespace Database\Seeders;

use App\Models\Track;
use App\Models\License;
use Illuminate\Database\Seeder;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Track::factory()->count(100)->hasAttached(
            License::all(),
            ['price' => rand(30, 55)]
        )->create();
    }
}
