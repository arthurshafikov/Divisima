<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::factory()->admin()->create();
        User::factory()->testUser()->create();
        User::factory()->count(10)->create();
    }
}
