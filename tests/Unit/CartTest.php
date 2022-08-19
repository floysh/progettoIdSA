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


    public function test_quantity_must_be_greater_than_zero() {
        
        ProductFactory::new()->create();
        
        $this->expectException(QueryException::class);
        Cart::create([
            "user_id" => User::customers()->first(),
            "quantity" => -1,
            "product_id" => Product::first()->id
        ]);

        $this->expectException(QueryException::class);
        Cart::create([
            "user_id" => User::customers()->first(),
            "quantity" => 0,
            "product_id" => Product::first()->id
        ]);
        
        Cart::create([
            "user_id" => User::customers()->first(),
            "quantity" => 1,
            "product_id" => Product::first()->id
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

        $this->assertNotEquals($user1->user_id, $user2->id);
        
        ProductFactory::new()->create();
        
        Cart::create([
            "user_id" => $user1->id,
            "product_id" => Product::first()->id,
            "quantity" => 10
        ]);

        Cart::create([
            "user_id" => $user2->id,
            "product_id" => Product::first()->id,
            "quantity" => 20
        ]);

        $this->actingAs($user2);
        foreach (Cart::all() as $cart_entry) {
            $this->assertEquals($cart_entry->user_id, $user2->id);
        }

    }

    public function test_scope_empty_when_unauthenticated() {
        $this->assertEmpty(Cart::all());
    }

    public function test_checkout_price()
    {
        $tests = [
            ['quantity' => 1, 'price' => 5],
            ['quantity' => 3, 'price' => 2.15],
            ['quantity' => 14, 'price' => 12.15],
        ];

        $user = UserFactory::new()->create([
            'role' => "customer"
        ]);

        $this->actingAs($user);

        $expected_result = 0;
        foreach ($tests as $test) {
            $prod = ProductFactory::new()->create([
                "price" => $test['price']
            ]);

            Cart::create([
                "user_id" => $user->id,
                "product_id" => $prod->id,
                "quantity" => $test['quantity']
            ]);

            $expected_result = $expected_result + $test['quantity'] * $test['price'];
        }

        $method_result = Cart::getCheckoutPrice();
        
        $this->assertTrue($method_result == $expected_result, 
            "Checkout price should be ".$expected_result." but is ".$method_result." instead.");
    }

    public function test_checkout_price_on_empty_carts_is_zero()
    {
        $user = UserFactory::new()->create([
            'role' => "customer"
        ]);

        $this->actingAs($user);
        $this->assertEquals(Cart::getCheckoutPrice(), 0);

    }
}
