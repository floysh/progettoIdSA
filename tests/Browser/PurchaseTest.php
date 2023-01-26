<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Product;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PurchaseTest extends DuskTestCase
{

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testMoneyTransaction()
    {
        $customer = User::factory()->customer()->create();
        $product = Product::find(1);
        $merchant = $product->merchant;


        $this->browse(function (Browser $first, $second) use ($customer, $product, $merchant) {
            
            $initial_customer_money = $customer->money;
            $final_customer_money = $initial_customer_money - $product->money;
            $initial_merchant_money = $merchant->money;
            $final_merchant_money = $initial_customer_money + $product->money;
            
            $first->loginAs($customer)
                    // Selezione e acquisto prodotto
                    ->visit('/products/'.$product->id)
                    ->assertSee($product->name)
                    ->press('@add-to-cart')
                    ->visit('/cart')
                    ->assertSee($product->name)
                    ->press('Conferma acquisto')
                    // Controlla se ha scalato i soldi
                    ->assertSee('Grazie')
                    ->assertSee($final_customer_money)
                    // Controlla se compare l'ordine
                    ->visit('/orders')
                    ->assertSee($product->name)
                    ;
            
            $second->loginAs($merchant)
                    ->visit('/')
                    // Controlla se il mercante ha ricevuto i soldi
                    ->assertSee($final_merchant_money)
                    // Controlla se compare l'ordine del cliente
                    ->visit('/orders')
                    ->assertSee($customer->name)
                    ->assertSee($product->name)
                    ;
            
        });


        $this->browse(function (Browser $browser) use ($merchant, $product) {
        });
    }
}
