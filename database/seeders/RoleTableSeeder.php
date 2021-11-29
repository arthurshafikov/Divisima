<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        $rolesWithPermissions = [
            Role::ADMIN => [
                Permission::ADMIN_PANEL,
            ],
            Role::CLIENT => [],
        ];

        foreach ($rolesWithPermissions as $role => $permissions) {
            $role = Role::create(['name' => $role]);
            $role->givePermissionTo($permissions);
        }
    }
}
