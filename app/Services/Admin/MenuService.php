<?php

namespace App\Services\Admin;

use App\Models\Menu;
use App\Models\MenuItems;

class MenuService
{
    private Menu $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function create(array $params): Menu
    {
        $this->menu->fill($params);
        $this->menu->save();

        $menuItemNames = $params['item_names'];
        $menuItemLinks = $params['item_links'];

        for ($i = 0; $i < count($menuItemNames); $i++) {
            MenuItems::create([
                'menu_id' => $this->menu->id,
                'name' => $menuItemNames[$i],
                'path' => $menuItemLinks[$i],
            ]);
        }

        return $this->menu;
    }

    public function update(array $params): Menu
    {
        $this->menu->update($params);

        $menuItemNames = $params['item_names'];
        $menuItemLinks = $params['item_links'];

        $this->menu->items()->delete();

        for ($i = 0; $i < count($menuItemNames); $i++) {
            MenuItems::create([
                'menu_id' => $this->menu->id,
                'name' => $menuItemNames[$i],
                'path' => $menuItemLinks[$i],
            ]);
        }

        return $this->menu;
    }
}
