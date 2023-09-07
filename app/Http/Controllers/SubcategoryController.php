<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;
use Image;

class SubcategoryController extends Controller
{
    /*----Add Subcategory  -----*/
    public function add_sub_category(){


        $categories = Category::all();
        return view('backend.subcategory.add_sub_category', [

            'categories'=> $categories,
        ]);

    }
/*----All Subcategory  -----*/
    public function all_sub_category(){
        $subcategories = Subcategory::all();
        return view('backend.subcategory.all_sub_category', [
            'subcategories'=> $subcategories,
        ]);

    }


/*---- Subcategory Insert -----*/
    function store_subcat(Request $request){

        $request->validate([
            'subcategory_name'=> 'required|unique:subcategories',
            'subcategory_image'=> 'image',
            'category_id'=> 'required',
        ]);
        $random_numb =random_int(100000, 999998);
        $category_id = $request->category_id;
        $category_name = Category::where('id', $category_id)->value('category_name');
        $subcat_slug = Str::lower(str_replace(' ', '-', $request->subcategory_name)).'-'.$random_numb;

        if($request->subcategory_image == '' )
        {
            Subcategory::insert([
                'subcategory_name'=>$request->subcategory_name,
                'category_id'=>$category_id,
                'category_name'=>$category_name,
                'slug'=>$subcat_slug,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]);

            return redirect()->route('all_sub_category')->with('sub_name', 'Subcategory name added Successfully');

        }
        else
        {
            $random_numb =random_int(100000, 999998);
            $subcat_slug = Str::lower(str_replace(' ', '-', $request->subcategory_name)).'-'.$random_numb;
            $subcat_image = $request->subcategory_image;
            $ext = $subcat_image->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ', '-', $request->subcategory_name)).'-'.$random_numb.'.'.$ext;

            Image::make($subcat_image)->save(public_path('backend/uploads/subcategory_image/'.$file_name));

            Subcategory::insert([
                'subcategory_name'=>$request->subcategory_name,
                'category_id'=>$category_id,
                'subcategory_image'=>$file_name,
                'category_name'=>$category_name,
                'slug'=>$subcat_slug,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]);

            Category::where('id', $category_id)->increment('subcategory_count', 1);

            return redirect()->route('all_sub_category')->with('message2', 'Category inserted successfully');
        }

    }


    /*---- Subcategory delete -----*/
        function delete_subcat ($id){

            $stored_img = Subcategory::find($id);
            if($stored_img->subcategory_image !== '')
            {
                $img_path = public_path('backend/uploads/subcategory_image/'.$stored_img->subcategory_image);
                unlink($img_path);
            }

            // $category_id = Subcategory::where('id', $id)->value('category_id');

            Subcategory::find($id)->delete();

            Category::where('id', $category_id)->decrement('subcategory_count', 1);

            return redirect()->route('all_sub_category')->with('sub_del', 'Subcategory deleted successfully');

        }


/*---- Subcategory Edit -----*/

function edit_subcat($id){

    $cat = Category::all();
    $sub_cat = Subcategory::find($id);

    return view('backend.subcategory.edit_sub_category', [
        'cat'=>$cat,
        'sub_cat'=>$sub_cat,
    ]);

}



/*---- Subcategory Update -----*/
    function update_subcat(Request $request){
        $request->validate([
            'subcategory_name'=> 'required',
            'subcategory_image'=> 'image',

        ]);

        $subcategory_id = $request->subcategory_id;
        $category_id = $request->category_id;
        $category_name = Category::where('id', $category_id)->value('category_name');
        if($request->subcategory_image == '')
        {
            Subcategory::find($subcategory_id)->update([
                'subcategory_name'=>$request->subcategory_name,
                'category_id'=>$request->category_id,
                'category_name'=>$category_name,
            ]);
            return redirect()->route('all_sub_category')->with('sub_nm_up', 'Subcategory name updated successfully');
        }
        else
        {


            $stored_img3 = Subcategory::find($subcategory_id);
            if($stored_img3->subcategory_image !='')
            {
                $image_path = public_path('backend/uploads/subcategory_image/'.$stored_img3->subcategory_image);
                unlink($image_path);
            }
        $image_name = $request->subcategory_image;
        $random_numb = random_int(100000, 999998);
        $ext = $image_name->getClientOriginalExtension();
        $file_name = Str::lower(str_replace(' ', '-', $request->subcategory_name))."-".$random_numb.".".$ext;

        Image::make($image_name)->save(public_path('backend/uploads/subcategory_image/'.$file_name));


        Subcategory::find($subcategory_id)->update([
                'subcategory_name'=>$request->subcategory_name,
                'subcategory_image'=>$file_name,
                'category_id'=>$request->category_id,
                'category_name'=>$category_name,
            ]);
            return redirect()->route('all_sub_category')->with('sub_img_up', 'Subcategory updated successfully');
        }



    }







}




