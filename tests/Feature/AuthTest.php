<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function testRegistration()
    {
        $user = User::factory()->make();
        $newUser_arr = array_merge($user->toArray(), [
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response = $this->post(route('register'), $newUser_arr);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
        ]);
    }

    public function testLoginThroughEmail()
    {
        $user = User::factory()->create();
        $newUser_arr = [
            'username' => $user->email,
            'password' => '123',
        ];

        $response = $this->post(route('login'), $newUser_arr);

        $response->assertSessionHasNoErrors();
    }

    public function testLoginThroughName()
    {
        $user = User::factory()->create();
        $newUser_arr = [
            'username' => $user->name,
            'password' => '123',
        ];

        $response = $this->post(route('login'), $newUser_arr);

        $response->assertSessionHasNoErrors();
    }
}
