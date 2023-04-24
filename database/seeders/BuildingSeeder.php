<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $b = new Building;
        $b->name = 'Computational Foundary';
        $b->campus = "Bay";
        $b->gps_latitude = 51.61919952682713;
        $b->gps_longitude = -3.878674161771234;
        $b->highest_floor = 4;
        $b->lowest_floor = 0;
        $b->save();

        $b = new Building;
        $b->name = 'Engineering East';
        $b->campus = "Bay";
        $b->gps_latitude = 51.61881862681794;
        $b->gps_longitude = -3.8756964284967648;
        $b->highest_floor = 4;
        $b->lowest_floor = 0;
        $b->save();

        $b = new Building;
        $b->name = 'Engineering Central';
        $b->campus = "Bay";
        $b->gps_latitude = 51.618886576920225;
        $b->gps_longitude = -3.877444615004945;
        $b->highest_floor = 4;
        $b->lowest_floor = 0;
        $b->save();

        $b = new Building;
        $b->name = 'Engineering North';
        $b->campus = "Bay";
        $b->gps_latitude = 51.61975255333815;
        $b->gps_longitude = -3.877852310774985;
        $b->highest_floor = 4;
        $b->lowest_floor = -1;
        $b->save();

        $b = new Building;
        $b->name = 'School Of Management';
        $b->campus = "Bay";
        $b->gps_latitude = 51.618360321640054;
        $b->gps_longitude = -3.8793972631667253;
        $b->highest_floor = 4;
        $b->lowest_floor = 0;
        $b->save();

        $b = new Building;
        $b->name = 'Bay Library';
        $b->campus = "Bay";
        $b->gps_latitude =51.61822042996925;
        $b->gps_longitude = -3.8770047327267503;
        $b->highest_floor = 4;
        $b->lowest_floor = 0;
        $b->save();


        $b = new Building;
        $b->name = 'Singleton Library';
        $b->campus = "Singleton";
        $b->gps_latitude =51.60999244613687;
        $b->gps_longitude = -3.978090916857615;
        $b->highest_floor = 3;
        $b->lowest_floor = -2;
        $b->save();

        $b = new Building;
        $b->name = 'Fulton House';
        $b->campus = "Singleton";
        $b->gps_latitude =51.609639320280806;
        $b->gps_longitude = -3.9805907356581276;
        $b->highest_floor = 5;
        $b->lowest_floor = -1;
        $b->save();


        $b = new Building;
        $b->name = 'Margam Building';
        $b->campus = "Singleton";
        $b->gps_latitude =51.60765376904154;
        $b->gps_longitude =-3.9819962131811626;
        $b->highest_floor = 4;
        $b->lowest_floor = 0;
        $b->save();

        $b = new Building;
        $b->name = 'Digital Technium';
        $b->campus = "Singleton";
        $b->gps_latitude =51.60999452822517;
        $b->gps_longitude = -3.979846422657949;
        $b->highest_floor = 3;
        $b->lowest_floor = 0;
        $b->save();

        $b = new Building;
        $b->name = 'Taliesin';
        $b->campus = "Singleton";
        $b->gps_latitude =51.610440928657674;
        $b->gps_longitude = -3.9793636250355324;
        $b->highest_floor = 3;
        $b->lowest_floor = 0;
        $b->save();

        $b = new Building;
        $b->name = 'Data Science Building';
        $b->campus = "Singleton";
        $b->gps_latitude =51.6091575110858;
        $b->gps_longitude = -3.9832681015134086;
        $b->highest_floor = 8;
        $b->lowest_floor = 0;
        $b->save();

    }
}
