<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AttendancePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create attendance-related permissions
        $permissions = [
            'view attendance',
            'mark attendance',
            'view own attendance',
            'generate attendance report'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole = Role::findByName('admin');
        $studentRole = Role::findByName('student');

        // Admin permissions
        $adminRole->givePermissionTo([
            'view attendance',
            'generate attendance report'
        ]);

        // Student permissions
        $studentRole->givePermissionTo([
            'mark attendance',
            'view own attendance'
        ]);
    }
}