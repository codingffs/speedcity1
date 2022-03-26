<?php

use App\Models\Setting;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Degree;
use App\Models\Categoryfaq;
use App\Models\Category;
use App\Models\Cms;
use App\Models\CourierItems;

function logoimage($val){
   
    $logo = Setting::where('key',$val)->first()->value;
 
    return $logo;
}

function errorResponse($status, $errorMessage = null, $data = []) {
    return response()->json([
            "success" => 0,
            "data" => $data,
            "message" => $status,
            "status" => 400,
    ]);
}

function successResponse($message, $data = null) {
    if (!empty($data)) {

        return response()->json([
                    "success" => 1,
                    "data" => $data,
                    "message" => $message,
                    "status" => 200,

        ]);
    } else {
        return response()->json([
            "success" => 1,
            "data" => $data,
            "message" => $message,
            "status" => 200,
        ]);
    }
}

function systemResponse($message) {
    return response()->json([
        "success" => 0,
        "data" => [],
        "message" => $message,
        "status" => 401,

    ]);
    //return response()->json(['error' => $status, 401]);
}
function getcountryname($country_id){
    $country = Country::find($country_id);
    return $country->country_name;
}
function getstatename($state_id){
    $state = state::find($state_id);
    return $state->state_name;
}
function getCityname($city_id){
    $city = City::find($city_id);
    return $city->city_name;
}
function getDegree($degree){
    $degre = Degree::find($degree);
    return $degre->title;
}
function getFaqname($id){
    $faq = Categoryfaq::find($id);
    return $faq->title;
}
function getCmsDetail($slug)
{
     return Cms::where('slugname',$slug)->get();  
}
function getcatgoryname($id){
    $category = Category::find($id);
    return $category->title;
}
function getItemName($id){
    $name = CourierItems::find($id);
    return $name->item_name;
}
?>
