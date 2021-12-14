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
        return $this->save($params);
    }

    public function update(array $params): Attribute
    {
        $this->attribute->variations()->whereNotIn('name', $params['variation'])->delete();

        return $this->save($params);
    }

    private function save(array $params): Attribute
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
}
