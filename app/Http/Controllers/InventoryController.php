<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\inventory;
use App\Models\Product;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{

        function variation(){
            $categories = Category::all();
            $colors = Color::all();
            $sizes = Size::all();
            return view('backend.product.variation', [
                'categories'=>$categories,
                'colors'=>$colors,
                'sizes'=>$sizes ,
            ]);
        }

        function insert_color(Request $request){

                Color::insert([
                    'color_name'=>$request->color_name,
                    'color_code'=>$request->color_code,
                    'created_at'=>Carbon::now(),
                ]);
            return back();
        }

        function insert_size(Request $request){
                Size::insert([
                    'category_id'=>$request->category_id,
                    'size_name'=>$request->size_name,
                    'created_at'=>Carbon::now(),
                ]);

            return back();
        }

        /*-------add form inventory----*/
        function product_inventory($product_id){
            $colors = Color::all();
            $product_info = Product::find($product_id);
            $sizes = Size::where('category_id', $product_info->category_id)->get();
            $inventories = inventory::where('product_id', $product_id)->get();
            return view('backend.product.inventory', [
                'colors'=>$colors,
                'sizes'=>$sizes ,
                'product_info'=>$product_info,
                'inventories'=>$inventories,
            ]);
        }

        /*-------store inventory----*/
        function store_inventory(Request $request){

            $request->validate([
                'quantity'=>'required',
            ]);

            if(inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){

                inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
            return back();
            }
            else
            {
                inventory::insert([
                    'product_id'=>$request->product_id,
                    'color_id'=>$request->color_id,
                    'size_id'=>$request->size_id,
                    'quantity'=>$request->quantity,
                    'created_at'=>Carbon::now(),
                ]);
                return back();
            }
        }
    /*-------delete color----*/
        function delete_color($id){

            Color::find($id)->delete();
            return back();

        }

        /*-------delete size----*/
        function delete_size($id){
            Size::find($id)->delete();
            return back();
        }






}
