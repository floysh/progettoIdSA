<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Product;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductTest extends DuskTestCase
{
    
    public function testProductCreation() {
        $merchant = User::merchants()->first();
        $product = Product::factory()
        ->make([
            'name' => 'Pozione di Test', 
            'category' => 'object', 
            'imagepath' => 'blue-potion.svg',
            'price' => 49.99    // per evitare errori con la formattazione (le direttive Blade non funzionano qui)
        ]);
        
        $this->browse(function (Browser $browser) use ($product, $merchant) {

            $browser->loginAs($merchant)
                    ->visit('/catalogue')
                    ->assertSeeLink('Nuovo')
                    ->clickLink('Nuovo')
                    ->assertPathIs('/products/create')

                    ->type('name', $product->name)
                    ->type('imagepath', $product->imagepath)
                    ->type('price', $product->price)
                    ->type('quantity', $product->quantity)
                    ->select('category', 'object')
                    ->radio('is_disabled', '0')
                    ->type('description', $product->description)
                    ->press('@create-product-button')

                    ->assertSee($product->name)
                    ->assertSee($merchant->name)
                    ->assertSee('49,99')
                    ->assertSee($product->quantity)
                    ->assertSee($product->description)
                    ;
                    
        });
    }


    public function testProductEdit() {
        $product = Product::first();
        $edited_product = Product::factory()->make();

        $this->browse(function (Browser $browser) use ($product, $edited_product) {
            $browser->loginAs($product->merchant)
                    ->visit('/products/'.$product->id)
                    ->assertSeeLink('Modifica')
                    ->clickLink('Modifica')
                    ->assertPathIs('/products/'.$product->id.'/edit')

                    // Controlla se il form di modifica cambia tutti i campi
                    ->type('name', $edited_product->name)
                    ->type('imagepath', $edited_product->imagepath)
                    ->type('price', '90.45')
                    ->type('quantity', $edited_product->quantity)
                    ->select('category', $edited_product->category->value)
                    ->type('description', $product->description)
                    ->press('@edit-product-button')

                    ->assertPathIs('/products/'.$product->id)
                    ->assertSee($edited_product->name)
                    ->assertSee($product->merchant->name)
                    ->assertSee('90,45')
                    ->assertSee($edited_product->quantity)
                    ->assertSee($edited_product->category->name)
                    ;
        });
    }


    public function testProductDisable() {
        $product = Product::first();

        $this->browse(function (Browser $browser) use ($product) {

            $browser->loginAs($product->merchant)
                    ->visit('/products/'.$product->id)
                    ->assertSeeLink('Modifica')
                    ->clickLink('Modifica')
                    ->assertPathIs('/products/'.$product->id.'/edit')

                    ->radio('is_disabled', '1')
                    ->press('@edit-product-button')

                    ->assertSee('Non disponibile')
                    ;
                    
        });
    }


    public function testProductEnable() {
        $product = Product::notAvailable()->first();

        if (! $product) {
            $product = Product::factory()->create(['is_disabled' => true]);
        }

        $this->browse(function (Browser $browser) use ($product) {

            $browser->loginAs($product->merchant)
                    ->visit('/products/'.$product->id)
                    ->assertSee('Non disponibile')
                    ->assertSeeLink('Modifica')
                    ->clickLink('Modifica')
                    ->assertPathIs('/products/'.$product->id.'/edit')

                    ->radio('is_disabled', '0')
                    ->press('@edit-product-button')
                    ->assertDontSee('Non disponibile')
                    ;
                    
        });
    }
}
