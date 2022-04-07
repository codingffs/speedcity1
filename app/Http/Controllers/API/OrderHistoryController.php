<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookOrder;
use App\Models\Orderstatus;
use App\Models\Orderhistory;
use Validator; 
use Auth;


class OrderHistoryController extends Controller
{
    public function list(Request $request )
    {
        $user = Auth::guard('api')->user()->id;
        $Orderlist = BookOrder::where('status',$request->status)->where('user_id',$user)->get();
        if($Orderlist != '[]'){
            // $Orderlist['order_status'] = 
            return successResponse('Order Details',$Orderlist);
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

    public function orderdetail(Request $request){
        $orderdetail = BookOrder::find($request->id);
        if($orderdetail != null){
            return successResponse('',$orderdetail);
        }
            return errorResponse('No Data Found!');
    }

    public function orderhistory(Request $request)
    {
          if($request->status == "0")
          {
            // current day wise order 
            $user = Auth::guard('api')->user()->id;
            $daydata = BookOrder::whereDate('created_at',date('Y-m-d'))->where('user_id',$user)->get();
            if($daydata != '[]'){
                return successResponse('Order Details',$daydata);
            }
            return errorResponse('No Data Found!');
          }
          elseif($request->status == "1")
          {
                // current Month wise order 
            $user = Auth::guard('api')->user()->id;
            $Monthdata = BookOrder::whereMonth('created_at',date('m'))->where('user_id',$user)->get();
            if($Monthdata != '[]'){
                return successResponse('Order Details',$Monthdata);
            }
                return errorResponse('No Data Found!');
          }
          elseif($request->status == "2")
          {
                // current year wise order 
            $user = Auth::guard('api')->user()->id;
            $Yeardata = BookOrder::whereYear('created_at', date('Y'))->where('user_id',$user)->get();
            if($Yeardata != '[]'){
                return successResponse('Order Details',$Yeardata);
            }
                return errorResponse('No Data Found!');
          }
          else
          {
            return errorResponse('No Data Found!');
          }
    }
}
