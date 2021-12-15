<?php

namespace Tests\Integration\Reporters;

use App\Models\Category;
use App\Models\Product;
use App\Reporters\CategoryReporter;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryReporterTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetTopSellingCategories()
    {
        $category1 = Category::factory()->create();
        $category1Product1 = Product::factory()->create([
            'total_sales' => 5555,
        ]);
        $category1Product1->category()->sync($category1);
        $category1Product2 = Product::factory()->create([
            'total_sales' => 2222,
        ]);
        $category1Product2->category()->sync($category1);

        $category2 = Category::factory()->create();
        $category2Product2 = Product::factory()->create([
            'total_sales' => 9999,
        ]);
        $category2Product2->category()->sync($category2);
        $category2Product3 = Product::factory()->create([
            'total_sales' => 9999,
        ]);
        $category2Product3->category()->sync($category2);

        $category3 = Category::factory()->create();
        $category3Product3 = Product::factory()->create([
            'total_sales' => 1111,
        ]);
        $category3Product3->category()->sync($category3);
        $expected = [
            array_merge($category2->only('id', 'name'), [
                'sales' => 9999 + 9999,
            ]),
            array_merge($category1->only('id', 'name'), [
                'sales' => 5555 + 2222,
            ]),
            array_merge($category3->only('id', 'name'), [
                'sales' => 1111,
            ]),
        ];

        $result = app(CategoryReporter::class)->getTopSellingCategories();

        $this->assertEquals($expected, $result->toArray());
    }
}
