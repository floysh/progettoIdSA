<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Database\QueryException as QueryException;

use App\Models\Cart;
use App\Models\User;
use Database\Factories\UserFactory;
use App\Models\Product;
use Database\Factories\ProductFactory;

class CartTest extends TestCase
{
    
    use RefreshDatabase;


    // Move to controller/integration test!
    public function test_quantity_must_be_greater_than_zero() {
        $this->expectException(QueryException::class);
        Cart::create([
            "user_id" => User::customers()->first(),
            "quantity" => -1,
            "product_id" => Product::first() 
        ]);

        $this->expectException(QueryException::class);
        Cart::create([
            "user_id" => User::customers()->first(),
            "quantity" => 0,
            "product_id" => Product::first() 
        ]);
        
        Cart::create([
            "user_id" => User::customers()->first(),
            "quantity" => 1,
            "product_id" => Product::first() 
        ]);
    }

    public function test_scope_on_current_user() {
        $user1 = UserFactory::new()->create([
            'name' => "Ted",
            'role' => 'customer'
        ]);
        $user2 = UserFactory::new()->create([
            'name' => "Verbena",
            'role' => 'customer'
        ]);
        
        ProductFactory::new()->create();
        
        Cart::create([
            "user_id" => $user1->id,
            "product_id" => Product::first()->id,
            "quantity" => 1
        ]);

        Cart::create([
            "user_id" => $user2->id,
            "product_id" => Product::first()->id,
            "quantity" => 2
        ]);

        $this->actingAs($user2);
        foreach (Cart::all() as $cart_entry) {
            $this->assertTrue($cart_entry->user_id == $user2->id);
            $this->assertFalse($cart_entry->user_id == $user1->id);
        }

    }

    public function test_scope_empty_when_unauthenticated() {
        $this->assertEmpty(Cart::all());
    }

    public function test_checkout_price()
    {

        $prod1 = ProductFactory::new()->create([
            "price" => 5
        ]);

        $prod2 = ProductFactory::new()->create([
            "price" => 2.15
        ]);

        $prod3 = ProductFactory::new()->create([
            "price" => 12.15
        ]);

        $user = UserFactory::new()->create([
            'name' => "Norberto",
            'role' => "customer"
        ]);

        $this->actingAs($user);

        Cart::create([
            "user_id" => $user->id,
            "product_id" => $prod1->id,
            "quantity" => 1
        ]);
        Cart::create([
            "user_id" => $user->id,
            "product_id" => $prod2->id,
            "quantity" => 3
        ]);
        Cart::create([
            "user_id" => $user->id,
            "product_id" => $prod3->id,
            "quantity" => 14
        ]);

        $method_result = Cart::getCheckoutPrice();
        $expected_result = 1*5 + 2.15*3 + 14*12.15;

        $this->assertTrue($method_result == $expected_result);
    }

    public function test_checkout_price_on_empty_carts_is_zero()
    {
        $user = UserFactory::new()->create([
            'name' => "Norberto",
            'role' => "customer"
        ]);

        $this->actingAs($user);
        $this->assertEquals(Cart::getCheckoutPrice(), 0);

    }
}
