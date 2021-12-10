<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attributes\Attribute;
use App\Models\Attributes\AttributeVariation;
use Illuminate\Http\Request;

class AttributeController extends CRUDController
{
    public function __construct()
    {
        $this->model = Attribute::class;
        $this->essense = 'attributes';
        $this->td = ['id','name','slug'];
        $this->th = ['ID','Name','Slug'];
        $this->oneText = 'Attribute';
    }

    public function store(Request $request)
    {
        $this->myValidate($request);
        $attr = Attribute::create(['name' => $request->name]);
        foreach ($request->variation as $varname) {
            AttributeVariation::updateOrCreate(
                ['name' => $varname],
                ['attribute_id' => $attr->id],
            );
        }

        return redirect()
            ->route('attributes.edit', $attr->id)
            ->with('message', __('admin/crud.created', ['name' => 'Attribute']));
    }


    public function update(Request $request, $id)
    {
        $this->myValidate($request);
        $attr = Attribute::findOrFail($id);
        $attr->update([
           'name' => $request->name,
        ]);

        $newVars = $request->variation;

        AttributeVariation::where([
            ['attribute_id','=',$id],
        ])->whereNotIn('name', $newVars)->delete();

        foreach ($newVars as $varname) {
            AttributeVariation::updateOrCreate(
                ['attribute_id' => $attr->id,'name' => $varname],
            );
        }

        return redirect()->back()->with('message', __('admin/crud.updated', ['name' => 'Attribute']));
    }

    public function destroy($id)
    {
        AttributeVariation::where('attribute_id', $id)->delete();

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
