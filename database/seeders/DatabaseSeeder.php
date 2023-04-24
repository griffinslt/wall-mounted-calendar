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
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(BuildingSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BookingSeeder::class);
        $this->call(FacilitySeeder::class);


        // DB::table('facility_room')->insert([
        //     'facility_id' => 1,
        //     'room_id' => 1,
        // ]);

        DB::table('facility_room')->insert([
            'facility_id' => 2,
            'room_id' => 1,
        ]);

        DB::table('facility_room')->insert([
            'facility_id' => 3,
            'room_id' => 1,
        ]);

        DB::table('facility_room')->insert([
            'facility_id' => 4,
            'room_id' => 1,
        ]);
        foreach (range(1, 1000) as $_) {
            try {
                DB::table('facility_room')->insert([
                    'facility_id' => rand(1, count(Facility::all())),
                    'room_id' => rand(3, count(Room::all())),
                ]);
            } catch (\Illuminate\Database\QueryException $ex) {
                //
            }
        }


        
        
       
    }
}
