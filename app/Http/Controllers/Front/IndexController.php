<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class IndexController extends Controller
{
    public function index(){

        $page_name = "index";

        // Featured Products
        $featured_products = Product::where(["is_featured"=> "Yes", "status"=> 1])->get();
        $featured_products_count = count($featured_products);
        $featured_products = $featured_products->chunk(4);
        
        // Latest Products
        $latest_products = Product::where('status', 1)->orderBy('id', 'desc')->limit(6)->get();

        return view('front.index')->with(compact('page_name', 'featured_products', 
                                                'featured_products_count', 'latest_products'));
    }
}
