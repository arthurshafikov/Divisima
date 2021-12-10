<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attributes\Attribute;
use App\Models\Attributes\AttributeVariation;
use App\Services\Admin\AttributeService;
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
        $attribute = app(AttributeService::class, ['attribute' => new Attribute()])->create($this->myValidate($request));

        return redirect()
            ->route('attributes.edit', $attribute->id)
            ->with('message', __('admin/crud.created', ['name' => 'Attribute']));
    }


    public function update(Request $request, $id)
    {
        app(AttributeService::class, ['attribute' => Attribute::findOrFail($id)])->update($this->myValidate($request));

        return redirect()->back()->with('message', __('admin/crud.updated', ['name' => 'Attribute']));
    }

    public function destroy($id)
    {
        AttributeVariation::where('attribute_id', $id)->delete();

        return parent::destroy($id);
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'variation' => 'array',
            'variation.*' => 'string',
        ]);
    }
}
