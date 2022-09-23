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
        
    }

    public function test_no_order_created_if_user_credit_is_not_enough()
    {
        $user = UserFactory::new()->create(['role' => 'customer', 'money' => 5]);
        $this->actingAs($user);

        $product1 = Product::findOrFail(1);
        $response = $this->post('/cart', ['product_id' => 1, 'quantity' => 7]);
        $response->assertValid();
        
        // Controlla che l'acquisto fallisca
        $response = $this->post('/orders');
        $response->assertInvalid();

        // Il credito dell'utente non deve essere toccato
        $this->assertEquals(5, $user->money);

        // I prodotti devono restare nel carrello
        $this->assertFalse($user->cart->isEmpty());

    }

    public function test_checkout_fails_when_user_cart_is_empty()
    {
        $user = User::factory()->customer()->create();
        $this->actingAs($user);

        $this->assertEmpty($user->cart);
        
        $response = $this->post('/orders');
        $response->assertInvalid();

        // Eventuali ordini temporanei non devono restare nel DB
        $this->assertEmpty($user->orders);
    }


    public function test_checkout()
    {
        $user = UserFactory::new()->create(['role' => 'customer', 'money' => 10000]);
        $this->actingAs($user);

        $this->assertEquals(0, $user->cart()->count());

        $product1 = Product::find(1);
        $product2 = Product::find(2);
        $product1->update(['quantity' => 20, 'price' => 100]);
        $product2->update(['quantity' => 20, 'price' => 1000]);
        
        // Aggiunta prodotti al carrello
        $response = $this->post('/cart', ['product_id' => $product1->id, 'quantity' => 4]);
        $response->assertValid();
        $response->assertSessionHasNoErrors();
        $response = $this->post('/cart', ['product_id' => $product2->id, 'quantity' => 3]);
        $response->assertValid();
        $response->assertSessionHasNoErrors();
        $this->assertEquals(2, $user->cart()->count());
        
        // Conferma acquisto
        $response = $this->post('/orders');
        $response->assertSessionHas(['success']);
        $this->assertEquals(1, $user->orders()->count());

        // Controlla se il carrello è stato svuotato
        $this->assertEmpty($user->cart->count());
        
        // Controlla se le scorte sono diminuite
        $product1->refresh(); // per recuperare i record aggiornati dal DB
        $product2->refresh();
        $this->assertEquals(20-4, $product1->quantity);
        $this->assertEquals(20-3, $product2->quantity);

        // Controlla se l'utente ha pagato
        $this->assertEquals(6600, $user->money);

        // Controlla se i mercanti han ricevuto i soldi
        if($product1->merchant->is($product2->merchant)) {
            $this->assertEquals(3400, $product1->merchant->money);
        }
        else {
            $this->assertEquals(400, $product1->merchant->money);
            $this->assertEquals(3000, $product2->merchant->money);
        }
    }
}
