<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Attributes\Attribute as Attribute;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AttributeControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStore()
    {
        $admin = User::factory()->create()->assignRole(Role::ADMIN);
        $newAttr = [
            'name' => 'test_attr',
            'variation' => [
                'test1','test2',
            ],
        ];

        $response = $this->actingAs($admin)
            ->post(route('attributes.store'), $newAttr);

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testUpdate()
    {
        $admin = User::factory()->create()->assignRole(Role::ADMIN);
        $attribute = Attribute::factory()->create();
        $updateAttr = [
            'name' => 'test_new_name_update',
            'variation' => [
                'newvar1','newvar2',
            ],
        ];

        $response = $this->actingAs($admin)
            ->patch(route('attributes.update', $attribute->id), $updateAttr);

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testDestroy()
    {
        $attribute = Attribute::factory()->create();
        $admin = User::factory()->create()->assignRole(Role::ADMIN);

        $response = $this->actingAs($admin)
            ->delete(route('attributes.destroy', $attribute->id));

        $response->assertSessionHas('message');
    }
}
