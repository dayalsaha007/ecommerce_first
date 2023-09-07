<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\inventory;
use App\Models\Product;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;
use Image;

class ProductController extends Controller
{
/*--------Add product---------*/
    public function add_product(){

        $category = Category::all();
        $subcategory = Subcategory::all();
        $brands = Brand::all();

        return view('backend.product.add_product', [
            'category' => $category,
            'subcategory' => $subcategory,
            'brands' => $brands,
        ]);

    }
/*--------All product---------*/
    public function all_product(){

        $products = Product::all();
        return view('backend.product.all_product', [
            'products'=>$products,
        ]);

    }

/*--------Ajax link---------*/
public function getsubcategory (Request $request){

    $subcategories = Subcategory::where('category_id', $request->category_id)->get();

        $str = '<option value="">--select any--</option>';

        foreach($subcategories as $subcategory){
            $str .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';

        }

        echo $str;

}


   /*--------Product Insert---------*/
   public function product_store(Request $request){

    $random_number = random_int(100000, 999998);
    $random_number2 = random_int(1000000, 9999989);

    $sku = Str::Upper(str_replace(' ', '-', substr($request->product_name, 0,2))).'-'.$random_number;
    $slug = Str::lower(str_replace(' ', '-', $request->product_name)).'-'.$random_number2;

    $category_id = $request->category_id;
    $subcategory_id = $request->subcategory_id;
    $brand_id = $request->brand_id;
    $category_name = Category::where('id', $category_id)->value('category_name');
    $subcategory_name = Subcategory::where('id', $subcategory_id)->value('subcategory_name');
    // $brand_name = Brand::where('id', $brand_id)->value('brand_name');

    $product_id =  Product::insertGetId([
        'product_name'=>$request->product_name,
        'price'=>$request->price,
        'discount'=>$request->discount,
        'after_discount'=>$request->price - ($request->price*$request->discount)/100,
        'category_id'=>$category_id,
        'subcategory_id'=>$subcategory_id,
        'category_name'=>$category_name,
        'subcategory_name'=>$subcategory_name,
        'brand'=>$brand_id,
        'short_desp'=>$request->short_desp,
        'long_desp'=>$request->long_desp,
        'add_info'=>$request->add_info,
        'sku'=>$sku,
        'slug'=>$slug,
        'created_at'=>Carbon::now(),

    ]);



    /*--------Preview Update---------*/
    if($request->preview != ''){

        $preview_image = $request->preview;
        $random_number = random_int(100000, 999998);
        $ext = $preview_image->getClientOriginalExtension();
        $file_name = Str::lower(str_replace(' ', '-', $request->product_name)).'-'.$random_number.'.'.$ext;

        Image::make($preview_image)->save(public_path('backend/uploads/preview/'.$file_name));

        Product::find($product_id)->update([
            'preview'=>$file_name,
            'updated_at'=>Carbon::now(),

        ]);

    }

    /*--------Gallery Insert---------*/
        $gallery_images =$request->gallery;
        if( $gallery_images != ''){

            foreach( $gallery_images as $sl=>$gall){
                $gallery_ext = $gall->getClientOriginalExtension();
                $gallery_name = Str::lower(str_replace(' ', '-', $request->product_name)).'-'.$sl.$random_number2.'.'.$gallery_ext;

                Image::make($gall)->save(public_path('backend/uploads/gallery/'.$gallery_name));

                Gallery::insert([
                            'product_id'=>$product_id,
                            'gallery'=>$gallery_name,
                            'created_at'=>Carbon::now(),
                        ]);

            }
        }

     Category::where('id', $category_id)->increment('product_count', 1);
     Subcategory::where('id', $subcategory_id)->increment('product_count', 1);

    return redirect()->route('add_product')->with('p_msg', 'Product inserted successfully');

}


/*--------Edit Product--------*/
    function edit_product($id){

        $brands = Brand::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $product_info = Product::find($id);
        $gallery_images = Gallery::where('product_id', $product_info->id)->get();

        return view('backend.product.edit_product', [
            'product_info'=>$product_info,
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'brands'=>$brands,
            'gallery_images'=>$gallery_images,
        ]);

    }


