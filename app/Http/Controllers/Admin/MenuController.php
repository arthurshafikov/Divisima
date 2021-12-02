<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\MenuItems;
use Illuminate\Http\Request;

class MenuController extends CRUDController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = Menu::class;
        $this->essense = 'menus';
        $this->td = ['id','name','location'];
        $this->th = ['ID','Name','Location'];
        $this->oneText = 'Menu';
    }

    public function store(Request $request)
    {
        $this->myValidate($request);

        $menu = Menu::create($request->only('name', 'location'));

        $itemNames = $request->item_names;
        $itemLinks = $request->item_links;

        for ($i = 0; $i < count($itemNames); $i++) {
            MenuItems::create([
                'menu_id' => $menu->id,
                'name' => $itemNames[$i],
                'path' => $itemLinks[$i],
            ]);
        }

        return redirect()->route($this->essense . '.edit', $menu->id)
            ->with('message', $this->oneText . ' has been created successfully!');
    }

    public function update(Request $request, $id)
    {
        $this->myValidate($request);

        $menu = Menu::findOrFail($id);
        $menu->update($request->only('name', 'location'));

        $itemNames = $request->item_names;
        $itemLinks = $request->item_links;

        foreach ($menu->items as $item) {
            MenuItems::destroy($item->id);
        }
        for ($i = 0; $i < count($itemNames); $i++) {
            MenuItems::create([
                'menu_id' => $menu->id,
                'name' => $itemNames[$i],
                'path' => $itemLinks[$i],
            ]);
        }

        return redirect()->back()->with('message', $this->oneText . ' has been updated successfully!');
    }


    protected function myValidate(Request $request)
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
