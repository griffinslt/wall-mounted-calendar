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
        $highest_floor = Building::where("id", '=', $building_id)->first()->highest_floor;
        $lowest_floor = Building::where("id", '=', $building_id)->first()->lowest_floor;
        return [
            'building_id' => $building_id,
            'capacity' => fake()->numberBetween(5, 150),
            'room_number' => fake()->numberBetween(1,20),
            'floor' => fake()->numberBetween($lowest_floor,$highest_floor-1),

        ];
    }
}
