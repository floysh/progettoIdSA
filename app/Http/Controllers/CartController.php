<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Se l'utente non ha un carrello non c'è niente da vedere
        $this->authorize('create', Cart::class);

        $cart = Cart::with('product')->get();
        return view('Cart.cart', ['cart' => $cart]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Cart::class);

        // Validazione
        $validated = $request->validate([
            'product_id' => 'required | numeric | min:1',
            'quantity' => 'required | numeric | min:1'
            ]);

        $product = Product::findOrFail($validated['product_id']);
        if (!$product || $product->isNotAvailable()) {
            return back()->withErrors('"'.$product->name.'" non può essere acquistato');
        }
        elseif ($validated['quantity'] > $product->quantity) {
            
            return back()->withErrors('Le scorte di "'.$product->name.'" non sono sufficienti');
        }

        //
        // Nel carrello non devono esserci prodotti duplicati
        //
        $cart_item = Auth::user()->cart()
                    ->where('product_id', $validated['product_id'])
                    ->first();
        
        if($cart_item) { // Aggiornamento record esistente
            $product->quantity += $cart_item->quantity;
            $cart_item->update(['quantity' => $validated['quantity']]);
        }
        else { // Creazione nuovo record
            $cart_item = Cart::make([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
            ]);
            $cart_item->user_id = Auth::user()->id;
            $cart_item->save();
        }

        // Aggiorna disponibilità prodotto
        $product->quantity -= $validated['quantity'];
        $product->update();

        return back();    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        $this->authorize('update', $cart);

        // Validazione
        $validated = $request->validate([
            'quantity' => 'required | numeric | min:1'
            ]);
            
        // Rimetti a posto i prodotti rimossi
        $cart->product->quantity += $cart->quantity;
        $cart->product->quantity -= $validated['quantity'];
        $cart->product->update();
        
        // Aggiorna il carrello
        $cart->update(['quantity' => $validated['quantity']]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $this->authorize('delete', $cart);
        
        // Rimetti a posto l'oggetto
        $cart->product->quantity += $cart->quantity;
        $cart->product->update();
        
        // Elimina record
        $cart->delete();
        
        return back();
        
    }
}
