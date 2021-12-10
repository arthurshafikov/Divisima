<?php

if (!function_exists('getAttributeVariationsByName')) {
    function getAttributeVariationsByName($name)
    {
        return \Cache::remember($name, env("CACHE_TIME", 0), function () use ($name) {
            $attributeVariations = \App\Models\Attributes\AttributeVariation::whereHas(
                'attribute',
                function ($query) use ($name) {
                    $query->where('name', $name);
                }
            )->withCount('products')->get();
            $value = explode(',', request()->input($name));
            $attributeVariations->each(function ($attrVar) use ($value) {
                if (in_array($attrVar->slug, $value)) {
                    $attrVar->fill(['active' => 1]);
                }
            });
            return $attributeVariations;
        });
    }
}

if (!function_exists('echoCheckedIfOldHas')) {
    function echoCheckedIfOldHas($value, $key)
    {
        if (old($key) !== null && in_array($value, old($key))) {
            echo 'checked';
        }
    }
}

if (!function_exists('echoCheckedIfModelHas')) {
    function echoCheckedIfModelHas($value, $model, $property)
    {
        if ($model->$property->contains($value)) {
            echo 'checked';
        }
    }
}

if (!function_exists('snakeCaseToNormal')) {
    function snakeCaseToNormal(string $string): string
    {
        return ucwords(str_replace('_', ' ', $string));
    }
}
