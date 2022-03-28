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
        $user = $user = Auth::user(); 
        // $notification = Notification::where('user_id',$user->id)->first();
        $notification = Notification::get();

        return $notification;
    }
}
