<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Image;

class ImagesTableSeeder extends Seeder
{
    public function run()
    {
        Image::factory()->count(100)->create();
        Image::factory()->onlyJpeg()->count(3)->create();
    }
}
