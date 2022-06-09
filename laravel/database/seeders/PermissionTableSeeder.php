<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
        ];

        // Create all permission based on the list above
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        /**
         * Supervisor
         * is defined in AuthServiceProvider
         */
        Role::create(['name' => 'supervisor']);

        /**
         * Manager
         */
        Role::create(['name' => 'manager'])
            ->givePermissionTo([
                'user-list',
                'role-list',
            ]);

        /**
         * User
         */
        Role::create(['name' => 'user']);

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        app()['cache']->forget('spatie.permission.cache');
    }
}
