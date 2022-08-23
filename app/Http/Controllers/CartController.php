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
        $cart = Cart::all();
        return view('Store.cart', ['cart' => $cart]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        // Validazione
        $validated = $request->validate([
            'quantity' => 'required | numeric | min:1'
            ]);

        // Aggiornamento
        if ($cart->user == Auth::user()) {
            $cart->update(['quantity' => $validated['quantity']]);
            return back();
        }
        else return back()->withErrors(['user' => 'Questo carrello non è tuo!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        // Permessi
        if ($cart->user == Auth::user()) {
            // Rimetti a posto l'oggetto
            $cart->product->quantity += $cart->quantity;
            $cart->product->update();
            
            // Elimina record
            $cart->delete();
            
            return back();
        }
        else return back()->withErrors(['user' => 'Questo carrello non è tuo!']);
        
    }
}
