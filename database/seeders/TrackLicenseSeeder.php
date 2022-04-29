<?php

namespace Database\Seeders;

use App\Models\TrackLicense;
use Illuminate\Database\Seeder;

class TrackLicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       TrackLicense::factory()->times(100)->create();

    }
}
