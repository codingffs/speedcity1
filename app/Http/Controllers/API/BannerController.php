<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Auth;

class BannerController extends Controller
{
    public function banner(){
    $banner = Category::get();
    return successResponse('Banner Details',$banner);
    }
}
