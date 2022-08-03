<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Product;
use Database\Factories\ProductFactory;

class ProductTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }


    public function test_availability_methods()
    {
        $product = ProductFactory::new()->create();
        
        $this->assertTrue($product->isAvailable());
        $this->assertFalse($product->isNotAvailable());

        $product->disable();
        $this->assertFalse($product->isAvailable());
        $this->assertTrue($product->isNotAvailable());
    }

    public function test_scope_available()
    {
        ProductFactory::new()->create();
        ProductFactory::new()->create();
        ProductFactory::new(['is_disabled' => true])->create();

        $products = Product::available()->get();

        $this->assertTrue($products->count() > 0);

        foreach ($products as $product) {
            $this->assertTrue($product->isAvailable());
        }
    }

    public function test_scope_not_available()
    {
        ProductFactory::new()->create();
        ProductFactory::new()->create();
        ProductFactory::new(['is_disabled' => true])->create();

        $products = Product::notAvailable()->get();

        $this->assertTrue($products->count() > 0);

        foreach ($products as $product) {
            $this->assertFalse($product->isAvailable());
        }
    }


}
