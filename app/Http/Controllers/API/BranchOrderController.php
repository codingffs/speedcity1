<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookOrder;
use App\Models\Orderhistory;
use App\Models\Notification;
use Validator; 
use Auth;

class BranchOrderController extends Controller
{
    public function BranchAllOrder()
    {   
        $user = Auth::guard('api')->user()->id;
        $orderdetail = BookOrder::where('Branch_id',$user)->get();
        if($orderdetail != '[]'){
            return successResponse('',$orderdetail);
        }
            return errorResponse('No Data Found!');
    }
    public function BranchOrder($status)
    {
        $user = Auth::guard('api')->user()->id;
        $Orderlist = BookOrder::where('status',$status)->where('branch_id',$user)->get();
        if($Orderlist != '[]'){
            return successResponse('Order Details',$Orderlist);
        }
            return errorResponse('No Data Found!');
    }

    public function orderhistorystatus(Request $request)
    {
        // dd($request->All());
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'order_status' => 'required',
            'location' => 'required',
        ]);  
        if($validator->fails()){
            return errorResponse('Validation Error.', $validator->errors());     
        }
        $input = $request->all();
        $Orderhistory = Orderhistory::create($input);
        $success['data'] = $Orderhistory;

        $order = BookOrder::find($request->order_id);
        $order['order_status'] =  $request->order_status;
        $order->update();

        $user_id = Auth::guard('api')->user()->id;
        $data = [
            'user_id' => $user_id,
            'title' => "Parcel ".get_parcel_id($user_id),
            'description' => get_parcel_status($request->order_status)
        ];
        $notification = Notification::create($data);
        return successResponse('Orderstatus update Successfully.',$success);


    }

    public function orderhistorydetail(Request $request,$id)
    {
        $orderdetail = BookOrder::find($id);
        if($orderdetail != null){
            return successResponse('Order deatail list',$orderdetail);
        }
            return errorResponse('No Data Found!');
        
    }
}
