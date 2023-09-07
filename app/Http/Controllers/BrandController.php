<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;
use Image;

class BrandController extends Controller
{

    /*--------Add brands---------*/
    function add_brands (){
        return view('backend.brand.add_brand');

    }
 /*--------All brands---------*/
    function all_brands (){
        $brand = Brand::all();
        return view('backend.brand.all_brand', [
            'brand'=>$brand,
        ]);

    }
 /*-------Insert brands---------*/
    function insert_brands (Request $request){

        $request->validate([
            'brand_name'=>'required',
            'brand_image'=>'image',
        ]);


        $brand_id =   Brand::insertGetId([
            'brand_name'=>$request->brand_name,

        ]);

        if($request->brand_image != ""){

            $brand_image = $request->brand_image;
            $ext = $brand_image->getClientOriginalExtension();
            $random_numb = random_int(1000000, 9999998);
            $file_name = Str::lower(str_replace(' ', '-', $request->brand_name))."-".$random_numb.".".$ext;

            Image::make($brand_image)->save(public_path('backend/uploads/brand_image/'.$file_name));

            Brand::find($brand_id)->update([
                'brand_image'=>$file_name,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

            ]);

        }

        return redirect()->route('add_brands')->with('b_msg', 'Brand added successfully');


    }












}