 /*--------Update Product--------*/
    function update_product(Request $request){

            $preview_image = $request->preview;
            $gallery_images = $request->gallery;
            $product_id = $request->product_id;
            $category_id = $request->category_id;
            $subcategory_id = $request->subcategory_id;
            $brand_id = $request->brand_id;
            $random_number2 = random_int(1000000, 9999989);
            $category_name = Category::where('id', $category_id)->value('category_name');
            $subcategory_name = Subcategory::where('id', $subcategory_id)->value('subcategory_name');

         /*--------If preview null--------*/
            if($preview_image == '')
            {
                /*--------If gallery null--------*/
                 if($gallery_images == ''){

                    Product::find($product_id)->update([

                        'product_name'=>$request->product_name,
                        'price'=>$request->price,
                        'discount'=>$request->discount,
                        'after_discount'=>$request->price - ($request->price*$request->discount)/100,
                        'category_id'=>$category_id,
                        'subcategory_id'=>$subcategory_id,
                        'category_name'=>$category_name,
                        'subcategory_name'=>$subcategory_name,
                        'brand'=>$brand_id,
                        'short_desp'=>$request->short_desp,
                        'long_desp'=>$request->long_desp,
                        'add_info'=>$request->add_info,
                        'created_at'=>Carbon::now(),

                    ]);


            }
            /*--------If gallery not null--------*/
            else{

                $present_gallery = Gallery::where('product_id', $product_id)->get();
                foreach($present_gallery as $galle){
                    $delete_from = public_path('backend/uploads/gallery/'.$galle->gallery);
                    unlink($delete_from);

                    Gallery::where('product_id', $galle->product_id)->delete();

                 }

                foreach( $gallery_images as $sl=>$gall){
                    $gallery_ext = $gall->getClientOriginalExtension();
                    $gallery_name = Str::lower(str_replace(' ', '-', $request->product_name)).'-'.$sl.$random_number2.'.'.$gallery_ext;

                    Image::make($gall)->save(public_path('backend/uploads/gallery/'.$gallery_name));

                    Gallery::insert([
                                'product_id'=>$product_id,
                                'gallery'=>$gallery_name,
                                'created_at'=>Carbon::now(),
                            ]);

                }

            }
          }
            else /*--------If preview not null--------*/
            {/*--------If gallery null--------*/
                if($gallery_images == ''){

                    $present_images = Product::find($product_id);
                    $delete_form = public_path('backend/uploads/preview/'.$present_images->preview);
                    unlink($delete_form);


                    $random_number = random_int(100000, 999998);
                    $ext = $preview_image->getClientOriginalExtension();
                    $file_name = Str::lower(str_replace(' ', '-', $request->product_name)).'-'.$random_number.'.'.$ext;

                    Image::make($preview_image)->save(public_path('backend/uploads/preview/'.$file_name));

                    Product::find($product_id)->update([

                        'product_name'=>$request->product_name,
                        'price'=>$request->price,
                        'discount'=>$request->discount,
                        'after_discount'=>$request->price - ($request->price*$request->discount)/100,
                        'category_id'=>$category_id,
                        'subcategory_id'=>$subcategory_id,
                        'category_name'=>$category_name,
                        'subcategory_name'=>$subcategory_name,
                        'brand'=>$brand_id,
                        'short_desp'=>$request->short_desp,
                        'long_desp'=>$request->long_desp,
                        'add_info'=>$request->add_info,
                        'preview'=>$file_name,
                        'created_at'=>Carbon::now(),

                    ]);

                }
                else{ /*--------If gallery not null--------*/

                    /*- preview --*/
                    $present_images = Product::find($product_id);
                    $delete_form = public_path('backend/uploads/preview/'.$present_images->preview);
                    unlink($delete_form);


                    $random_number = random_int(100000, 999998);
                    $ext = $preview_image->getClientOriginalExtension();
                    $file_name = Str::lower(str_replace(' ', '-', $request->product_name)).'-'.$random_number.'.'.$ext;

                    Image::make($preview_image)->save(public_path('backend/uploads/preview/'.$file_name));


                /*- Gallery --*/
                 $present_gallery = Gallery::where('product_id', $product_id)->get();
                foreach($present_gallery as $galle){
                    $delete_from = public_path('backend/uploads/gallery/'.$galle->gallery);
                    unlink($delete_from);

                  Gallery::where('product_id', $galle->product_id)->delete();

                 }

                foreach( $gallery_images as $sl=>$gall){
                    $gallery_ext = $gall->getClientOriginalExtension();
                    $gallery_name = Str::lower(str_replace(' ', '-', $request->product_name)).'-'.$sl.$random_number2.'.'.$gallery_ext;

                    Image::make($gall)->save(public_path('backend/uploads/gallery/'.$gallery_name));

                    Gallery::insert([
                                'product_id'=>$product_id,
                                'gallery'=>$gallery_name,
                                'created_at'=>Carbon::now(),
                            ]);

                }

                    Product::find($product_id)->update([

                        'product_name'=>$request->product_name,
                        'price'=>$request->price,
                        'discount'=>$request->discount,
                        'after_discount'=>$request->price - ($request->price*$request->discount)/100,
                        'category_id'=>$category_id,
                        'subcategory_id'=>$subcategory_id,
                        'category_name'=>$category_name,
                        'subcategory_name'=>$subcategory_name,
                        'brand'=>$brand_id,
                        'short_desp'=>$request->short_desp,
                        'long_desp'=>$request->long_desp,
                        'add_info'=>$request->add_info,
                        'preview'=>$file_name,
                        'created_at'=>Carbon::now(),

                    ]);

                }

            }

            return  back();

    }






}
