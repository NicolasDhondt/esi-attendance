<?php

namespace Database\Factories;

use App\Models\Pae;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

class PaeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pae::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker\Factory::create();
        return [
            'studentId' => $faker->unique()->numberBetween(1, 100),
            'courseId' => $faker->numberBetween(1, 10),
        ];
    }
}
