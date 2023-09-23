<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> $this->faker->name(),
            'price'=> $this->faker->numberBetween(10000000, 10000000),
            'bathrooms'=> $this->faker->numberBetween(1, 5),
            'city'=> $this->faker->city(),
            'description'=> $this->faker->text(),
            'type'=> $this->faker->randomElement(['apartment', 'house', 'villa']),
            'location'=> $this->faker->randomElement(['north', 'south', 'east', 'west']),
            'size'=> $this->faker->numberBetween(100, 1000),
            'rooms'=> $this->faker->numberBetween(1, 5),
            'is_sold'=> false,

        ];
    }
}
