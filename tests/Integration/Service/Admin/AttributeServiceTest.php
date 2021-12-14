<?php

namespace Tests\Integration\Service\Admin;

use App\Models\Attributes\Attribute;
use App\Models\Attributes\AttributeVariation;
use App\Services\Admin\AttributeService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AttributeServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreate()
    {
        $params = [
            'name' => 'someAttr',
            'variation' => [
                'someVar1',
                'someVar2',
            ],
        ];

        $attribute = app(AttributeService::class)->create($params);

        $this->assertDatabaseHas(Attribute::class, [
            'name' => 'someAttr',
        ]);
        $this->assertDatabaseHas(AttributeVariation::class, [
            'attribute_id' => $attribute->id,
            'name' => 'someVar1',
        ]);
        $this->assertDatabaseHas(AttributeVariation::class, [
            'attribute_id' => $attribute->id,
            'name' => 'someVar2',
        ]);
    }

    public function testUpdate()
    {
        $attribute = Attribute::factory()->create([
            'name' => 'existingAttribute',
        ]);
        $attributeVariations = AttributeVariation::factory()->count(3)->create([
            'attribute_id' => $attribute->id,
        ]);
        $params = [
            'name' => 'newNameExistingAttribute',
            'variation' => [
                'someNewVar1',
                'someNewVar2',
            ],
        ];

        $attribute = app(AttributeService::class, ['attribute' => $attribute])->update($params);

        $this->assertDatabaseMissing(Attribute::class, [
            'name' => 'existingAttribute',
        ]);
        $this->assertDatabaseHas(Attribute::class, [
            'name' => 'newNameExistingAttribute',
        ]);
        foreach ($attributeVariations as $attributeVariation) {
            $this->assertDatabaseMissing(AttributeVariation::class, [
                'id' => $attributeVariation->id,
            ]);
        }
        $this->assertDatabaseHas(AttributeVariation::class, [
            'attribute_id' => $attribute->id,
            'name' => 'someNewVar1',
        ]);
        $this->assertDatabaseHas(AttributeVariation::class, [
            'attribute_id' => $attribute->id,
            'name' => 'someNewVar2',
        ]);
    }
}
