<?php

namespace App\Services\Admin;

use App\Models\Menu;
use App\Models\MenuItem;

class MenuService
{
    private Menu $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function create(array $params): Menu
    {
        return $this->save($params);
    }

    public function update(array $params): Menu
    {
        $this->menu->items()->delete();

        return $this->save($params);
    }

    private function save(array $params): Menu
    {
        $this->menu->fill($params);
        $this->menu->save();

        $menuItemNames = $params['item_names'];
        $menuItemLinks = $params['item_links'];

        for ($i = 0; $i < count($menuItemNames); $i++) {
            MenuItem::create([
                'menu_id' => $this->menu->id,
                'name' => $menuItemNames[$i],
                'path' => $menuItemLinks[$i],
            ]);
        }

        return $this->menu;
    }
}
