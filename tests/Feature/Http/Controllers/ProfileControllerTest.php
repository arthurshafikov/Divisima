<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testAccount()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->get(route('account'));

        $response->assertOk();
        $response->assertSee('Your account');
    }

    public function testAccountWithUnverifiedEmail()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('account'));

        $response->assertRedirect();
    }

    public function testUploadAvatar()
    {
        Storage::fake();
        $file = UploadedFile::fake()->image('avatar.png');
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('upload-avatar'), [
                'avatar' => $file,
            ]);

        $response->assertJsonCount(1);
    }

    public function testChangeProfile()
    {
        $user = User::factory()->create();
        $profileInfo = [
            'first_name' => 'testName',
            'surname' => 'testSurname',
            'address' => 'testAddress',
            'country' => 'testCountry',
            'zip' => '4124125',
            'phone' => '89999999999',
        ];

        $response = $this->actingAs($user)
            ->post(route('change-profile'), $profileInfo);

        $response->assertOk();
    }
}
