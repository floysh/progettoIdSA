<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegistrationTest extends DuskTestCase
{

    public function testCustomerAccountRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->assertSee('Registrati')
                    ->type('name', 'Elfo Bello')
                    ->type('email', 'elfobello@zonko.it')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->select('role', 'customer')
                    ->press('registration_confirm')
                    ->assertPathIs('/')
                    ->assertSee('Elfo Bello')
                    ;
        });
    }

    public function testMerchantAccountRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->assertSee('Registrati')
                    ->type('name', 'Ulric Fabbro')
                    ->type('email', 'ulric@zonko.it')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->select('role', 'merchant')
                    ->press('registration_confirm')
                    ->assertPathIs('/')
                    ->assertSee('Ulric Fabbro')
                    ->assertSee('Mercante')
                    ;
        });
    }
}
