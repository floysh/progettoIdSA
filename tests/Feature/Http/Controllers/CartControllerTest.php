<?php

namespace Tests\Feature;

use \App\Models\Product;
use \App\Models\User;

use \App\Models\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_stores_carts()
    {
        $user = User::factory()->customer()->create();
        $this->actingAs($user);

        $product = Product::factory()->create(['quantity' => 20]);

        $response = $this->post('/cart', ['product_id' => $product->id, 'quantity' => 3]);
        $response->assertValid();
        $this->assertEquals(1, $user->cart()->count());

        $this->assertEquals(20, $product->refresh()->quantity + $user->cart()->first()->quantity);
    }

    public function test_it_doesnt_store_the_same_product_twice()
    {
        $product = Product::factory()->create(['quantity' => 42]);
        $user = User::factory()->customer()->create();
        $this->actingAs($user);

        $response = $this->post('/cart', ['product_id' => $product->id, 'quantity' => 3]);
        $response->assertValid();
        $response = $this->post('/cart', ['product_id' => $product->id, 'quantity' => 2]);
        
        $this->assertEquals(1, $user->cart()->count());

        //Nulla si crea, nulla si distrugge
        $product->refresh();
        $this->assertEquals(42, $user->cart()->first()->quantity + $product->quantity);
    }

    
    public function test_it_doesnt_store_invalid_product_quantities()
    {   

        $user = User::customers()->first();
        $this->actingAs($user);

        $response = $this->post('/cart', ['product_id' => 1, 'quantity' => -12]);
        $response->assertInvalid();

        $response = $this->post('/cart', ['product_id' => 1, 'quantity' => 0]);
        $response->assertInvalid();

        $response = $this->post('/cart', ['product_id' => 1, 'quantity' => 99*(Product::find(1)->quantity)]);
        $response->assertInvalid();

    }

    public function test_product_quantities_are_reserved()
    {
        $product = Product::factory()->create(['quantity' => 42]);
        $user = User::factory()->customer()->create();
        $this->actingAs($user);

        $response = $this->post('/cart', ['product_id' => $product->id, 'quantity' => 3]);
        $response->assertValid();

        // Il prodotto è stato inserito nel carrello
        $this->assertEquals(1, $user->cart()->count());

        // Nulla si crea, nulla si distrugge
        $product->refresh(); // recupera attributi aggiornati dal DB;
        $this->assertEquals(39, $product->quantity);
        $this->assertEquals(42, $product->quantity + $user->cart()->first()->quantity);
    }

    public function test_reserved_quantities_are_restored_when_products_are_removed()
    {
        $product = Product::factory()->create(['quantity' => 42]);
        $user = User::customers()->first();
        $this->actingAs($user);

        $response = $this->post('/cart', ['product_id' => $product->id, 'quantity' => 3]);
        $response->assertValid();
        
        $response = $this->delete('/cart/'.$user->cart->firstWhere('product_id', $product->id)->id);
        $response->assertValid();

        // Nulla si crea, nulla si distrugge
        $product->refresh(); // recupera attributi aggiornati dal DB;
        $this->assertEquals(42, $product->quantity);

    }

    public function test_it_doesnt_store_unavailable_products()
    {
        $product = Product::factory()->create(['quantity' => 42, 'is_disabled' => true]);
        $user = User::customers()->first();
        $this->actingAs($user);

        $response = $this->post('/cart', ['product_id' => $product->id, 'quantity' => 3]);
        $response->assertInvalid();
    }

    public function test_it_updates_entries_correctly()
    {
        $product = Product::factory()->create(['quantity' => 42]);
        $user = User::factory()->customer()->create();
        $this->actingAs($user);

        $response = $this->post('/cart', ['product_id' => $product->id, 'quantity' => 2]);
        $response->assertValid();
        $response = $this->patch('/cart/'.$user->cart()->first()->id, ['quantity' => 30]);
        $response->assertValid();
        
        // Controlla che il carrello sia stato aggiornato
        $user->refresh();
        $this->assertEquals(1, $user->cart()->count());
        $this->assertEquals(30, $user->cart()->first()->quantity);
        
        // Controlla che il prodotto sia stato aggiornato di conseguenza
        $product->refresh();
        $this->assertEquals(42-30, $product->quantity);

    }

    public function test_index_is_scoped_to_current_user() 
    {
        $user = User::factory()->customer()
                    ->hasCart(1)
                    ->create();
        
        $other_user = User::factory()->customer()
                    ->hasCart(1)
                    ->create();

        
        $this->actingAs($user);

        $response = $this->get('/cart');
        $this->assertEquals(1, count($response['cart']));
    }


}
