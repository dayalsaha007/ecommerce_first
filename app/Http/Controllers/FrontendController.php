<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\inventory;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;

class FrontendController extends Controller
{
     function index(){
      $category  = Category::all();
      $products  = Product::all();
      return view('frontend.index', [
        'category'=>$category,
        'products'=> $products,
      ]);
     }

     /*---Single Product Page (product_details)----*/

    function product_details($product_id){
        $product_info = Product::find($product_id);
        $galleries = Gallery::where('product_id', $product_id)->get();
        $related_products = Product::where('category_id', $product_info->category_id)->where('id', '!=', $product_id)->get();
        $available_colors = inventory::where('product_id', $product_info->id)
        ->groupBy('color_id')
        ->selectRaw('count(*) as total, color_id')
        ->get();
        $available_sizes = inventory::where('product_id', $product_info->id)
        ->groupBy('size_id')
        ->selectRaw('count(*) as total, size_id')
        ->get();

        $all_review = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->get();
        $total_review = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->count();
        $total_star = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->sum('star');

        return view('frontend.product_details', [
            'product_info'=>$product_info,
            'galleries'=>$galleries,
            'related_products'=>$related_products,
            'available_colors'=>$available_colors,
            'available_sizes'=>$available_sizes,
            'all_review'=>$all_review,
            'total_review'=>$total_review,
            'total_star'=>$total_star,

        ]);
}


/*---Color event on size ajax link----*/
    function get_size(Request $request){
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();

        $str = '';
    foreach($sizes as $size){
            if($size->size_id == 31){
                $str = '<div class="form-check size-option form-option form-check-inline mb-2">
                <input checked class="form-check-input" type="radio" name="size_id"  value="'. $size->size_id .'" id="size'. $size->size_id .'" >
                <label class="form-option-label" for="size'. $size->size_id.'">'. $size->rel_to_size->size_name.'</label>
            </div>';
            }
            else{
                $str .= '<div class="form-check size-option form-option form-check-inline mb-2">
                <input  class="form-check-input" type="radio" name="size_id"  value="'. $size->size_id .'" id="size'. $size->size_id .'" >
                <label class="form-option-label" for="size'. $size->size_id.'">'. $size->rel_to_size->size_name.'</label>
            </div>';
            }


        }

        echo $str;
    }


/*---Review store----*/
function review_store(Request $request){

    OrderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->update([
        'review'=>$request->review,
        'star'=>$request->rating,

    ]);
    return back();

}




}
