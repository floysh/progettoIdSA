<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->customer()->create([
            'name' => 'Elfo Testo',
            'email' => 'elfo@zonko.it'
        ]);
        \App\Models\User::factory()->merchant()->create([
            'name' => 'Helga l\'erborista',
            'email' => 'helga_merchant@zonko.it'
        ]);

        $merchants = \App\Models\User::factory()
                                     ->count(3)
                                     ->merchant()
                                     ->hasProducts(5)
                                     ->create(['money' => 0]);

        $products = \App\Models\Product::all();
        
        $customers = \App\Models\User::factory()
                                     ->count(2)
                                     ->customer()
                                     /* ->has(
                                        \App\Models\Cart::factory()
                                                        ->count(3)
                                                        ->for($products->random())
                                                        ->state(new Sequence(
                                                            fn ($sequence) => ['product_id' => UserRoles::all()->random()],
                                                        ))
                                     ) */
                                     ->create(['money' => 5000]);

        foreach ($customers as $user) {
            \App\Models\Cart::factory()
                            ->count(3)
                            ->for($user)
                            ->state(new Sequence(
                                fn ($sequence) => ['product_id' => $products->random()],
                            ))
                            ->create();
        }

    }
}
