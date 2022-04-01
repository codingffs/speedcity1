<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookOrder;
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

    public function AssignUser($id)
    {
          
    }
    
}
