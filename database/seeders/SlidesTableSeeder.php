<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;

class SlidesTableSeeder extends Seeder
{
    public function run()
    {
        Slide::factory()->count(4)->create();
    }
}
