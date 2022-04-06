<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

class ProfileController extends Controller
{
   public function update(Request $request)
   {
      $validator = Validator::make($request->all(), [
        'email' => 'required',
        'name' => 'required',
        'gender' => 'required'
    ]);  
    if($validator->fails()){
        return errorResponse('Validation Error.', $validator->errors());     
    }
    $user =  Auth::guard('api')->user();

    $data = array(
        "name" => $request->name,
        "email" => $request->email,
        "gender" => $request->gender,
        "address" => $request->address,
        "pincode" => $request->pincode,
    );
    User::whereId($user->id)->update($data);

   }
}
