<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Str;
use Image;

class CategoryController extends Controller
{
/*----- category add  ---*/
    public function add_category(){
        return view('backend.category.add_category');
    }
/*----- category all  ---*/
    public function all_category(){
        $categories = Category::all();
        $trashed_cat = Category::onlyTrashed()->get();
        return view('backend.category.all_category' , [
            'categories'=>$categories,
            'trashed_cat'=>$trashed_cat,
        ]);

    }

/*----- category insert  ---*/
    public function store_category(Request $request){

        $request->validate([
            'category_name'=> 'required|unique:categories',
            'category_image'=> 'image',
        ]);

        if($request->category_image == ''){

            $cat_slug = Str::lower(str_replace(' ', '-', $request->category_name));
            Category::insert([
                'category_name'=>$request->category_name,
                'slug'=>$cat_slug,
            ]);
            return redirect()->route('all_category')->with('message', 'Category name inserted successfully');
        }
        else
        {
            $cat_slug2 = Str::lower(str_replace(' ', '-', $request->category_name));
            $cat_image = $request->category_image;
            $random_numb =random_int(100000, 999998);
            $ext = $cat_image->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ', '-', $request->category_name)).'-'.$random_numb.'.'.$ext;

            Image::make($cat_image)->save(public_path('backend/uploads/category_image/'.$file_name));

            Category::insert([
                'category_name'=>$request->category_name,
                'category_image'=>$file_name,
                'slug'=>$cat_slug2,
            ]);
            return redirect()->route('all_category')->with('message2', 'Category inserted successfully');
        }

    }

/*----- category edit ---*/
    public function edit_cat($id){
            $cat_info = Category::find($id);
        return view('backend.category.edit_cat', [
            'cat_info'=>$cat_info,
        ]);

    }
/*----- category update  ---*/
    public function update_cat(Request $request){
        $request->validate([
            'category_name'=> 'required|unique:categories',
            'category_image'=> 'image',
        ]);

        if($request->category_image == '')
        {
            Category::find($request->cat_id)->update([
                'category_name'=>$request->category_name,
            ]);
        return redirect()->route('all_category')->with('cname', 'Category name updated successfully');

        }
    else
    {
            $stored_img = Category::find($request->cat_id);
            if($stored_img->category_image !='')
            {
                $image_path = public_path('backend/uploads/category_image/'.$stored_img->category_image);
                unlink($image_path);
            }
        $image_name = $request->category_image;
        $random_numb2 = random_int(100000, 999998);
        $ext = $image_name->getClientOriginalExtension();
        $file_name = Str::lower(str_replace(' ', '-', $request->category_name))."-".$random_numb2.".".$ext;

        Image::make($request->category_image)->save(public_path('backend/uploads/category_image/'.$file_name));

        Category::find($request->cat_id)->update([
                'category_name'=>$request->category_name,
                'category_image'=>$file_name,
            ]);

            return redirect()->route('all_category')->with('cimg', 'Category updated successfully');
       }

}


/*----- category delete ---*/
    public function delete_cat($id){

        Category::find($id)->delete();
        return redirect()->route('all_category')->with('del_cat', 'Category deleted successfully');

    }



    /*---category restore----*/
function restore_cat ($id){
    Category::onlyTrashed()->find($id)->restore();



    return redirect()->route('all_category')->with('r_cat', 'Category restore successfully');

}

/*---category permanent delete----*/

function permanent_del($id){

    $stored_img2 = Category::onlyTrashed()->find($id);

    if($stored_img2->category_image != ''){

        $image_path2 = public_path('backend/uploads/category_image/'.$stored_img2->category_image);
         unlink($image_path2);

    }

    Category::onlyTrashed()->find($id)->forceDelete();

    return back()->with('p_del', 'Category permanent delete Successfully');
}







}




