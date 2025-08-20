<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //Public product listing
    public function publicIndex()
    {
        $products = Product::where('tmda_status', 'approved')
                          ->orderBy('name')
                          ->paginate(12);

        return view('products.index', compact('products'));
    }

    // NEW: Public product detail
    public function publicShow(Product $product)
    {
        if ($product->tmda_status !== 'approved') {
            abort(404);
        }

        $relatedProducts = Product::where('tmda_status', 'approved')
                                ->where('id', '!=', $product->id)
                                ->inRandomOrder()
                                ->limit(4)
                                ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
    
    //public function index()
   //{
   //     $products = Product::all();
   //     return view('products', compact('products'));
   //}
}
