<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }


    public function test_it_can_add_products() {
        $order = Order::make();
        $order->user_id = User::first()->id;
        $order->save();
        
        $order->add(Product::factory()->create(['quantity' => 4]), 3);
        $order->add(Product::factory()->create(['quantity' => 4]), 3);
        $order->update();

        $this->assertEquals(2, $order->products()->count());
    }

}
