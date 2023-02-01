<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'building_id' => fake()->numberBetween(1, 12),
            'capacity' => fake()->numberBetween(5, 150),
            'room_number' => fake()->numberBetween(1,20),
            'floor' => fake()->numberBetween(1,4),

        ];
    }
}
