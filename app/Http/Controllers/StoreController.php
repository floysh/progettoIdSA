<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Enums\ProductCategory;

class StoreController extends Controller
{
    public function home(Request $request) {
        return view('home', [
            'spotlightTitle' => "Preparati per l'Ovest Proibito",
            'spotlightSubtitle' => "Zaini e pozioni antiscottature per non farsi sopraffarre dai pericoli delle montagne rocciose.",
            'spotlightUrl' => action('StoreController@category', 'object'),
            'spotlightBackgroundImageUrl' => 'https://i.pinimg.com/originals/ee/0a/47/ee0a47d7342f4ab1db5590793875d53c.png',
            'reels' => [
                [
                    'title' => 'Novità',
                    'products' => Product::orderBy('created_at','DESC')->get(),
                    'url' => '/search?order-by=created_at:desc'
                ],
                [
                    'title' => 'Pozioni per tutte le evenienze',
                    'products' => Product::available()->where('category','object')->orderBy('created_at','DESC')->get(),
                    'url' => '/search?q=Pozione&category=object&order-by=created_at:desc'
                ],
                [
                    'title' => 'Armi esclusive per i portafogli più esclusivi',
                    'products' => Product::available()->where('category','weapon')->orderBy('price','DESC')->get(),
                    'url' => action('StoreController@category','weapon')
                ],
            ]
        ]);
    }

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
