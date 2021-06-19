<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Promocode;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PromocodeControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testAcceptPromocode()
    {
        $promocode = Promocode::factory()->create();

        $response = $this->post(route('acceptPromocode'), [
                'promocode' => $promocode->promocode,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('msg');
        $response->assertSessionHas('promocode');
    }

    public function testRemovePromocode()
    {
        $promocode = Promocode::factory()->create();

        $response = $this->withSession(['promocode' => $promocode->promocode])->delete(route('removePromocode'));

        $response->assertRedirect();
        $response->assertSessionHas('msg');
        $response->assertSessionMissing('promocode');
    }
}
