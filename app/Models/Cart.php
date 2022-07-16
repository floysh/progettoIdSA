<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Cart extends Model
{
    use HasFactory;

    // GLOBAL SCOPE
    // limita di default tutte le query al carrello utente autenticato
    protected static function booted()
    {
        static::addGlobalScope('current_user', function(Builder $builder)  {
            $builder->where('user_id', '=', Auth::user()->id);
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



}
