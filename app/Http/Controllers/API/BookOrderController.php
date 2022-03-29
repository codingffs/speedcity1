<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\BookOrder;
use Validator; 
use Auth; 

class BookOrderController extends BaseController
{
    public function bookorder(Request $request){
       
        $validator = Validator::make($request->all(), [
            'local_services' => 'required',
            'pickup_address' => 'required',
            'sender_name' => 'required',
            'pickup_contact' => 'required',
            'delivery_address' => 'required',
            'receiver_name' => 'required',
            'delivery_contact' => 'required',
            'parcel_type' => 'required',
            'parcel_weight' => 'required',
            'total_amount' => 'required',
        ]);  
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());     
        }
        $input = $request->all();
        $user = BookOrder::create($input);
        $success['status'] = 200;
        return $this->sendResponse($success, 'Order Booked Successfully.');
    }
}
