<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{   
    public function index1()
    {
    return view('welcome');
    }
    public function showRegisterForm() {
        return view('auth.register');
    }
    public function check_email_exists_in_users(Request $request){
       
        $rules = [
            'email'=> 'required|email|unique:users,email',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $res = [
                'message' => $validator->errors()->all()[0],
                'status' => 0,
            ];
        
            return $res; 
        }
        $res = [
            'message' => 'success',
            'status' => 1,
        ];
        return $res;
    }
    public function check_email_exists_in_update(Request $request){
       
        $rules = [
            'email'=> 'required|email|unique:users,email,'.$request->id,
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $res = [
                'message' => $validator->errors()->all()[0],
                'status' => 0,
            ];
        
            return $res; 
        }
        $res = [
            'message' => 'success',
            'status' => 1,
        ];
        return $res;
    }

    public function register_submit(Request $request){

        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'mobile_no' => 'required',
            'gst_registered' => 'required',
            'trading_name' => 'required',
            'bank_account_name' => 'required',
            'bsb' => 'required',
            'account_no' => 'required',
            'mailing_address' => 'required',
            'password' => 'required',
        ]);

        $name = str_replace(" ", "", $request->name);
        $code = substr($name, 0, 3);

        $check_code = User::where("code", $code)->first();

        if(!empty($check_code)){
            for($i = 1; $i <= 1000; $i++){
                $code = substr($name, 0, 3) . $i;

                $check_code = User::where("code", $code)->first();
                if(empty($check_code)){
                    break;
                }
            }
        }

        $User = array(
            "code" => $code,
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "mobile_no" => $request->mobile_no,
            "gst_registered" => $request->gst_registered,
            "trading_name" => $request->trading_name,
            "bank_account_name" => $request->bank_account_name,
            "bsb" => $request->bsb,
            "account_no" => $request->account_no,
            "mailing_address" => $request->mailing_address,
            "password" => bcrypt($request->password),
            "type" => '2',
        );

        // $data["details"] = $User;

        // $html = view('emails.create_supplier', $data);
        // echo $html;exit;

        $data_user = User::create($User);
        $role = Role::whereName("Supplier")->first();
        $data_user->assignRole([$role->id]);
        $admin_email = config('global.admin_email');
        \Mail::to($request->email)->send(new \App\Mail\SupplierWelcomeMail($User));
        \Mail::to($admin_email)->send(new \App\Mail\CreateSupplierMail($User));

        return redirect()->route('login')->with("success", "You are register successfully.");
    }
    
}
