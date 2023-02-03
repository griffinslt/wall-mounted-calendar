<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'duration' => fake()->randomElement(['15','30', '60', '90', '120']),
            'time_of_booking' => fake()->dateTime(),
            'checked_in' => false,
            'room_id' =>fake()->numberBetween(1,200),
            'user_id' => fake()->numberBetween(1,100),

        ];
    }
}
