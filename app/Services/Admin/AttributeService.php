<?php

namespace App\Services\Admin;

use App\Models\Attributes\Attribute;
use App\Models\Attributes\AttributeVariation;

class AttributeService
{
    private Attribute $attribute;

    public function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    public function create(array $params): Attribute
    {
        $this->attribute->name = $params['name'];
        $this->attribute->save();
        foreach ($params['variation'] as $variationName) {
            AttributeVariation::create([
                'name' => $variationName,
                'attribute_id' => $this->attribute->id,
            ]);
        }

        return $this->attribute;
    }

    public function update(array $params): Attribute
    {
        $this->attribute->update([
            'name' => $params['name'],
        ]);
        $newAttributeVariations = $params['variation'];

        $this->attribute->variations()->whereNotIn('name', $newAttributeVariations)->delete();
        foreach ($newAttributeVariations as $attributeVariationName) {
            AttributeVariation::updateOrCreate([
                'attribute_id' => $this->attribute->id,
                'name' => $attributeVariationName,
            ]);
        }

        return $this->attribute;
    }
}
