<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParcelWeight;

class ParcelWeightController extends Controller
{
    public function parcelweight(){
        $weight = ParcelWeight::get();
        if($weight != '[]'){
            // return $notification;
              return successResponse('Parcel Weight List', $weight);
        }
            return errorResponse('No Data Found!');
    }
}
