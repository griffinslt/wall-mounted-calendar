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
        Permission::create(['name' => 'view-all-rooms']);
        Permission::create(['name' => 'delete-room']);
        
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'view-all-users']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'delete-user']);

        Permission::create(['name' => 'view-permissions-page']);
        Permission::create(['name' => 'create-role']);
        Permission::create(['name' => 'assign-role']);
        Permission::create(['name' => 'edit-role']);
        Permission::create(['name' => 'delete-role']);

        Permission::create(['name' => 'setup-tablet']);
        Permission::create(['name' => 'view-all-tablets']);

       

        $adminRole = Role::create(['name' => 'Admin']);
        $lecturerRole = Role::create(['name' => 'Lecturer']);
        $staffRole = Role::create(['name' => 'Support Staff']);
        $studentRole = Role::create(['name' => 'Student']);
        $defaultRole = Role::create(['name' => 'Default']);

        $adminRole->givePermissionTo([
            'create-booking',
            'view-all-bookings',
            'edit-booking',
            'delete-booking',
            'create-room',
            'update-room',
            'view-all-rooms',
            'delete-room',
            'create-user',
            'view-all-users',
            'edit-user',
            'delete-user',
            'create-role',
            'assign-role',
            'edit-role',
            'delete-role',
            'setup-tablet',
            'view-all-tablets',
            'view-permissions-page',
        ]);

        $lecturerRole->givePermissionTo([
            'create-booking',
            'view-booking',
            'view-all-rooms',
            'view-all-users',
            'edit-booking',
            'delete-booking',
        
        ]);

        $staffRole->givePermissionTo([
            'create-booking',
            'view-booking',
            'edit-booking',
            'delete-booking',
            'create-room',
            'update-room',
            'view-all-rooms',
            'delete-room',
            'view-all-users',
        ]);

        $studentRole->givePermissionTo([
            'create-booking',
            'view-booking',

        ]);

        $defaultRole->givePermissionTo([
            'create-booking',
            'view-booking',
            'edit-booking',
            'delete-booking',
        ]);
    
    
    }
}
