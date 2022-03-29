<?php
namespace App\Http\Controllers\API;   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;  

class AuthAdminController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);  
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());     
        }   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role'] = 1;
        //print_r($input);die;
        $user = User::create($input);
        $success['token'] =  $user->createToken('Admin')->accessToken;
        $success['name'] =  $user->name;  
        return $this->sendResponse($success, 'User register successfully.');
    } 

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role'=>1])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('Admin')->accessToken; 
            $success['name'] =  $user->name;  
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
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

