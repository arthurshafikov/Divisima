<?php

namespace Tests\Feature;

use App\Models\Attributes\Attribute as Attribute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttributeTest extends TestCase
{
    // use RefreshDatabase;

    public function testCreate()
    {
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->get(route('attributes.create'));
        $response->assertOk();

        $new_attr = [
            'name' => 'test_attr',
            'variation' => [
                'test1','test2',
            ],  
        ];
        $response = $this->actingAs($admin)
                            ->post(route('attributes.store'),$new_attr);

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testUpdate()
    {
        $admin = User::admin();

        $attribute = Attribute::create([
            'name' => 'test_update',
        ]);
        $response = $this->actingAs($admin)
                            ->get(route('attributes.edit',$attribute->id));
        $response->assertOk();

        $update_attr = [
            'name' => 'test_new_name_update',
            'variation' => [
                'newvar1','newvar2',
            ],
        ];

        $response = $this->actingAs($admin)
                            ->patch(route('attributes.update',$attribute->id),$update_attr);

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testDestroy()
    {
        $attribute = Attribute::create([
            'name' => 'test_destroy',
        ]);
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->delete(route('attributes.destroy',$attribute->id));

        $response->assertSessionHas('message');
    }
}
