<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attributes\Attribute;
use App\Models\Attributes\AttributeVariation;
use App\Services\Admin\AttributeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AttributeController extends CRUDController
{
    public function __construct()
    {
        $this->model = Attribute::class;
        $this->routePrefix = 'attributes';
        $this->tableData = ['id','name','slug'];
        $this->tableHeaders = ['ID','Name','Slug'];
        $this->title = 'Attribute';
    }

    public function store(Request $request): RedirectResponse
    {
        $attribute = app(AttributeService::class, ['attribute' => new $this->model()])->create($this->myValidate($request));

        return redirect()
            ->route('attributes.edit', $attribute->id)
            ->with('message', __('admin/crud.created', ['name' => 'Attribute']));
    }


    public function update(Request $request, int $id): RedirectResponse
    {
        app(AttributeService::class, ['attribute' => Attribute::findOrFail($id)])->update($this->myValidate($request));

        return redirect()->back()->with('message', __('admin/crud.updated', ['name' => 'Attribute']));
    }

    public function destroy(int $id): RedirectResponse
    {
        AttributeVariation::where('attribute_id', $id)->delete();

        return parent::destroy($id);
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'variation' => 'nullable|array',
            'variation.*' => 'string',
        ]);
    }
}
