<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Attributes\Attribute;
use App\Models\Attributes\AttributeVariation;

class AttributeController extends CRUDController
{
    public function __construct(){
        $this->model = Attribute::class;
        $this->essense = 'attributes';
        $this->td = ['id','name','slug'];
        $this->th = ['ID','Name','Slug'];
        $this->oneText = 'Attribute';
    }

    public function store(Request $request)
    {
        $this->myValidate($request);
        $name = $request->name;
        
        $attr = Attribute::create(['name' => $name]);

        foreach($request->variation as $varname){
            AttributeVariation::updateOrCreate(
                ['name' => $varname],
                ['attribute_id' => $attr->id,],
            );
        }
        return redirect()->route('attributes.edit',$attr->id)->with('message','Attribute has been created successfully!');
    }


    public function update(Request $request, $id)
    {
        $this->myValidate($request);
        $attr = Attribute::findOrFail($id);

        $attr->name = $request->name;
        $attr->save();

        $new_vars = $request->variation;

        AttributeVariation::where([
            ['attribute_id','=',$id],
        ])->whereNotIn('name',$new_vars)->delete();

        foreach($new_vars as $varname){
            AttributeVariation::updateOrCreate(
                ['attribute_id' => $attr->id,'name' => $varname],
            );
        }

        return redirect()->back()->with('message','Attribute has been updated successfully!');
    }

    public function destroy($id)
    {
        AttributeVariation::where('attribute_id',$id)->delete();
        return parent::destroy($id);
    }

    protected function myValidate(Request $request)
    {
        return $request->validate([
            'name' => 'required|string',
            'variation' => 'array',
            'variation.*' => 'string',
        ]);
    }
}
