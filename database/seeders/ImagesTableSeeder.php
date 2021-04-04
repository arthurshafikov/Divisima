<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Image;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Image::factory()->count(100)->create();

        // slider big images
        for ($i = 1; $i <= 2; $i++) {
            Image::create([
                'img' => 'images/'.$i.'.jpeg',
            ]);
        }
        
    }
}
