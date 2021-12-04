<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'wolf-front@yandex.ru',
            'password' => '123',
            'email_verified_at' => now(),
        ])->assignRole(Role::ADMIN);
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@yandex.ru',
            'password' => '123',
        ]);
        User::factory()->count(10)->create();
    }
}
