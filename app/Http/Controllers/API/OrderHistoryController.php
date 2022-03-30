<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookOrder;
use Auth;


class OrderHistoryController extends Controller
{
    public function list($status)
    {
        $user = Auth::guard('api')->user()->id;
        $Orderlist = BookOrder::where('status',$status)->where('user_id',$user)->get();
        if($Orderlist != '[]'){
            return successResponse('Order Details',$Orderlist);
        }
            return errorResponse('No Data Found!');
    }

    public function dayOrderDetail($date)
    {
        $user = Auth::guard('api')->user()->id;
        $daydata = BookOrder::whereDate('created_at','=',$date)->where('user_id',$user)->get();
        if($daydata != '[]'){
            return successResponse('Order Details',$daydata);
        }
            return errorResponse('No Data Found!');
    }

    public function monthOrderDetail($startDate,$endDate)
    {
        $user = Auth::guard('api')->user()->id;
        $Monthdata = BookOrder::whereBetween('created_at',[$startDate,$endDate])->where('user_id',$user)->get();
        if($Monthdata != '[]'){
            return successResponse('Order Details',$Monthdata);
        }
            return errorResponse('No Data Found!');
    }
    
    public function yearOrderDetail($startDate,$endDate)
    {
        $user = Auth::guard('api')->user()->id;
        $Yeardata = BookOrder::whereBetween('created_at',[$startDate,$endDate])->where('user_id',$user)->get();
        if($Yeardata != '[]'){
            return successResponse('Order Details',$Yeardata);
        }
            return errorResponse('No Data Found!');
    }
    public function allOrder(){
        
    }
}
