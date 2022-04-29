<?php

namespace Database\Factories;

use App\Models\Track;
use App\Models\TrackLicense;
use App\Models\License;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackLicenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrackLicense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'track_id' => Track::all()->random()->id,
            'license_id' => License::all()->random()->id,
            'price' => $this->faker->numberBetween(35,70),
        ];
    }
}
