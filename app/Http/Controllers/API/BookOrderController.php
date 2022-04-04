<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookOrder;
use App\Models\Notification;
use Validator; 
use Auth; 

class BookOrderController extends Controller
{
    public function bookorder(Request $request){
        $user = Auth::guard('api')->user();
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
            'type' => 'required',
        ]);  
        if($validator->fails()){
            return errorResponse('Validation Error.', $validator->errors());     
        }
        $input = $request->all();
        $input['parcel_id'] = random_int(1000000000, 9999999999);
        $input['user_id'] = $user->id;
        $bookorder = BookOrder::create($input);
        $success['status'] = 200;


        $success['data'] = $bookorder;

        $data = [
            'user_id' => $user->id,
            'title' => "parcel ".$input['parcel_id'],
            'description' => "order pending"
        ];
        $notification = Notification::create($data);

        return successResponse('Order Booked Successfully.',$success);
    }

    public function ordercancel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required'
        ]);  

        if($validator->fails()){
            return errorResponse('Validation Error.', $validator->errors());     
        } 

        $order = BookOrder::find($request->order_id);
        if($order != null){
        $order['status'] = 3;
        $order->update();
        return successResponse('Cancel Order Successfully.',$order);
                
        }
        return errorResponse('No Data Found!');

    }

}
