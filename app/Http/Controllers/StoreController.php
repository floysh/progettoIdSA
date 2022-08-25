<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class StoreController extends Controller
{
    //

    public function category(Request $request) {
        $category = $request['category'];
        if (array_key_exists($request['category'], Product::categories())) {
            $products = Product::available()->where('category', $category)->get();
            return view('Product.index', [
                'products' => $products, 
                'title' => Product::categories()[$category],
                'tabname' => Product::categories()[$category],
            ]);
        }
        else return redirect()->action('ProductController@show', ['product' => 'category']);
    }


    public function search(Request $request) {
        return "YES";
    }
}
