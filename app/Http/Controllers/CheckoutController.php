<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use App\Models\OrderProduct;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\inventory;
use App\Models\Order;
use App\Models\ShippingDetails;
use App\Mail\CustomerInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class CheckoutController extends Controller
{
    function checkout(){
        $carts =Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        $countries = Country::all();
        $cities = City::all();
        return view('frontend.checkout.checkout', [
            'carts'=>$carts,
            'countries'=>$countries,
            'cities'=>$cities,
        ]);
    }

    function getcity(Request $request){
        $str = '<option value="">-- Select City --</option>';
        $cities = City::where('country_id', $request->country_id)->get();
        foreach($cities as $city){
            $str .= '<option value="'. $city->id .'">'. $city->name .'</option>';
        }
        echo $str;
    }


    function order_store(Request $request){

        $city = City::find($request->city_id);
        $random_numb = random_int(1000000, 9999999);
        $order_id = '#'.Str::upper(substr($city->name, 0,3)).'-'.$random_numb;

    /*---------COD-----------*/
        if($request->payment_method == 1){

            Order::insert([
                'order_id'=>$order_id,
                'customer_id'=>Auth::guard('customerlogin')->id(),
                'sub_total'=>$request->sub_total,
                'total'=>$request->sub_total+$request->charge - ($request->discount),
                'charge'=>$request->charge,
                'discount'=>$request->discount,
                'payment_method'=>$request->payment_method,
                'created_at'=>Carbon::now(),
            ]);

            BillingDetails::insert([
                'order_id'=>$order_id,
                'customer_id'=>Auth::guard('customerlogin')->id(),
                'billing_name'=>Auth::guard('customerlogin')->user()->name,
                'billing_email'=>Auth::guard('customerlogin')->user()->email,
                'mobile'=>$request->mobile,
                'company'=>$request->company,
                'address'=>Auth::guard('customerlogin')->user()->address,
                'created_at'=>Carbon::now(),
            ]);

            ShippingDetails::insert([
                'order_id'=>$order_id,
                'shipping_name'=>$request->shipping_name,
                'shipping_email'=>$request->shipping_email,
                'shipping_mobile'=>$request->shipping_mobile,
                'shipping_name'=>$request->shipping_name,
                'country_id'=>$request->country_id,
                'city_id'=>$request->city_id,
                'shipping_address'=>$request->shipping_address,
                'zip'=>$request->zip,
                'notes'=>$request->notes,
                'created_at'=>Carbon::now(),


            ]);

            $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
            foreach($carts as $cart){
                OrderProduct::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>Auth::guard('customerlogin')->id(),
                    'price'=>$cart->rel_to_product->after_discount,
                    'product_id'=>$cart->product_id,
                    'color_id'=>$cart->color_id,
                    'size_id'=>$cart->size_id,
                    'quantity'=>$cart->quantity,
                    'created_at'=>Carbon::now(),
                ]);



                inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);

                Cart::find($cart->id)->delete();
            }

            $mail = Auth::guard('customerlogin')->user()->email;
             Mail::to($mail)->send(new CustomerInvoice($order_id));

            //  $total=$request->sub_total+$request->charge - ($request->discount);

            //  $url = "http://66.45.237.70/api.php";
            // $number=$request->mobile;
            // $text="Congratulations! Your order has been placed. Please ready tk".$total;
            // $data= array(
            // 'username'=>"01834833973",
            // 'password'=>"TE47RSDM",
            // 'number'=>"$number",
            // 'message'=>"$text"
            // );

            // $ch = curl_init(); // Initialize cURL
            // curl_setopt($ch, CURLOPT_URL,$url);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $smsresult = curl_exec($ch);
            // $p = explode("|",$smsresult);
            // $sendstatus = $p[0];


            $order_id_new = substr($order_id, 1);
            return redirect()->route('order_success', $order_id_new)->withOrdersuccess('Order added successfully!');


        }
        elseif($request->payment_method == 2){
            $data = $request->all();
            return redirect('/pay')->with('data', $data);

        }
        else{

            $data = $request->all();
            return redirect('/stripe')->with('data', $data);

        }




    }



    function order_success($order_id_new){
        if(session('ordersuccess')){
            return view ('frontend.checkout.order_success', compact('order_id_new'));
        }
        else
         {
            abort('404');
        }

    }





}
