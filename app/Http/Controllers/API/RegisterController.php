<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function userRegister(Request $request){
        $rules = [
            'name' => 'required',
            'mobile' => 'required|unique:users|digits:10',
            'email' => 'required|email|unique:users',
            'confirm_email' => 'required|same:email'
        ];

        $validator = Validator::make($request->all(), $rules);
        $input = $request->all();
        $input['password'] =  Hash::make("qwertyuiop@123");

        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            $message = $validator->errors()->first();
            return errorResponse($message, $errorMessage);
        }
        
        $user = User::create($input);
        $data = User::find($user->id);
        
        $user->token =  $user->createToken('cityspeed')->accessToken;
        if(!empty($user)) {
            return successResponse("Register Successfully", $data);
        } else {
            return errorResponse("Something went wrong, Please try again later", $errorMessage);
        }
        
    }

    public function userLogin1(Request $request){
        
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            $message = $validator->errors()->first();
            return errorResponse($message, $errorMessage);
        }
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $user->token =  $user->createToken('cityspeed')-> accessToken; 
   
            return successResponse('User login successfully', $user);
        } else{ 
            return errorResponse('Unauthorised');
        } 
        
    }

    public function userTest(Request $request){
        $user = auth()->guard('api')->user(); 
        $user->token =  $user->createToken('Cancer')-> accessToken; 

        return successResponse('User login successfully', $user);
        
    }

    public function sendotp(Request $request){
        $rules = [
            'mobile' => 'required|digits:10'
        ];
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            $message = $validator->errors()->first();
            return errorResponse($message, $errorMessage);
        }

        $user  = User::where('mobile',$request->mobile)->first();
        if($user)
        {
            $otp = "123456";
            return successResponse('OTP Send Successfully', $otp);
        }  
        else
        {
            return errorResponse('Mobile Number Is Not Exists!');
        }
    }
    public function logout()
    { 
        Auth::guard('api')->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
        // if(Auth::guard('api')->check()){
        //     Auth::logout();
        // }
        $success['status'] = 500;
        return successResponse('User logout successfully.',$success);
    }
}
