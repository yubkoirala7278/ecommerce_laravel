<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductControler extends Controller
{
    public function index($slug){
        $product=Product::with('images','product_ratings')->where('slug',$slug)->withCount('product_ratings')->withSum('product_ratings','rating')->first();
        $relatedProducts = Product::latest()
        ->with('images')
        ->where('category_id', $product->category_id)
        ->where('id', '!=', $product->id) // Exclude the current product by ID
        ->get();
        // calculate average rating and total rating of the specific product
        $avgRating='0.00';
        $avgRatingPercentage=0;
        if($product->product_ratings_count>0){
            $avgRating=number_format(($product->product_ratings_sum_rating/$product->product_ratings_count),2);
            $avgRatingPercentage=($avgRating*100)/5;
        }
        $product['avgRating']=$avgRating;
        $product['avgRatingPercentage']=$avgRatingPercentage;
        return view('public.product.index',compact('product','relatedProducts'));
    }
}
