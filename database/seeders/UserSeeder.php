<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = new User();
        $u->name = 'admin';
        $u->email = 'admin@email.com';
        $u->password = bcrypt('password');
        $u->role = "admin";
        $u->save();

        $u2 = new User();
        $u2->name = 'Sam';
        $u2->email = '2014044@swansea.ac.uk';
        $u2->password = bcrypt('password1');
        $u2->role = "student";
        $u2->save();

        $u3 = new User();
        $u3->name = 'Liam';
        $u3->email = 'liam@email.com';
        $u3->password = bcrypt('password2');
        $u3->role = 'lecturer';
        $u3->save();
    }
}
