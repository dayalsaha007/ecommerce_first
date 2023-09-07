<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function cart_store(Request $request){


  if(Auth::guard('customerlogin')->id()){
    if(Cart::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){
        Cart::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);

        return back();
    }
    else{
        Cart::insert([
            'customer_id'=>Auth::guard('customerlogin')->id(),
            'product_id'=>$request->product_id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('cart_added', 'Cart added Successfully');
    }

  }
  else
  {
    return redirect()->route('customer_register_login')->with('log', 'please login first');

  }

}

/*-------cart remove-------*/
function remove_cart($cart_id){
    Cart::find($cart_id)->delete();
    return back();
}

/*-------cart show-------*/
function cart (Request $request){

    $discount = 0;
    $type = '';
    $message = '';

    if(isset($request->coupon_name)){
        if(Coupon::where('coupon_name', $request->coupon_name)->exists()){
            if(Carbon::now()->format('Y-m-d') <= Coupon::where('coupon_name', $request->coupon_name)->first()->expire_date){
                if(Coupon::where('coupon_name', $request->coupon_name)->first()->type==1){
                    $type = 1;
                    $discount = 21;
                }
                else{
                    $type = 2;
                    $discount = 100;
                }
            }
            else
            {
                $discount = 0;
                $message = 'Coupon code expired';
            }
        }
        else{
            $discount = 0;
                $message = 'Coupon code does not exists';

        }

    }

    $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
    return view('frontend.cart.cart', [
        'carts'=>$carts,
        'discount'=>$discount,
        'type'=>$type,
        'message'=>$message,
    ]);
}

/*-------cart update-------*/

function cart_update(Request $request){
    foreach($request->quantity as $cart_id=>$quantity){
        Cart::find($cart_id)->update([
            'quantity'=>$quantity,
        ]);
    }
    return back();


}





}



