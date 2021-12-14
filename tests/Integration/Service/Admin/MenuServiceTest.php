<?php

namespace Tests\Integration\Service\Admin;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Services\Admin\MenuService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MenuServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreate()
    {
        $params = [
            'name' => 'someMenu',
            'location' => 'header',
            'item_names' => [
                'someMenuItemName1',
                'someMenuItemName2',
            ],
            'item_links' => [
                'someMenuItemLink1',
                'someMenuItemLink2',
            ],
        ];

        $menu = app(MenuService::class)->create($params);

        $this->assertDatabaseHas(Menu::class, [
            'name' => 'someMenu',
            'location' => 'header',
        ]);
        $this->assertDatabaseHas(MenuItem::class, [
            'menu_id' => $menu->id,
            'name' => 'someMenuItemName1',
            'path' => 'someMenuItemLink1',
        ]);
        $this->assertDatabaseHas(MenuItem::class, [
            'menu_id' => $menu->id,
            'name' => 'someMenuItemName2',
            'path' => 'someMenuItemLink2',
        ]);
    }

    public function testUpdate()
    {
        $menu = Menu::factory()->create();
        $menuItems = MenuItem::factory()->count(3)->create([
            'menu_id' => $menu->id,
        ]);
        $params = [
            'name' => 'someMenu',
            'location' => 'header',
            'item_names' => [
                'someMenuItemName1',
                'someMenuItemName2',
            ],
            'item_links' => [
                'someMenuItemLink1',
                'someMenuItemLink2',
            ],
        ];

        $menu = app(MenuService::class, ['menu' => $menu])->update($params);

        $this->assertDatabaseHas(Menu::class, [
            'name' => 'someMenu',
            'location' => 'header',
        ]);
        foreach ($menuItems as $menuItem) {
            $this->assertDatabaseMissing(MenuItem::class, [
                'id' => $menuItem->id,
            ]);
        }
        $this->assertDatabaseHas(MenuItem::class, [
            'menu_id' => $menu->id,
            'name' => 'someMenuItemName1',
            'path' => 'someMenuItemLink1',
        ]);
        $this->assertDatabaseHas(MenuItem::class, [
            'menu_id' => $menu->id,
            'name' => 'someMenuItemName2',
            'path' => 'someMenuItemLink2',
        ]);
    }
}
