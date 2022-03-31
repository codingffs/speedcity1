<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookOrder;
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
}
