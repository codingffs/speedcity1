<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Auth;

class NotificationController extends Controller
{
    public function list()
    {
        $user_id = $user = Auth::guard('api')->user()->id;
        $notification = Notification::where('user_id',$user_id)->get();
        // $notification = Notification::get();
        if($notification){
            // return $notification;
              return successResponse('Notification List', $notification);
        }
            return errorResponse('No Data Found!');
    }
}
