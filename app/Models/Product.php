<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductCategory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'category' => ProductCategory::class,
    ];

    // PROTEZIONE COLONNE
    // (solo) questi attributi NON saranno modificabili attraverso controller@update
    protected $protected = ['id','merchant_id'];
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
        return $query->where('is_disabled','=', false);             //così restituisce un Builder
        //return $query->where('is_disabled','=', false)->get();    //così restituisce un Collection (praticamente un array, con questo non si possono più usare le relazioni)
    }

    public function scopeNotAvailable($query) {
        return $query->where('is_disabled','=', true);
    }

    public function scopeOfCategory($query, $categoryID) {
        return $query->where('category','=',$categoryID);
    }


    // RELAZIONI ELOQUENT
    public function cart() {
        return $this->hasMany(Cart::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class);
    }

    public function merchant() {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    

    // METODI

    public function disable() {
        //$this->update(['is_disabled' => true]); // aggiornava record DB ma non l'oggetto in memoria(?)
        $this->is_disabled = true;
        $this->update();
    }

    public function enable() {
        //$this->update(['is_disabled' => false]);
        $this->is_disabled = false;
        $this->update();
    }

    
    public function isAvailable() {
        return ($this->is_disabled == false);
    }
    
    public function isNotAvailable() {
        return (! $this->isAvailable());
    }

    public function imagePath() {
        $image_path = 'images/products/'.$this->imagepath;
        $category_placeholder_path = 'images/placeholders/'.$this->category->value.'.svg';
        
        if (file_exists($image_path)) {
            return asset($image_path);
        }
        elseif(file_exists($category_placeholder_path)) {
            return asset($category_placeholder_path);
        }
        else return asset('images/placeholders/product.svg');
    }

    public function category() {
        return $this->category->name;
    }
}