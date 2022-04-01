<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookOrder;
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
    public function BranchOrder($status)
    {
        $user = Auth::guard('api')->user()->id;
        $Orderlist = BookOrder::where('status',$status)->where('branch_id',$user)->get();
        if($Orderlist != '[]'){
            return successResponse('Order Details',$Orderlist);
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

    public function AssignUser($user_id,$order_id)
    {
        $user = array(
            "user_id" => $user_id,
            "order_id" => $order_id,
            "status" => 1,
        );
        AssignUser::create($user);
        if($user != '[]'){
            return successResponse('User Assigned',$user);
        }
            return errorResponse('No Data Found!');
    }

    public function CancelUser($user_id,$order_id)
    {
        $user = AssignUser::where('user_id',$user_id)->where('order_id',$order_id)->first();
        $user['status'] = 2;
        $user->update();          
        if($user != '[]'){
            return successResponse('User Unassgined',$user);
        }
            return errorResponse('No Data Found!');
    }
}
