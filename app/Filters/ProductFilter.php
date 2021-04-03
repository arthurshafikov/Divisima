<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ProductFilter extends QueryFilter
{
    public function price_min($val){
        return $this->builder->where([
            ['price','>=',$val]
        ]);
    }
    public function price_max($val){
        return $this->builder->where([
            ['price','<=',$val]
        ]);
    }
    public function brand($val){
        return $this->builder->whereHas('attributes',function($query) use ($val){
            $query->whereIn('slug',explode(',',$val));
        });
    }
    
    public function size($val){
        return $this->builder->whereHas('attributes',function($query) use ($val){
            $query->whereIn('slug',explode(',',$val));
        });
    }

    public function color($val){
        return $this->builder->whereHas('attributes',function($query) use ($val){
            $query->whereIn('slug',explode(',',$val));
        });
    }

    public function search($search){
        $s = '%' . $search . '%';
        return $this->builder->where('name','LIKE',$s)
                                ->orWhere('description','LIKE',$s)
                                ->orWhere('details','LIKE',$s);
    }


}