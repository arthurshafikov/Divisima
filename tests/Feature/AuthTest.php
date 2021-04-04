<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function testAuthPages()
    {
        $response = $this->get(route('login'));
        $response->assertOk();
        $response = $this->get(route('register'));
        $response->assertOk();
        $response = $this->post('logout');
        $response->assertRedirect();
    }

    public function  testRegistration()
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

    public function testLogin()
    {
        $user = User::factory()->create();

        $newUser_arr = [
            'username' => $user->email,
            'password' => '123',
        ];
        $response = $this->post(route('login'), $newUser_arr);
        $response->assertSessionHasNoErrors();

        $newUser_arr = [
            'username' => $user->name,
            'password' => '123',
        ];
        $response = $this->post(route('login'), $newUser_arr);
        $response->assertSessionHasNoErrors();
    }

}
