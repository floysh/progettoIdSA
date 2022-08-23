<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

use Database\Factories\ProductFactory;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $product1 = ProductFactory::new()->create();
        $product2 = ProductFactory::new()->create();
        $product3 = ProductFactory::new()->create();
        $product_na = ProductFactory::new(['name' => 'Missingno', 'is_disabled' => true])->create();

        $user = \Database\Factories\UserFactory::new()->create();
    }


    public function test_it_can_add_products() {
        $order = Order::make();
        $order->user_id = User::first()->id;
        $order->save();
        
        $order->add(Product::find(1), 3);
        $order->add(Product::find(2), 3);
        $order->update();

        $this->assertEquals(2, $order->products()->count());
    }

}
