<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
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
use Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {

        $data = session('info');
        $total = $data['sub_total']+$data['charge']-$data['discount'];

        $city = City::find($data['city_id']);
        $random_numb = random_int(1000000, 9999999);
        $order_id = '#'.Str::upper(substr($city->name, 0,3)).'-'.$random_numb;


        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
                "amount" => $total * 100,
                "currency" => "bdt",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com."
        ]);

        Order::insert([
            'order_id'=>$order_id,
            'customer_id'=>Auth::guard('customerlogin')->id(),
            'sub_total'=>$data['sub_total'],
            'total'=>$total,
            'charge'=>$data['charge'],
            'discount'=>$data['discount'],
            'payment_method'=>$data['payment_method'],
            'created_at'=>Carbon::now(),
        ]);

        BillingDetails::insert([
            'order_id'=>$order_id,
            'customer_id'=>Auth::guard('customerlogin')->id(),
            'billing_name'=>Auth::guard('customerlogin')->user()->name,
            'billing_email'=>Auth::guard('customerlogin')->user()->email,
            'mobile'=>$data['mobile'],
            'company'=>$data['company'],
            'address'=>Auth::guard('customerlogin')->user()->address,
            'created_at'=>Carbon::now(),
        ]);

        ShippingDetails::insert([
            'order_id'=>$order_id,
            'shipping_name'=>$data['shipping_name'],
            'shipping_email'=>$data['shipping_email'],
            'shipping_mobile'=>$data['shipping_mobile'],
            'shipping_name'=>$data['shipping_name'],
            'country_id'=>$data['country_id'],
            'city_id'=>$data['city_id'],
            'shipping_address'=>$data['shipping_address'],
            'zip'=>$data['zip'],
            'notes'=>$data['notes'],
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

         $total= $total;

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
}
