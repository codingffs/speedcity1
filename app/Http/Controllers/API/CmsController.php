<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use  App\Models\Cms;

class CmsController extends Controller
{
    public function cmslist($slug)
    {
        $cmsdeatil = Cms::where('slugname',$slug)->first();
        if($cmsdeatil != '[]'){
            // return $notification;
              return successResponse('Detail List', $cmsdeatil);
        }
            return errorResponse('No Data Found!');
    }
}
