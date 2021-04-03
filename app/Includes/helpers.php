<?php


function getTree($data)
{
    $tree = [];
    foreach ($data as $id => &$el) {

        if ($el['parent_id'] === null) {
            $tree[$id] = &$el;
        } else {
            $data[$el['parent_id']]['childs'][$id] = &$el;
        }
    }
    return $tree;
}

function getMenu($menu,$ulclass = false,$ulsubclass = 'sub-menu')
{
    $str = '';
    if($ulclass !== false){
        $str .= '<ul class="'.$ulclass.'">';
    }
    foreach ($menu as $el) {
        $str .= nodeMenu($el,$ulsubclass);
    }
    if($ulclass !== false){
        $str .= '</ul>';
    }
    return $str;
}

function nodeMenu($category,$ulsubclass)
{
    $menu = '<li>
                <a href="'.route("category",$category["slug"]) .'" title="' . $category['name'] . '">' .
        $category['name'] . '</a>';

    if (isset($category['childs'])) {
        $menu .= '<ul class="'.$ulsubclass.'">' . getMenu($category['childs']) . '</ul>';
    }
    $menu .= '</li>';

    return $menu;
}

// function getImageSrc($name){
//     return '/'.$name;
// }

function getCategoryTree(){
    $categories = \App\Models\Category::all();
    $menu = [];
    foreach ($categories as $el) {
        $menu[$el->id] = [
            'name' => $el->name,
            'slug' => $el->slug,
            'parent_id' => $el->parent_id,
        ];
    }
    $tree = getTree($menu);
    return $tree;
}

function getAttributesByName($name){
    return \Cache::remember($name, env("CACHE_TIME",0),function() use ($name){
        $attributes =  \App\Models\Attributes\AttributeVariation::whereHas('attribute',function($query) use ($name){
            $query->where('name',$name);
        })->withCount('products')->get();
        $value = explode(',',request()->input($name));
        $attributes->each(function($attr) use ($value){
            if(in_array($attr->slug,$value)){
                $attr->fill(['active' => 1]);
            }
        });
        return $attributes;
    });
    
}

function getProductAttribute($name,$id){
    return \App\Models\Attributes\AttributeVariation::whereHas('attribute',function($query) use ($name){
        $query->where('name',$name);
    })->whereHas('products',function($query) use ($id){
        $query->where('product_id',$id);
    })->get();
}

function getProductAttributes($attrs,$id){
    return \App\Models\Attributes\AttributeVariation::whereHas('attribute',function($query) use ($attrs){
        $query->whereIn('name',$attrs);
    })->whereHas('products',function($query) use ($id){
        $query->where('product_id',$id);
    })->get();
}

function getOption($option,$val = false){
    return \Cache::remember($option, env("CACHE_TIME",0),function() use ($option,$val){
        return App\Http\Controllers\Admin\OptionController::getOption($option,$val);
    });
}
function getOptions($option){
    return \Cache::remember($option . '_ALL', env("CACHE_TIME",0),function() use ($option){
        return App\Http\Controllers\Admin\OptionController::getOption($option);
    });
}


function getAllAttributes(){
    return \Cache::remember('AllAttributes', env("CACHE_TIME",0),function(){
        return \App\Models\Attributes\Attribute::with('variations')->get();
    });
}

function getAllParentCategories(){
    return \Cache::remember('AllParentCategories', env("CACHE_TIME",0),function(){
        $cats = \App\Models\Category::where('parent_id',null)->get();
        return $cats;
    });
}


function echoCheckedIfOldHas($value,$key){
    if(old($key) !== null && in_array($value,old($key))) {
        echo 'checked';
    }
}

function echoCheckedIfModelHas($value,$model,$property){
    if($model->$property->contains($value)) {
        echo 'checked';
    }
}