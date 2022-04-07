<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookOrder;
use App\Models\Orderhistory;
use App\Models\Notification;
use Validator; 
use App\Models\AssignUser;
use App\Models\User;
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
    public function BranchOrder(Request $request)
    {
        $user = Auth::guard('api')->user()->id;
        $Orderlist = BookOrder::where('status',$request->status)->where('branch_id',$user)->get();
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
            if($order != null)
        {
        $order['order_status'] =  $request->order_status;
        if($request->order_status >=1 && $request->order_status <= 4)
        {
            $order['status'] = "inprogress";
            //inprogress
        }
        elseif($request->order_status == 0)
        {
            $order['status'] = "pending";
            //pending
        }
        $order['status'] = "completed";
        // completed
        $order->update();
        $user_id = Auth::guard('api')->user()->id;
        $data = [
            'user_id' => $user_id,
            'title' => "Parcel ".$order['parcel_id'],
            'description' => get_parcel_status($request->order_status)
        ];
        $notification = Notification::create($data);
        return successResponse('Orderstatus update Successfully.',$success);
    }
    
    return errorResponse('No Data Found!');

    }

    public function orderhistorydetail(Request $request)
    {
        $orderdetail = BookOrder::find($request->id);
        if($orderdetail != null){
            return successResponse('Order deatail list',$orderdetail);
        }
            return errorResponse('No Data Found!');
    }
        
    public function BranchorderInfo($id)
    {
        $detail = BookOrder::find($id);
        if($detail != '[]'){
            return successResponse('Order Details',$detail);
        }
            return errorResponse('No Data Found!');
    }

    public function BranchUser()
    {
        $user = Auth::guard('api')->user()->id;
        $Branchuser = User::where('role',4)->where('branch_id',$user)->get();
        $imagepath = asset('/branchuser');
        if($Branchuser != '[]'){
            return successResponse('User Details',$Branchuser,$imagepath);
        }
            return errorResponse('No Data Found!');

    }

    public function AssignUser(Request $request)
    {
        $user = array(
            "user_id" => $request->user_id,
            "order_id" => $request->order_id,
            "status" => 1,
        );
        AssignUser::create($user);
        if($user != '[]'){
            return successResponse('User Assigned',$user);
        }
            return errorResponse('No Data Found!');
    }

    public function CancelUser(Request $request)
    {
        $user = AssignUser::where('user_id',$request->user_id)->where('order_id',$request->order_id)->first();
        $user['status'] = 2;
        $user->update();          
        if($user != '[]'){
            return successResponse('User Unassgined',$user);
        }
            return errorResponse('No Data Found!');
    }
}
