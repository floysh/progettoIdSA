<?php

namespace Tests\Feature;

use Database\Factories\ProductFactory;
use \App\Models\Product;

use Database\Factories\UserFactory;
use \App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $product1 = ProductFactory::new(['quantity' => 20, 'price' => 2])->create();
        $product2 = ProductFactory::new(['quantity' => 20])->create();
        $product3 = ProductFactory::new()->create();
        $product_na = ProductFactory::new(['name' => 'Missingno', 'is_disabled' => true])->create();

        $user = UserFactory::new()->create(['role' => 'customer', 'money' => 500]);
    }

    public function test_checkout_failure_when_user_credit_is_not_enough()
    {
        $user = UserFactory::new()->create(['role' => 'customer', 'money' => 5]);
        $this->actingAs($user);

        $product1 = Product::findOrFail(1);
        $response = $this->post('/cart', ['product_id' => 1, 'quantity' => 7]);
        $response->assertValid();
        
        // Confirm purchase
        $response = $this->post('/orders');
        $response->assertInvalid();

    }

    public function test_checkout_no_empty_orders()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->assertEmpty($user->cart);
        
        $response = $this->post('/orders');
        $this->assertEmpty($user->orders);
    }

    public function test_cart_store_failure_when_invalid_product_quantity()
    {
        $this->markTestIncomplete('Remove or move to CartControllerTest ?');     

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->post('/cart', ['product_id' => 1, 'quantity' => -12]);
        $response->assertInvalid();

        $response = $this->post('/cart', ['product_id' => 1, 'quantity' => 0]);
        $response->assertInvalid();

    }

    public function test_checkout()
    {
        $user = UserFactory::new()->create(['role' => 'customer', 'money' => 500]);
        $this->actingAs($user);

        $this->assertEquals(0, $user->cart()->count());
        
        // Aggiunta prodotti al carrello
        $response = $this->post('/cart', ['product_id' => 1, 'quantity' => 4]);
        $response->assertValid();
        $response->assertSessionHasNoErrors();
        $response = $this->post('/cart', ['product_id' => 2, 'quantity' => 3]);
        $response->assertValid();
        $response->assertSessionHasNoErrors();
        $this->assertEquals(2, $user->cart()->count());
        
        // Conferma acquisto
        $response = $this->post('/orders');
        $response->assertSessionHas(['success']);
        $this->assertEquals(1, $user->orders()->count());
        
        // Controlla se le scorte sono diminuite
        $product1 = Product::find(1); // lascia qui per recuperare il record aggiornato dal DB
        $product2 = Product::find(2);
        $this->assertEquals(20-4, $product1->quantity);
        $this->assertEquals(20-3, $product2->quantity);

        // Controlla se l'utente ha pagato
        $this->assertNotEquals(500, $user->money);
    }
}
