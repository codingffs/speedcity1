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
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\BranchOrderController;


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
    Route::get('banner',[BannerController::class,'banner'])->name('banner');

        Route::group(['middleware' => ['passportapi']], function(){
            
            Route::get('orderdetail/day', [OrderHistoryController::class,"dayOrderDetail"]); 
            Route::get('orderdetail/month', [OrderHistoryController::class,"monthOrderDetail"]); 
            Route::get('orderdetail/year', [OrderHistoryController::class,"yearOrderDetail"]); 
            Route::get('notification', [NotificationController::class,"list"]); 
            Route::get('orderdetail/{id}', [OrderHistoryController::class,"orderdetail"]);
            Route::get('mybooking/{status}', [OrderHistoryController::class,"list"]); 
            Route::post('bookorder',[BookOrderController::class,'bookorder'])->name('bookorder');
            Route::get('BranchAllOrder',[BranchOrderController::class,'BranchAllOrder'])->name('BranchAllOrder');
            Route::get('BranchOrder/{status}', [BranchOrderController::class,"BranchOrder"]); 
        
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

