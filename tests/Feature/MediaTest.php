<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use WithoutMiddleware;

    public function testUploadImage()
    {
        Storage::fake('images');

        $file = UploadedFile::fake()->image('image.jpg');

        $images = [
            $file,
        ];
        
        $response = $this->post(route('upload-image'), [
            'image' => $images,
        ]);

        $response->assertStatus(401);

        $user = User::admin();

        $response = $this->actingAs($user)
                            ->post(route('upload-image'), [
                                'image' => $images,
                            ]);

        $response->assertOk();
    }

    public function testDeleteImages()
    {

        $image = Image::factory()->create();

        $user = User::admin();
        
        $response = $this->actingAs($user)
                            ->delete(route('deleteImages'),[
                                'ids' => [$image->id],
                            ]);
        
        $response->assertOk();
    }

    public function testLoadGallery()
    {
        $gallery = Image::inRandomOrder()->take(4)->pluck('id')->toArray();
        $user = User::admin();
        
        $response = $this->actingAs($user)
                            ->get(route('loadGallery',[
                                'gallery' => $gallery,
                            ]));

        $response->assertSee('gallery-img');
        $response->assertOk();
    }

    public function testLoadMediaImages()
    {
        $user = User::admin();
        
        $response = $this->actingAs($user)
                            ->get(route('loadMediaImages'));

        $response->assertSee('media-img');
        $response->assertOk();

    }
}
