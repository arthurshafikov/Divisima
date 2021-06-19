<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthPagesTest extends DuskTestCase
{

    public function testRegister()
    {
        $user = User::factory()->make();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('register')
                    ->type('name', $user->name)
                    ->type('email', $user->email)
                    ->type('password', '12345678')
                    ->type('password_confirmation', '12345678')
                    ->screenshot('register.png')
                    ->press('Submit')
                    ->assertAuthenticated();
        });
    }

    public function testLogout()
    {

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('home')
                    ->screenshot('Logout.png')
                    ->click('@logout-button')
                    ->assertGuest();
        });
    }
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $user = User::admin();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('login')
                    ->screenshot('login.png')
                    ->type('username', $user->email)
                    ->type('password', '123')
                    ->press('Submit')
                    ->assertAuthenticated();
        });
    }
}
