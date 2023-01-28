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
        $campuses = array('Bay', 'Singleton');
        $bayBuildings = array('CoFo', 'Engineering East', 'SoM', 'Engineering Central', 'Bay Library', 'Great Hall', 'Y Twyni', 'The College', 'Engineering North');
        $singletonBuildings = array('Finance Building', 'Keir Hardie Building', 'Library', 'Faraday Building', 'Farady Tower', 'Talbot Building', 'Margam Building', 'Botanic Compound', 'Glyndwr Building', 'Vivian Bulding', 'Fulton House', 'Data Science Building', 'Digital Technium', 'Taliesin');
        $campus = fake()->randomElement($campuses);
        $building = '';
    
        if ($campus == 'Bay') {
            $building = fake()->randomElement($bayBuildings);
        } else {
            $building = fake()->randomElement($singletonBuildings);
        }

        return [
            'building' => $building,
            'campus' => $campus,
            'capacity' => fake()->numberBetween(5, 150),
            'room_number' => fake()->numberBetween(1,350),

        ];
    }
}
