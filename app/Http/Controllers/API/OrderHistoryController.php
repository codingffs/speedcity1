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
    public function list($status)
    {
        $user = Auth::guard('api')->user()->id;
        $Orderlist = BookOrder::where('status',$status)->where('user_id',$user)->get();
        if($Orderlist != '[]'){
            return successResponse('Order Details',$Orderlist);
        }
            return errorResponse('No Data Found!');
    }

    // public function dayOrderDetail()
    // {
    //     $user = Auth::guard('api')->user()->id;
    //     $daydata = BookOrder::whereDate('created_at',date('Y-m-d'))->where('user_id',$user)->get();
    //     if($daydata != '[]'){
    //         return successResponse('Order Details',$daydata);
    //     }
    //     return errorResponse('No Data Found!');
    // }

    // public function monthOrderDetail()
    // {   
    //     $user = Auth::guard('api')->user()->id;
    //     $Monthdata = BookOrder::whereMonth('created_at',date('m'))->where('user_id',$user)->get();
    //     if($Monthdata != '[]'){
    //         return successResponse('Order Details',$Monthdata);
    //     }
    //         return errorResponse('No Data Found!');
    // }
    
    // public function yearOrderDetail()
    // {
    //     $user = Auth::guard('api')->user()->id;
    //     $Yeardata = BookOrder::whereYear('created_at', date('Y'))->where('user_id',$user)->get();
    //     if($Yeardata != '[]'){
    //         return successResponse('Order Details',$Yeardata);
    //     }
    //         return errorResponse('No Data Found!');
    // }
    
    public function orderstatus(Request $request)
    {
        $orderstatus = Orderstatus::get();
        if($orderstatus != '[]'){
            return successResponse('',$orderstatus);
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

    public function orderhistory($status)
    {
          if($status == "0")
          {
            // current day wise order 
            $user = Auth::guard('api')->user()->id;
            $daydata = BookOrder::whereDate('created_at',date('Y-m-d'))->where('user_id',$user)->get();
            if($daydata != '[]'){
                return successResponse('Order Details',$daydata);
            }
            return errorResponse('No Data Found!');
          }
          elseif($status == "1")
          {
                // current Month wise order 
            $user = Auth::guard('api')->user()->id;
            $Monthdata = BookOrder::whereMonth('created_at',date('m'))->where('user_id',$user)->get();
            if($Monthdata != '[]'){
                return successResponse('Order Details',$Monthdata);
            }
                return errorResponse('No Data Found!');
          }
          elseif($status == "2")
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
