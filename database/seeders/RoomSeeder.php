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
        $r->building = 'CoFo';
        $r->campus = 'Bay Campus';
        $r->capacity = 10;
        $r->room_number = 4;
        $r->save();
        Room::factory()->count(200)->create();
        
    }

    
}
