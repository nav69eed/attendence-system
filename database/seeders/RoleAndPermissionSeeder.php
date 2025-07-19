<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create basic permissions
        $permissions = [
            'manage users',
            'manage leave',
            'request leave',
            'manage tasks',
            'submit tasks',
            'view reports'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $studentRole = Role::create(['name' => 'student']);

        // Assign basic permissions to roles
        $adminRole->givePermissionTo([
            'manage users',
            'manage leave',
            'manage tasks',
            'view reports'
        ]);

        $studentRole->givePermissionTo([
            'request leave',
            'submit tasks'
        ]);
    }
}