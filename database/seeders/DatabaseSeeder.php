<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Cart;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $merchants = User::factory()
                            ->count(3)
                            ->merchant()
                            ->hasProducts(5)
                            ->create(['money' => 0]);

        $products = Product::all();
        
        $customers = User::factory()
                            ->count(2)
                            ->customer()
                            /* ->has(
                            Cart::factory()
                                ->count(3)
                                ->for($products->random())
                                ->state(new Sequence(
                                    fn ($sequence) => ['product_id' => UserRoles::all()->random()],
                                ))
                            ) */
                            ->create(['money' => 5000]);

        // Seed dei carrelli senza prodotti duplicati
        foreach ($customers as $user) {
            Cart::factory()
                    ->count(3)
                    ->for($user)
                    ->state(new Sequence(
                        fn ($sequence) => ['product_id' => $products->random()],
                    ))
                    ->create();
                }

        // Gli utenti che usavo per i test manuali
        User::factory()->customer()->create([
            'name' => 'Elfo Testo',
            'email' => 'elfo@zonko.it'
        ]);
        User::factory()->merchant()->create([
            'name' => 'Helga l\'erborista',
            'email' => 'helga_merchant@zonko.it'
        ]);
    }
}
