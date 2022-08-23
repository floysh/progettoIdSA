<?php

namespace Tests\Feature;

use Database\Factories\ProductFactory;
use \App\Models\Product;

use Database\Factories\UserFactory;
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

        $product1 = ProductFactory::new(['quantity' => 20, 'price' => 2])->create();
        $product2 = ProductFactory::new(['quantity' => 20])->create();
        $product3 = ProductFactory::new()->create();

        $user = UserFactory::new()->create(['role' => 'customer', 'money' => 500]);
    }

    public function test_it_stores_carts()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->post('/cart', ['product_id' => 1, 'quantity' => 3]);
        $response->assertValid();
        $this->assertEquals(1, $user->cart()->count());

        $this->assertEquals(20, Product::find(1)->quantity + $user->cart()->first()->quantity);
    }

    public function test_it_doesnt_store_the_same_product_twice()
    {
        $product = ProductFactory::new()->create(['quantity' => 42]);
        $user = User::find(1);
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

        $user = User::find(1);
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
        $product = ProductFactory::new()->create(['quantity' => 42]);
        $user = User::find(1);
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

    public function test_reserved_quantities_are_restored_on_destroy()
    {
        $product = ProductFactory::new()->create(['quantity' => 42]);
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->post('/cart', ['product_id' => $product->id, 'quantity' => 3]);
        $response->assertValid();
        
        $response = $this->delete('/cart/'.$user->cart->first()->id);
        $response->assertValid();

        // Nulla si crea, nulla si distrugge
        $product->refresh(); // recupera attributi aggiornati dal DB;
        $this->assertEquals(42, $product->quantity);

    }

    public function test_it_doesnt_store_unavailable_products()
    {
        $product = ProductFactory::new()->create(['quantity' => 42, 'is_disabled' => true]);
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->post('/cart', ['product_id' => $product->id, 'quantity' => 3]);
        $response->assertInvalid();
    }

    public function test_it_updates_entries_correctly()
    {
        $product = ProductFactory::new()->create(['quantity' => 42]);
        $user = User::find(1);
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
        $user = User::find(1);
        $other_user = UserFactory::new()->create();

        Cart::create(['user_id' => $other_user->id, 'product_id' => 1, 'quantity' => 2]);
        Cart::create(['user_id' => $other_user->id, 'product_id' => 2, 'quantity' => 2]);
        
        $this->actingAs($user);

        $response = $this->get('/cart');
        $this->assertEmpty($response['cart']);

        Cart::create(['user_id' => $user->id, 'product_id' => 2, 'quantity' => 2]);
        $response = $this->get('/cart');
        $this->assertEquals(1,count($response['cart']));
    }


}
