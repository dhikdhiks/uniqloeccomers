<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request){
        $size = $request->query('size') ? $request->query('size') : 12;
        $products = Product::orderBy('created_at', 'DESC')->paginate($size);
        return view('shop', compact('products', 'size'));
    }
    public function product_details($products_slug){
        $product = Product::where('slug', $products_slug)->first();
        $rproducts = Product::where('slug','<>',$products_slug)->get()->take(8);
        return view('details', compact('product', 'rproducts'));
    }

}
