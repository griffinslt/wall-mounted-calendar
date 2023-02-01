<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Facility;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BuildingSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BookingSeeder::class);
        $this->call(FacilitySeeder::class);


        foreach (range(1, 300) as $_) {
            try {
                DB::table('facility_room')->insert([
                    'facility_id' => rand(1, count(Facility::all())),
                    'room_id' => rand(1, count(Room::all())),
                ]);
            } catch (\Illuminate\Database\QueryException $ex) {
                //
            }
        }


        
        
       
    }
}
