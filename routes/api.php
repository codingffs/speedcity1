<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\CmsController;
use App\Http\Controllers\API\FaqController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\OrderHistoryController;
use App\Http\Controllers\API\AuthAdminController;
use App\Http\Controllers\API\BookOrderController;
use App\Http\Controllers\API\ParcelWeightController;
use App\Http\Controllers\API\ParcelTypeController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('admin')->group( function (){ 
    Route::post('user-login',[RegisterController::class,'userLogin1'])->name('user-login');
    Route::post('user-register',[RegisterController::class,'userRegister'])->name('user-register');
    Route::post('register', [AuthAdminController::class,'register']); 
    Route::get('logout', [RegisterController::class,"logout"]); 
    Route::get('faq', [FaqController::class, "index1"]);
    Route::get('cms/{slug?}', [CmsController::class,"cmslist"]);
    Route::get('parcelweight',[ParcelWeightController::class,'parcelweight'])->name('parcelweight');
    Route::any('send-otp',[RegisterController::class,'sendotp'])->name('send-otp');
    Route::post('otp-verify',[RegisterController::class,'otpverify'])->name('otp-verify');
    Route::get('orderstatus', [OrderHistoryController::class,"orderstatus"]);
    Route::get('parceltype',[ParcelTypeController::class,'parceltype'])->name('parceltype');

        Route::group(['middleware' => ['passportapi']], function(){
            
            Route::get('orderdetail/day/{date}', [OrderHistoryController::class,"dayOrderDetail"]); 
            Route::get('orderdetail/month/{startDate}/{endDate}', [OrderHistoryController::class,"monthOrderDetail"]); 
            Route::get('orderdetail/year/{startDate}/{endDate}', [OrderHistoryController::class,"yearOrderDetail"]); 
            Route::get('notification', [NotificationController::class,"list"]); 
            Route::get('mybooking/{status}', [OrderHistoryController::class,"list"]); 
            Route::get('orderdetail/{id}', [OrderHistoryController::class,"orderdetail"]);
            Route::post('bookorder',[BookOrderController::class,'bookorder'])->name('bookorder');
        
    });
});



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

