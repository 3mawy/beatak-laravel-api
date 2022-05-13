<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
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
            $user->artist()->save(Artist::factory()->make());
        });
    }
}
