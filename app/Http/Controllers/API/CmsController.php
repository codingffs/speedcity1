<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;
use Illuminate\Support\Facades\Auth;

class CmsController extends Controller
{
    public function cmsindex($slug)
    { 
      $about = Cms::where('slugname',$slug)->first();
      return $about;
    }
}
