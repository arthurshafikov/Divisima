<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Review;
use App\Models\Product;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Review::factory()->count(36)->create();

    }
}
