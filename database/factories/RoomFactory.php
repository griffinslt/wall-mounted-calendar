<?php

namespace Database\Factories;

use App\Models\Building;
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
        $building_id = fake()->numberBetween(1, 12);
        $number_of_floors = Building::where("id", '=', $building_id)->first()->number_of_floors;
        return [
            'building_id' => $building_id,
            'capacity' => fake()->numberBetween(5, 150),
            'room_number' => fake()->numberBetween(1,20),
            'floor' => fake()->numberBetween(0,$number_of_floors-1),

        ];
    }
}
