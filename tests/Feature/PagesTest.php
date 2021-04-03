<?php
// vendor\bin\phpunit
namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{

    public function testPages()
    {

        $pages = ['contact','shop','home','wishlist','cart'];
        foreach($pages as $route){
            $response = $this->get(route($route));
            $response->assertOk();
        }
    }

    
}
