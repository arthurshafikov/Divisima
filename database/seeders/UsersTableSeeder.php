<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::factory()->admin()->create()->assignRole(Role::ADMIN);
        User::factory()->testUser()->create();
        User::factory()->count(10)->create();
    }
}
