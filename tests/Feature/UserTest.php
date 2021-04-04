<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\EmailChangedUserNotification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    public function testUpdate()
    {
        Notification::fake();
        $admin = User::admin();

        $user = User::where('name', '!=' , 'admin')->first();
        $response = $this->actingAs($admin)
                            ->get(route('users.edit', $user->id));
        $response->assertOk();

        $user->email = $this->faker->safeEmail;

        $response = $this->actingAs($admin)
                            ->patch(route('users.update', $user->id), $user->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
        Notification::assertSentTo([$user], VerifyEmail::class);
        Notification::assertSentTo([$user], EmailChangedUserNotification::class);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->delete(route('users.destroy', $user->id));

        $response->assertSessionHas('message');
        $this->assertDeleted('users', [
            'name' => $user->name,
        ]);
    }
}
