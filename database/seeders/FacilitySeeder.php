<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $f = new Facility;
        $f->name = 'Disabled Access';
        $f->save();

        $f = new Facility;
        $f->name = 'Linux Computers';
        $f->save();

        $f = new Facility;
        $f->name = 'Windows Computers';
        $f->save();

        $f = new Facility;
        $f->name = 'Projector';
        $f->save();



    }
}
