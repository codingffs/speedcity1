<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Auth;
// use Carbon\Carbon;

class NotificationController extends Controller
{
    public function list()
    {
        $user_id = $user = Auth::guard('api')->user()->id;
        $notification = Notification::where('user_id',$user_id)->get();
            if($notification != '[]'){
                // foreach($notification as $key => $value)
                // {
                //     $time = Carbon::parse($value->created_at)->diffForHumans();
                //     $notification[$key]['time'] = $time;
                // }
                return successResponse('Notification List', $notification);
            }
                return errorResponse('No Data Found!');
    }
}
