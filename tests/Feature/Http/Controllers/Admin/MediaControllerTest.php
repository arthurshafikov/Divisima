<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Image;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaControllerTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    public function testUploadImage()
    {
        Storage::fake();
        $file = UploadedFile::fake()->image('image.png');
        $images = [
            $file,
        ];
        $user = User::factory()->create()->assignRole(Role::ADMIN);

        $response = $this->actingAs($user)
            ->post(route('upload-image'), [
                'image' => $images,
            ]);

        $response->assertOk();
    }

    public function testDeleteImages()
    {
        $image = Image::factory()->create();
        $user = User::factory()->create()->assignRole(Role::ADMIN);

        $response = $this->actingAs($user)
            ->delete(route('deleteImages'), [
                'image_ids' => [$image->id],
            ]);

        $response->assertOk();
        $this->assertDeleted('images', [
            'id' => $image->id,
        ]);
    }

    public function testLoadGallery()
    {
        $gallery = Image::factory()->count(4)->create()->pluck('id')->toArray();
        $user = User::factory()->create()->assignRole(Role::ADMIN);

        $response = $this->actingAs($user)
            ->get(route('loadGallery', [
                'gallery' => $gallery,
            ]));

        $response->assertSee('gallery-img');
        $response->assertOk();
    }

    public function testLoadMediaImages()
    {
        $user = User::factory()->create()->assignRole(Role::ADMIN);
        Image::factory()->count(5)->create();

        $response = $this->actingAs($user)
            ->get(route('loadMediaImages'));

        $response->assertSee('media-img');
        $response->assertOk();
    }
}
