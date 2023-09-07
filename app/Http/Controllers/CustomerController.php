<?php

namespace App\Http\Controllers;
use App\Models\Customerlogin;
use App\Http\Middleware\CustomerAuthMiddleware;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use PDF;

class CustomerController extends Controller
{
    function customer_register_login(){
        return view('frontend.customer.register_login');
    }
/*----------Customer register--------------*/
    function customer_register(Request $request){

        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required',
            'password'=>'required',
            'password_confirmation'=>'required',
        ]);

        Customerlogin::insert([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'created_at'=>Carbon::now(),
        ]);
         return back();

    }

/*----------Customer login--------------*/
    function customer_login(Request $request){

        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        if(Auth::guard('customerlogin')->attempt(['email'=>$request->email, 'password'=>$request->password])){
            return redirect('/');
        }
        else
        {
            return redirect('/')->with('old', 'Credentials does not matched');
        }

    }
/*----------Customer logout--------------*/
    function customer_logout(){
        Auth::guard('customerlogin')->logout();
        return redirect('/');
    }

/*----------Customer profile--------------*/
    function profile(){
        return view('frontend.customer.profile');
    }

/*----------Customer profile update--------------*/
    function profile_update(Request $request){
            if($request->photo == ''){
                if($request->password == ''){
                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'address'=>$request->address,
                ]);
                return back();
            }
                else
                {
                if(Hash::check($request->old_password, Auth::guard('customerlogin')->user()->password)){
                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'country'=>$request->country,
                        'address'=>$request->address,
                        'password'=>Hash::make($request->password),
                    ]);
                    return back();
                   }
                   else
                   {
                    return back()->with('pass', 'Password Does not matched');
                   }
                }

            }
            else
            {
                $image_name = $request->photo;
                $ext = $image_name->getClientOriginalExtension();
                $file_name = Auth::guard('customerlogin')->id().'.'.$ext;

                Image::make($image_name)->save(public_path('frontend/uploads/customer_photo/'.$file_name));
            if($request->password == ''){
                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'country'=>$request->country,
                        'address'=>$request->address,
                        'photo'=>$file_name,

                    ]);
                    return back();
                }
                else
                {
                    if(Hash::check($request->old_password, Auth::guard('customerlogin')->user()->password)){
                        Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                            'name'=>$request->name,
                            'email'=>$request->email,
                            'country'=>$request->country,
                            'address'=>$request->address,
                         'password'=>Hash::make($request->password),
                            'photo'=>$file_name,

                        ]);
                        return back();

                       }
                       else
                       {
                        return back()->with('pass', 'Password Does not matched');
                       }
                    }
                }
        }


/*-----------My Order Page-------------*/
        function my_order(){
            $myorders = Order::where('customer_id', Auth::guard('customerlogin')->id())->get();
            return view('frontend.customer.my_order', [
                'myorders'=>$myorders,
            ] );
        }


        function invoice_download($order_id){

            $info = Order::find($order_id);
            $data = $info->order_id;
            $pdf = PDF::loadView('frontend.customer.invoice_pdf', [
                'data'=>$data,
            ]);
            return $pdf->download('invoice.pdf');
        }


    }
