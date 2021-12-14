<?php

namespace Tests\Integration\Service\Admin;

use App\Models\Attributes\AttributeVariation;
use App\Models\Attributes\AttributeVariationProduct;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Services\Admin\ProductService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreate()
    {
        $attributeVariation = AttributeVariation::factory()->create();
        $category = Category::factory()->create();
        $gallery = Image::factory()->count(3)->create();
        $params = [
            'name' => 'someProductName',
            'gallery' => $gallery->implode('id', ','),
            'price' => '20',
            'attributes' => [
                $attributeVariation->id,
            ],
            'category' => [
                $category->id,
            ],
            'stock' => Product::PRODUCT_IN_STOCK_STATUS,
        ];

        $product = app(ProductService::class)->create($params);

        $this->assertDatabaseHas(Product::class, [
            'name' => 'someProductName',
        ]);
        $this->assertDatabaseHas('category_product', [
            'category_id' => $category->id,
            'product_id' => $product->id,
        ]);
        $this->assertDatabaseHas(AttributeVariationProduct::class, [
            'attribute_variation_id' => $attributeVariation->id,
            'product_id' => $product->id,
        ]);
        foreach ($gallery as $image) {
            $this->assertDatabaseHas('imageables', [
                'image_id' => $image->id,
                'imageable_type' => Product::class,
                'imageable_id' => $product->id,
            ]);
        }
    }

    public function testUpdate()
    {
        $product = Product::factory()->hasCategory(1)->hasAttributeVariations(1)->create();
        $newCategory = Category::factory()->create();
        $params = [
            'name' => 'someNewProductName',
            'price' => '20',
            'category' => [
                $newCategory->id,
            ],
            'stock' => Product::PRODUCT_IN_STOCK_STATUS,
        ];
        $oldCategory = $product->category->first();

        $result = app(ProductService::class, ['product' => $product])->update($params);

        $this->assertDatabaseHas(Product::class, [
            'name' => 'someNewProductName',
        ]);
        $this->assertDatabaseMissing('category_product', [
            'category_id' => $oldCategory->id,
            'product_id' => $product->id,
        ]);
        $this->assertDatabaseHas('category_product', [
            'category_id' => $newCategory->id,
            'product_id' => $product->id,
        ]);
    }
}
