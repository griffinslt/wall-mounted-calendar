<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $b = new Booking;
        $b->duration = 30;
        $b->time_of_booking = '2023-02-01 10:30:00';
        $b->room_id = 1;
        $b->user_id = 1;
        $b->checked_in = false;
        $b->save();

        $b = new Booking;
        $b->duration = 1000;
        $b->time_of_booking = '2023-02-01 12:50:00';
        $b->room_id = 2;
        $b->user_id = 1;
        $b->checked_in = false;
        $b->save();


    }
}
