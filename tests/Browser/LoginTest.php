<?php

namespace Tests\Browser;

use App\Models\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    
    /**
     * A Dusk test example.
     *
     * @return void
     */

    /** @test */
    public function testCustomerLogin()
    {
        //$user = User::find(1);
        $user = User::Factory()->customer()->create();
 
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/')
                    ->assertSee($user->name);

            $browser->assertAuthenticated()
                    ->logout();
        });
    }

    /** @test */
    public function testMerchantLogin()
    {
        //$user = User::where('role', 'merchant')->first();
        $user = User::Factory()->merchant()->create();
 
        $this->browse(function ($browser) use ($user) {
            $browser->assertGuest();
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/')
                    ->assertSee('Mercante');
        });
    }
}
