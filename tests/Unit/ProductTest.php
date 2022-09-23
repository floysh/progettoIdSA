<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Product;

class ProductTest extends TestCase
{

    use RefreshDatabase;

    

    public function test_it_has_a_merchant()
    {
        $product = Product::factory()->create();
        $this->assertTrue($product->merchant()->exists());
    }

    public function test_it_has_a_cart_entry()
    {
        $product = Product::factory()->create();
        $this->assertTrue($product->merchant()->exists());
    }

    public function test_availability_methods()
    {
        $product = Product::factory()->make();
        
        $this->assertTrue($product->isAvailable());
        $this->assertFalse($product->isNotAvailable());

        // test disable method
        $product->disable();
        $this->assertFalse($product->isAvailable());
        $this->assertTrue($product->isNotAvailable());

        // test re-enablement
        $product->enable();
        $this->assertTrue($product->isAvailable());
        $this->assertFalse($product->isNotAvailable());
    }

    public function test_scope_available()
    {
        Product::factory()->create();
        Product::factory()->create();

        $products = Product::available()->get();

        $this->assertTrue($products->count() > 0);

        foreach ($products as $product) {
            $this->assertTrue($product->isAvailable());
        }
    }

    public function test_scope_not_available()
    {
        Product::factory()->create();
        Product::factory()->create();
        Product::factory()->create(['is_disabled' => true]);

        $products = Product::notAvailable()->get();

        $this->assertTrue($products->count() > 0);

        foreach ($products as $product) {
            $this->assertFalse($product->isAvailable());
        }
    }


}
