<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Очищення кешу ролей та дозволів
        app()['cache']->forget('spatie.permission.cache');

        // Створення дозволів
        Permission::firstOrCreate(['name' => 'manage_clients']);
        Permission::firstOrCreate(['name' => 'manage_sessions']);
        Permission::firstOrCreate(['name' => 'manage_users']);
        Permission::firstOrCreate(['name' => 'view_dashboard']);

        // Створення ролей
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Призначення дозволів адміністратору
        $adminRole->syncPermissions([
            'manage_clients',
            'manage_sessions',
            'manage_users',
            'view_dashboard'
        ]);

        // Призначення дозволів менеджеру
        $managerRole->syncPermissions([
            'manage_sessions',
            'view_dashboard'
        ]);

        // Призначення дозволів клієнту
        $clientRole->syncPermissions([
            'view_dashboard'
        ]);
    }
}

