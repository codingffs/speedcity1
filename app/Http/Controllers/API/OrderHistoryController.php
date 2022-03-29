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
        $user = Auth::user(); 
        dd($user);
        $Orderlist = BookOrder::where('status',$status)->get();
        return $Orderlist;
    }
}
