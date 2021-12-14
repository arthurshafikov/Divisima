<?php

namespace Tests\Integration\Service;

use App\Models\Image;
use App\Models\Profile;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProfileServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testUploadAvatar()
    {
        $filePath = 'some/path';
        $user = User::factory()->create();
        Auth::login($user);

        $result = app(ProfileService::class)->uploadAvatar($filePath);

        $imageId = Image::whereSrc($filePath)->first()->id;
        $this->assertDatabaseHas(Profile::class, [
            'image_id' => $imageId,
        ]);
        $this->assertEquals([
            'text' => $filePath,
        ], $result);
    }

    public function testUpdateProfileInfo()
    {
        $user = User::factory()->create();
        Auth::login($user);
        $params = [
            'first_name' => 'newFirstName',
            'surname' => 'newSurName',
        ];

        app(ProfileService::class)->updateProfileInfo($params);

        $this->assertDatabaseHas(Profile::class, [
            'user_id' => $user->id,
            'first_name' => 'newFirstName',
            'surname' => 'newSurName',
        ]);
    }
}
