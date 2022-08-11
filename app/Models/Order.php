<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    //RELAZIONI ELOQUENT
    public function products() {
        return $this->belongsToMany(Product::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    // GLOBAL SCOPE
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('current_user', function(Builder $builder)  {
            if (Auth::check()) $builder->where('user_id', '=', Auth::user()->id);
            else return $builder->where('user_id', '<', 0); //per fare una collection vuota
        });
    }

    // METODI
    // [TODO]

}
