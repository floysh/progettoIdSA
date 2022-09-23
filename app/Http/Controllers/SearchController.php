<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class SearchController extends Controller
{
    // Ricerca tradizionale
    public function search(Request $request) {

        $products = Product::available()
                    ->where("name","LIKE","%{$request['q']}%")
                    ->orWhere("category","LIKE","%{$request['q']}%")
                    ->orWhere("description","LIKE","%{$request['q']}%");
        
        // Se c'è un solo risultato, apri direttamente la pagina del prodotto
        if ($products->count() == 1) return redirect()->action('ProductController@show', ['product' => $products->first()]);;

        return view('Product.index', [
            'products' => $products->get(), 
            'title' => "Risultati per \"{$request['q']}\"",
        ]);
    }

    // Autocompletamento
    public function autocomplete(Request $request) {
        $products = Product::available()
                    ->where("name","LIKE","%{$request['q']}%")
                    ->orWhere("category","LIKE","%{$request['q']}%")
                    ->orWhere("description","LIKE","%{$request['q']}%")
                    ->take(6)->get();

        foreach($products as $product) {
            $product['imgpath'] = $product->imagePath();
        }

        return response()->json($products);
    }
}
