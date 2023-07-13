<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
// use \Debugbar;

class ProductController extends Controller
{
    public function listing($url){
        $categoryExists = Category::where(['url'=> $url, 'status'=> 1])->exists();
        if($categoryExists){

            $categoryDetails = Category::categoryByUrl($url);
            // dd($categoryDetails->parentCategory);
            if($categoryDetails->parent_id == 0){
                $breadcrum = "<a href=".$categoryDetails->url.">". $categoryDetails->category_name ."</a>";
            }else{
                $breadcrum = "<a href=".$categoryDetails->parentCategory->url.">". $categoryDetails->parentCategory->category_name ."</a> &nbsp; / &nbsp; <a href=".$categoryDetails->url.">". $categoryDetails->category_name ."</a>";
            }
            
            // $categoryIDs = [];
            // $categoryIDs[] = $categoryDetails['id'];
            $categoryIDs = array_merge([$categoryDetails['id']], $categoryDetails->subCategories->pluck('id')->toArray());
            // Debugbar::info("ds");
            // Debugbar::error('Error!');
            // dd($categoryIDs);
            // foreach($categoryDetails['subCategories'] as $key => $subCategory){
            //     $categoryIDs[] = $subCategory['id'];
            // }
            $products = Product::with('brand')->whereIn('category_id', $categoryIDs)->where('status', 1)->get();
            
            return view('front.products.listing')->with(compact('products', 'categoryDetails', 'breadcrum'));
        }
        else{
            abort(404);
        }
    }
}
