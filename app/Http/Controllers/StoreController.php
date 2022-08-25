<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Enums\ProductCategory;

class StoreController extends Controller
{
    //

    public function category(ProductCategory $category) {
        $products = Product::available()->where('category', $category)->get();
        return view('Product.index', [
            'products' => $products, 
            'title' => $category->name,
        ]);
    }


    public function search(Request $request) {
        return "YES";
    }
}
