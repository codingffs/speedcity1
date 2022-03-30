<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourierItems;

class ParcelTypeController extends Controller
{
        public function parceltype(){
            $parceltype = CourierItems::get();
            if($parceltype != '[]'){
                // return $notification;
                  return successResponse('Parcel type List', $parceltype);
            }
                return errorResponse('No Data Found!');
        }
}
