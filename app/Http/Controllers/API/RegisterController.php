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
        $request->password = "qwertyuiop@123";
        if(Auth::attempt(['email' => $data->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $user->token =  $user->createToken('Cancer')->accessToken; 
            return successResponse('User Register and login successfully', $user);
        } else{ 
            return errorResponse('Unauthorised');
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
        $user->token =  $user->createToken('Cityspeed')-> accessToken; 

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
<<<<<<< HEAD


        $user  = User::where('mobile',$request->mobile)->first();
        // dd($user);
        
        if($user != NULL)
        {
            $user->otp = "123456";
            $user->update();
=======
        $user  = User::where('mobile',$request->mobile)->first();
        if($user != NULL)
        {
        $otp = "123456";
        $user->otp = $otp;
        $user->update();
>>>>>>> 1ea5546ed5dacc0b906a6707718cb83d9d26bf22
            $data['otp'] = $user->otp;
            $data['mobile'] = $request->mobile;
            return successResponse('OTP Send Successfully', $data);
        }  
            return errorResponse('Mobile Number Is Not Exists!');
    }

    public function otpverify(Request $request){
        $rules = [
            'otp' => 'required',
        ];
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                $errorMessage = $validator->messages();
                $message = $validator->errors()->first();
                return errorResponse($message, $errorMessage);
            }
            $user = User::where("mobile",$request->mobile)->where("otp",$request->otp)->first();
            if($user != NULL){
            $request->password = "qwertyuiop@123";
            if(Auth::attempt(['email' => $user->email, 'password' => $request->password])){ 
                $user = Auth::user(); 
                $user->token =  $user->createToken('Cancer')-> accessToken; 
                return successResponse('User login successfully', $user);
            } else{ 
                return errorResponse('Unauthorised');
            } 
        }
        else{
            return errorResponse('Invalid OTP!');
        }

    }



    public function logout()
    { 
        Auth::guard('api')->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
        $success['status'] = 500;
        return $this->sendResponse($success, 'User logout successfully.');
    }
}
