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
        // TODO: Validazione

        $product = Product::available()->findOrFail($request['product_id']);

        if ($product->isNotAvailable()) {
            return back()->withErrors('"'.$product->name.'" non può essere acquistato');
        }
        elseif ($request['quantity'] > $product->quantity) {
            
            return back()->withErrors('Le scorte di "'.$product->name.'" non sono sufficienti');
        }

        // Aggiorna record esistente o crealo ex novo se non c'è 
        // (niente duplicati)
        $cart_item = Auth::user()->cart()
                    ->where('product_id', $request['product_id'])
                    ->first();
        
        if($cart_item == null) {
            $cart_item = Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request['product_id'],
                'quantity' => $request['quantity'],
            ]);
        }
        else {
            $product->quantity += $cart_item->quantity;
            $cart_item->update(['quantity' => $request['quantity']]);
        }

        

        // Aggiorna disponibilità prodotto
        $product->quantity -= $request['quantity'];
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        // TODO: Validazione

        
        // Rimetti a posto l'oggetto
        $cart->product->quantity += $cart->quantity;
        $cart->product->update();
        
        // Elimina record
        $cart->delete();
        
        return back();
    }
}
