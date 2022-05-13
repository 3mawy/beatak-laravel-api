<?php

namespace Database\Factories;

use App\Models\Artist;
use App\Models\Type;
use App\Models\User;
use App\Models\Genre;
use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Track::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'artist_id' => Artist::all()->random()->id,
            'name' => $this->faker->name(),
            'genre_id' => Genre::all()->random()->id,
            'type_id' => Type::all()->random()->id,
            'description' => $this->faker->realText(30),
            'active' => $this->faker->boolean(80),
            'discount' => $this->faker->numberBetween(20, 40),
        ];
    }
}
