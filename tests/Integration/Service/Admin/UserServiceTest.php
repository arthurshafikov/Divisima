<?php

namespace Tests\Integration\Service\Admin;

use App\Events\UserEmailHadChanged;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testUpdate()
    {
        Event::fake();
        $user = User::factory()->create();
        $params = [
            'name' => 'newName',
            'email' => 'newEmail',
            'password' => 'newPassword',
        ];

        $user = app(UserService::class, ['user' => $user])->update($params);

        $this->assertDatabaseHas(User::class, [
            'name' => 'newName',
            'email' => 'newEmail',
            'email_verified_at' => null,
        ]);
        Event::assertDispatched(UserEmailHadChanged::class);
    }

    public function testUpdateVerify()
    {
        $user = User::factory()->create();
        $params = [
            'name' => 'newName',
            'email' => 'newEmail',
            'verify' => '1',
        ];

        app(UserService::class, ['user' => $user])->update($params);

        $this->assertDatabaseHas(User::class, [
            'name' => 'newName',
            'email' => 'newEmail',
            'email_verified_at' => $user->email_verified_at,
        ]);
    }
}
