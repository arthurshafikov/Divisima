<?php

namespace Database\Seeders;

use App\Models\Promocode;
use Illuminate\Database\Seeder;

class PromocodesTableSeeder extends Seeder
{
    public function run()
    {
        Promocode::factory()->count(3)->create();
    }
}
