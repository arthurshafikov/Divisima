<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'women' => [
                'top',
                'midi dresses',
                'maxi dresses',
                'prom dresses',
                'little dlack dresses',
                'mini dresses',
                'shirts',
                'striped',
            ],
            'men' => [
                'midi dresses',
                'maxi dresses',
                'prom dresses',
                'shirts',
            ],
            'jewelry' => '',
            'shoes' => [
                'sneakers',
                'sandals',
                'Formal shoes',
                'boots',
                'flip flops',
            ],
        ];
        foreach ($categories as $parent => $childs) {
            $category = Category::create([
                'name' => $parent,
            ]);
            if (is_array($childs)) {
                foreach ($childs as $name) {
                    Category::create([
                        'parent_id' => $category->id,
                        'name' => $name,
                    ]);
                }
            }
        }
    }
}
