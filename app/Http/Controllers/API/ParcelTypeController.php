<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ParcelType;

class ParcelTypeController extends Controller
{
        public function parceltype(){
            $parceltype = ParcelType::get();
            return $parceltype;
        }
}
