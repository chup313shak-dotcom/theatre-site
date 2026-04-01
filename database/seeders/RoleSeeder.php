<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Создаем роли
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        $cashier = Role::create(['name' => 'cashier']);
        $user = Role::create(['name' => 'user']);
        
        // Создаем разрешения
        $permissions = [
            'view spectacles',
            'create spectacles',
            'edit spectacles',
            'delete spectacles',
            'view orders',
            'manage orders',
            'view users',
            'manage users',
            'view actors',
            'manage actors',
            'view news',
            'manage news',
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        // Назначаем разрешения
        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo([
            'view spectacles', 'create spectacles', 'edit spectacles',
            'view orders', 'manage orders',
            'view actors', 'manage actors',
            'view news', 'manage news'
        ]);
        $cashier->givePermissionTo(['view orders', 'view spectacles']);
        $user->givePermissionTo(['view spectacles', 'view actors', 'view news']);
    }
}