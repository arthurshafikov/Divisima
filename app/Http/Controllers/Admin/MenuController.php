<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Services\Admin\MenuService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuController extends CRUDController
{
    public function __construct()
    {
        $this->model = Menu::class;
        $this->routePrefix = 'menus';
        $this->tableData = ['id','name','location'];
        $this->tableHeaders = ['ID','Name','Location'];
        $this->title = 'Menu';
    }

    public function store(Request $request): RedirectResponse
    {
        $menu = app(MenuService::class, ['menu' => new Menu()])->create($this->myValidate($request));

        return redirect()->route($this->routePrefix . '.edit', $menu->id)
            ->with('message', __('admin/crud.created', ['name' => $this->title]));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        app(MenuService::class, ['menu' => Menu::findOrFail($id)])->update($this->myValidate($request));

        return redirect()->back()->with('message', __('admin/crud.updated', ['name' => $this->title]));
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'item_names' => 'nullable|array',
            'item_names.*' => 'string',
            'item_links' => 'nullable|array',
            'item_links.*' => 'string',
        ]);
    }
}
