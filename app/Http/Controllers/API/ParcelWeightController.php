<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ParcelWeight;

class ParcelWeightController extends Controller
{
    public function parcelweight(){
        $weight = ParcelWeight::get();
        return $weight;
    }
}
