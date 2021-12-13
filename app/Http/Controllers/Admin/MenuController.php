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
        $this->essense = 'menus';
        $this->td = ['id','name','location'];
        $this->th = ['ID','Name','Location'];
        $this->oneText = 'Menu';
    }

    public function store(Request $request): RedirectResponse
    {
        $menu = app(MenuService::class, ['menu' => new Menu()])->create($this->myValidate($request));

        return redirect()->route($this->essense . '.edit', $menu->id)
            ->with('message', __('admin/crud.created', ['name' => $this->oneText]));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        app(MenuService::class, ['menu' => Menu::findOrFail($id)])->update($this->myValidate($request));

        return redirect()->back()->with('message', __('admin/crud.updated', ['name' => $this->oneText]));
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'item_names' => 'array',
            'item_names.*' => 'string',
            'item_links' => 'array',
            'item_links.*' => 'string',
        ]);
    }
}
