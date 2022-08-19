<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Recupera anche i prodotti associati agli ordini
        // per accesso a DB più efficiente (eager loading)
        //$orders = Order::with('products')->where('user_id', Auth::user()->id)->limit(15);
        $orders = Auth::user()->orders()->with('products')->get();
        return view('Order.index', ['orders' => $orders]);
    }

    public function show(Order $order)
    {
        if ($order->user == Auth::user()){
            return view('Order.show', ['order' => $order]);
        }
        else return redirect('/orders');
    }


    public function store()
    {
        $user_cart = \App\Models\Cart::with('product')->where('user_id',Auth::id())->get();

        // Validazione
        if (empty($user_cart)) {
            return back()->withErrors("Il carrello è vuoto");
        }
        if (Auth::user()->money < $user_cart->first()->getCheckoutPrice()) {
            return back()->withErrors("Saldo insufficiente per completare l'acquisto");
        }

        $order = new Order();
        Auth::user()->orders()->save($order);

        // Conversione carrello -> ordine
        foreach ($user_cart as $cart) {
            if ($cart->product->isAvailable()) {
                $order->products()->attach($cart->product, ['quantity' => $cart->quantity]);
            }
            $cart->delete();
        }

        $order->save();

        // Pagamento
        $user = Auth::user();
        $user->money -= $order->total();
        $user->update();

        return back()->with('success', "Grazie! Il tuo ordine è stato confermato");
    }
    
}
