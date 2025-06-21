<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'edit reservations']);
        Permission::firstOrCreate(['name' => 'delete reservations']);
        Permission::firstOrCreate(['name' => 'view all reservations']);

        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo(['edit reservations', 'delete reservations', 'view all reservations']);
    }
}
