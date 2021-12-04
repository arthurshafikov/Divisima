<?php

if (!function_exists('getAttributesByName')) {
    function getAttributesByName($name)
    {
        return \Cache::remember($name, env("CACHE_TIME", 0), function () use ($name) {
            $attributes = \App\Models\Attributes\AttributeVariation::whereHas(
                'attribute',
                function ($query) use ($name) {
                    $query->where('name', $name);
                }
            )->withCount('products')->get();
            $value = explode(',', request()->input($name));
            $attributes->each(function ($attr) use ($value) {
                if (in_array($attr->slug, $value)) {
                    $attr->fill(['active' => 1]);
                }
            });
            return $attributes;
        });
    }
}

if (!function_exists('getProductAttribute')) {
    function getProductAttribute($name, $id)
    {
        return \App\Models\Attributes\AttributeVariation::whereHas('attribute', function ($query) use ($name) {
            $query->where('name', $name);
        })->whereHas('products', function ($query) use ($id) {
            $query->where('product_id', $id);
        })->get();
    }
}

if (!function_exists('getProductAttributes')) {
    function getProductAttributes($attrs, $id)
    {
        return \App\Models\Attributes\AttributeVariation::whereHas('attribute', function ($query) use ($attrs) {
            $query->whereIn('name', $attrs);
        })->whereHas('products', function ($query) use ($id) {
            $query->where('product_id', $id);
        })->get();
    }
}

if (!function_exists('getOption')) {
    function getOption($option, $val = false)
    {
        return \Cache::remember($option, env("CACHE_TIME", 0), function () use ($option, $val) {
            return \App\Includes\OptionHelper::getOption($option, $val);
        });
    }
}

if (!function_exists('getAllAttributes')) {
    function getAllAttributes()
    {
        return \Cache::remember('AllAttributes', env("CACHE_TIME", 0), function () {
            return \App\Models\Attributes\Attribute::with('variations')->get();
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
