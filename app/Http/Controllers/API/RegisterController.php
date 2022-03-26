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
            'full_name' => 'required',
            'username' => 'required|unique:users,username',
            'mobile_no' => 'required|unique:users,mobile_no',
            'password' => 'required|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            $message = $validator->errors()->first();
            return errorResponse($message, $errorMessage);
        }

        $data = [
            'name' => $request->full_name,
            'username' => $request->username,
            'mobile_no' => $request->mobile_no,
            'password' => Hash::make($request->password),
            'doctor_status' => '3',
        ];
        
        $user = User::create($data);

        //$user->token =  $user->createToken('Cancer')->accessToken;
        if(!empty($user)) {
            return successResponse("Register Successfully", $user);
        } else {
            return errorResponse("Something went wrong, Please try again later", $errorMessage);
        }
        
    }

    public function userLogin(Request $request){
        
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            $message = $validator->errors()->first();
            return errorResponse($message, $errorMessage);
        }
        
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $user->token =  $user->createToken('Cancer')-> accessToken; 
   
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
}
