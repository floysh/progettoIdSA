<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        // Recupera anche i prodotti associati agli ordini
        // per accesso a DB più efficiente (eager loading)
        //$orders = Order::with('products')->where('user_id', Auth::user()->id)->limit(15);
        $orders = Order::with('products');
        
        if (Auth::user()->isMerchant()) {
            # ordini dell'utente
            $orders = $orders
                ->with('user')
                ->whereHas('products', function($productQuery) { 
                    $productQuery->whereHas('merchant', function($userQuery){  $userQuery->where('id', Auth::user()->id); });
                });
        } 
        else {
            # mostra gli ordini dei clienti
            $orders = $orders
                ->where('user_id', Auth::id());
        }
     
        
        return view('Order.index', ['orders' => $orders->orderBy('created_at','desc')->get()]);
    }

    public function show(Order $order)
    {
        if (Auth::user()->is($order->user)){
            return view('Order.show', ['order' => $order]);
        }
        else return redirect('/orders');
    }


    public function store(Request $request)
    {
        // Chi non può usare il carrello non può creare ordini
        $this->authorize('create', Cart::class);

        $user = Auth::user();
        $user_cart = $user->cart()->where('user_id', $user->id)->get();

        // Validazione
        if ($user_cart->isEmpty()) {
            return back()->withErrors("Il carrello è vuoto");
        }
        if (Auth::user()->money < $user_cart->first()->getCheckoutPrice()) {
            return back()->withErrors("Saldo insufficiente per completare l'acquisto");
        }
        if (Product::notAvailable()->has('cart')->exists()) {
            return back()->withErrors("Uno o più prodotti nel carrello non possono essere acquistati");
        }

        $cart_products = Product::available()->has('cart')->with('cart:id,product_id,quantity')->get();

        DB::transaction(function () use ($user, $cart_products): void {
            $order = new Order();
            $user->orders()->save($order);
            
            
            // Conversione carrello -> ordine
            foreach ($cart_products as $product) {
                $order->products()->attach($product, ['quantity' => $product->cart->first()->quantity]);
                // Accredito soldini al mercante
                $product->merchant->money += $product->cart->first()->price();
                $product->merchant->update();
            }
            
            $order->save();
            $user->cart()->delete();
            
            // Pagamento
            $user = Auth::user();
            $user->money -= $order->total();
            $user->update();
        

        });
        
        return redirect('/')->with('success', "Grazie! Il tuo ordine è stato confermato");
    }
    
}
