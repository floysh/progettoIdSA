<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Cart extends Model
{
    use HasFactory;

    //PROTEZIONE COLONNE
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // GLOBAL SCOPE
    // limita di default tutte le query al carrello utente autenticato
    protected static function booted()
    {
        static::addGlobalScope('current_user', function(Builder $builder)  {
            if(Auth::check()) {
                return $builder->where('user_id', '=', Auth::user()->id);
            }
            else return $builder->where('user_id', '=', 0); // Collezione vuota
        });
    }

    // RELAZIONI
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    // METODI
    public function price() {
        return $this->quantity * $this->product->price;
    }

    public static function getCheckoutPrice() {
        $total = 0.0;
        foreach(Cart::all() as $cart) {
            $total += ($cart->quantity * $cart->product->price);
        }
        return $total;
    }


}
