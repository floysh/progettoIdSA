<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $validationRules = [
        "name" => "required | min:3",
        "category" => "required | in:weapon,spell,object,wearable",
        "description" => "required | min: 5",
        "price" => "numeric | min:0 | max:999999999",
        "quantity" => "integer | min: 0 | max:999999999",
        "imagepath" => "string",
        "is_disabled" => "sometimes | boolean",
        "merchant_id" => "sometimes | integer",
    ];
    protected $validationMessages = [
        'name.required' => '\':attribute\' non può essere vuoto.',
        'name.description' => 'Il prodotto deve avere una breve descrizione.',
        'category.required' => 'Devi selezionare una categoria.',
        'category.integer' => '\':attribute\' non ha un valore valido.'
    ];
    protected $attributeNames = [
        "name" => "nome prodotto",
        "category" => "categoria prodotto",
        "description" => "descrizione",
        "price" => "prezzo",
        "quantity" => "quantità",
        "imagepath" => "immagine prodotto"

    ];


    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        // Tutti i prodotti acquistabili
        $title = "Tutti i prodotti";
        $products = Product::available();
        
        return view('Product.index', [
            'products' => $products->get(),
            'title' => $title,
            'tabname' => $title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Product::class);

        return view('Product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Autorizzazione con Policy!
        $this->authorize('create', Product::class);

        //Validazione
        $validated = Validator::make(
            $request->all(),
            $this->validationRules, $this->validationMessages, $this->attributeNames
        )->validate();
        //return $validated; // validate() restituisce un array coi nomi dei campi che hanno superato la validazione

        if( ! $request->has('price')) {
            $validated['price'] = 0.0;
        }
        if( ! $request->has('imagepath')) {
            $validated['imagepath'] = 'dummy.png'; // immagine generica
        }
        // Associa il nuovo prodotto al mercante
        $product = Auth::user()->products()->create($validated);

        return redirect('/products/'.$product->id);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('Product.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('update',$product);

        return view('Product.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update',$product);

        //Validazione
        $validated = Validator::make(
            $request->all(),
            $this->validationRules, $this->validationMessages, $this->attributeNames
        )->validate();

        //Elaborazione
        $product->update($validated);

        return redirect('/products/'.$product->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete',$product);

        $product->disable();
        return back();

    }

    /**
     * Increments the specified resource availability.
     *
     * @param \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function refill(Request  $request, Product $product)
    {
        $this->authorize('update',$product);

        $validated = $validated = Validator::make(
            $request->all(),
            ["quantity" => "integer | min: 0 | max:999999999",], 
            $this->validationMessages, $this->attributeNames
        )->validate();

        $product->quantity += $validated['quantity'];
        $product->save();

        return back();
    }
}
