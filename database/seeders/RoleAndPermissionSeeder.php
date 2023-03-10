<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create-booking']);
        Permission::create(['name' => 'view-booking']);
        Permission::create(['name' => 'view-all-bookings']);
        Permission::create(['name' => 'edit-booking']);
        Permission::create(['name' => 'delete-booking']);

        Permission::create(['name' => 'create-room']);
        Permission::create(['name' => 'update-room']);
        Permission::create(['name' => 'view-room']);
        Permission::create(['name' => 'delete-room']);
        
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'view-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'delete-user']);

        Permission::create(['name' => 'create-role']);
        Permission::create(['name' => 'assign-role']);
        Permission::create(['name' => 'edit-role']);
        Permission::create(['name' => 'delete-role']);

        Permission::create(['name' => 'setup-tablet']);

       

        $adminRole = Role::create(['name' => 'Admin']);
        $lecturerRole = Role::create(['name' => 'Lecturer']);
        $staffRole = Role::create(['name' => 'Support Staff']);
        $studentRole = Role::create(['name' => 'Student']);

        $adminRole->givePermissionTo([
            'create-booking',
            'view-all-bookings',
            'edit-booking',
            'delete-booking',
            'create-room',
            'update-room',
            'view-room',
            'delete-room',
            'create-user',
            'view-user',
            'edit-user',
            'delete-user',
            'create-role',
            'assign-role',
            'edit-role',
            'delete-role',
            'setup-tablet',
        ]);

        $lecturerRole->givePermissionTo([
            'create-booking',
            'view-booking',
            'view-room',
            'view-user',
        
        ]);

        $staffRole->givePermissionTo([
            'create-booking',
            'view-booking',
            'edit-booking',
            'delete-booking',
            'create-room',
            'update-room',
            'view-room',
            'delete-room',
            'view-user',
        ]);

        $studentRole->givePermissionTo([
            'create-booking',
            'view-booking',
            'view-room',
        ]);
    
    
    }
}
