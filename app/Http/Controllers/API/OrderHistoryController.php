<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookOrder;
use App\Models\Orderstatus;
use Auth;


class OrderHistoryController extends Controller
{
    public function list($status)
    {
        $user = Auth::guard('api')->user()->id;
        $Orderlist = BookOrder::where('status',$status)->where('user_id',$user)->get();
        if($Orderlist != '[]'){
            return successResponse('',$Orderlist);
        }
            return errorResponse('No Data Found!');
    }

    public function orderdetail(Request $request,$id)
    {
        $orderdetail = BookOrder::where('user_id',$id)->get();
        if($orderdetail != '[]'){
            return successResponse('',$orderdetail);
        }
            return errorResponse('No Data Found!');
    }

    public function orderstatus(Request $request)
    {
        $orderstatus = Orderstatus::get();
        if($orderstatus != '[]'){
            return successResponse('',$orderstatus);
        }
            return errorResponse('No Data Found!');
    }
}
