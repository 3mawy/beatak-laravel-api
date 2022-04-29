<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Track;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genre::factory(5)->create();

//        Genre::factory(10)
//            ->has(Track::factory()->count(10))
//            ->create();
    }
}
