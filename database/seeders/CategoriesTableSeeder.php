<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

use function GuzzleHttp\json_decode;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
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
        foreach($categories as $parent => $childs){
            $ans = Category::create([
                'name' => $parent,
            ]);
            if(is_array($childs)){
                $id = $ans->id;
                foreach($childs as $name){
                    Category::create([
                        'parent_id' => $id,
                        'name' => $name,
                    ]);
                }
            }
        }
        
    }

}
