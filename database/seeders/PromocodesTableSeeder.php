<?php

namespace Database\Seeders;

use App\Models\Promocode;
use Illuminate\Database\Seeder;

class PromocodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Promocode::factory()->count(3)->create();
    }
}
