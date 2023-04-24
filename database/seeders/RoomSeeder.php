<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $r = new Room;
        $r->capacity = 15;
        $r->room_number = 1;
        $r->building_id = 1;
        $r->floor = 1;
        $r->save();

        $r = new Room;
        $r->capacity = 10;
        $r->room_number = 2;
        $r->building_id = 1;
        $r->floor = 1;
        $r->save();

        $r = new Room;
        $r->capacity = 10;
        $r->room_number = 3;
        $r->building_id = 1;
        $r->floor = 2;
        $r->save();
        Room::factory()->count(600)->create();
        
    }

    
}
