<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Recupera anche i prodotti associati agli ordini
        // per accesso a DB più efficiente (eager loading)
        //$orders = Order::with('products')->where('user_id', Auth::user()->id)->limit(15);
        $orders = Order::with('products')->where('user_id', Auth::id())->orderBy('created_at','desc')->get();
        return view('Order.index', ['orders' => $orders]);
    }

    public function show(Order $order)
    {
        if ($order->user == Auth::user()){
            return view('Order.show', ['order' => $order]);
        }
        else return redirect('/orders');
    }


    public function store(Request $request)
    {
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

        $order = new Order();
        $user->orders()->save($order);

        // Conversione carrello -> ordine
        foreach ($cart_products as $product) {
            $order->products()->attach($product, ['quantity' => $product->cart->first()->quantity]);
        }
        
        $order->save();
        $user->cart()->delete();

        // Pagamento
        $user = Auth::user();
        $user->money -= $order->total();
        $user->update();

        return redirect('/')->with('success', "Grazie! Il tuo ordine è stato confermato");
    }
    
}
