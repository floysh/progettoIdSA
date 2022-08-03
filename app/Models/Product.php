<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // PROTEZIONE COLONNE
    // (solo) questi attributi NON saranno modificabili attraverso controller@update
    protected $protected = ['id'];
    // soltanto questi attributi saranno modificabili attraverso controller@update
    protected $fillable = ['name','category', 'imagepath', 'quantity', 'description','price','is_disabled'];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_disabled' => false,
        'imagepath' => 'images/dummy.png',
    ];

    // QUERY SCOPE
    //metodi per definire filtri da applicare alle query
    //con Eloquent o QueryBuilder

    public function scopeAvailable($query) {
        /* I query scope devono restituire oggetti Builder o si perdono alcune funzioni (es. relazioni) */
        return $query->where('is_disabled','=', 0);             //così restituisce un Builder
        //return $query->where('is_disabled','=', 0)->get();    //così restituisce un Collection (praticamente un array, con questo non si possono più usare le relazioni)
    }

    public function scopeNotAvailable($query) {
        return $query->where('is_disabled','=', 1);
    }

    public function scopeOfCategory($query, $categoryID) {
        return $query->where('category','=',$categoryID);
    }


    // RELAZIONI ELOQUENT
    //  TODO: ordini

    public function cart() {
        return $this->hasMany(Cart::class);
    }
    

    // METODI
    public static function categories() {
        return [
            'weapon' => 'Armi',
            'spell' => 'Magie', 
            'object' => 'Oggetti',
            'wearable' => 'Accessori'
        ];
    }

    public function disable() {
        $this->update(['is_disabled' => true]);
    }

    public function enable() {
        $this->update(['is_disabled' => false]);
    }

    
    public function isAvailable() {
        return ($this->is_disabled == 0);
    }
    
    public function isNotAvailable() {
        return (! $this->isAvailable());
    }
}