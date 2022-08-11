<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    //RELAZIONI ELOQUENT
    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->as('order_properties');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }


    // METODI
    public function add($product, $quantity = 1) {
        if ($quantity > 0)
            $this->products()->attach($product, ['quantity' => $quantity]);
        else throw new ErrorException("invalid product quantity provided", 1);
        
    }

    public function total() {
        $this->update(); 

        $total = 0.0;
        foreach ($this->products()->get() as $item) {
            $total += $item->price * $item->order_properties->quantity;
        }
        return $total;
    }

}
