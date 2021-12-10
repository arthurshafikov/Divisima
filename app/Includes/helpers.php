<?php

use App\Models\Attributes\AttributeVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getAttributeVariationsByName')) {
    function getAttributeVariationsByName($name)
    {
        return Cache::remember($name, env("CACHE_TIME", 0), function () use ($name) {
            $attributeVariations = AttributeVariation::whereHas(
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

if (!function_exists('checkedIfOldHas')) {
    function checkedIfOldHas(mixed $value, string $key): string
    {
        if (old($key) !== null && in_array($value, old($key))) {
            return 'checked';
        }
        return '';
    }
}

if (!function_exists('checkedIfModelHas')) {
    function checkedIfModelHas(string $value, Model $model, string $property): string
    {
        if ($model?->$property?->contains($value)) {
            return 'checked';
        }
        return '';
    }
}

if (!function_exists('snakeCaseToNormal')) {
    function snakeCaseToNormal(string $string): string
    {
        return ucwords(str_replace('_', ' ', $string));
    }
}
