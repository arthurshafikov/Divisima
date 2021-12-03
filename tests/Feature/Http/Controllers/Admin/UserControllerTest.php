<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Notifications\EmailChangedUserNotification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    public function testUpdate()
    {
        Notification::fake();
        $admin = User::factory()->create()->assignRole(Role::ADMIN);
        $user = User::factory()->create();
        $user->email = $this->faker->safeEmail;

        $response = $this->actingAs($admin)
            ->patch(route('users.update', $user->id), $user->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
        Notification::assertSentTo($user, VerifyEmail::class);
        Notification::assertSentTo($user, EmailChangedUserNotification::class);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create()->assignRole(Role::ADMIN);

        $response = $this->actingAs($admin)
            ->delete(route('users.destroy', $user->id));

        $response->assertSessionHas('message');
        $this->assertDeleted('users', [
            'name' => $user->name,
        ]);
    }
}
