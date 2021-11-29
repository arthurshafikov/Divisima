<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        foreach (Permission::PERMISSIONS as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
