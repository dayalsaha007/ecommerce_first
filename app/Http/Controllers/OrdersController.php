<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    public function orders(){

        $orders = Order::all();
        return view('backend.orders.orders', [
            'orders'=>$orders,
        ]);

    }

    public function  status_update (Request $request){

        Order::where('order_id', $request->order_id)->update([
                'status'=>$request->status,
        ]);
        return back();

    }





}
