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

// Route::post('user-test',[RegisterController::class,'userTest'])->name('user-test');
// Route::get('orderhistory/{status}', [OrderHistoryController::class,"list"]); 
Route::prefix('admin')->group( function (){ 
    Route::post('user-login',[RegisterController::class,'userLogin1'])->name('user-login');
    Route::post('user-register',[RegisterController::class,'userRegister'])->name('user-register');
    Route::post('register', [AuthAdminController::class,"register"]); 
    Route::get('logout', [RegisterController::class,"logout"]); 
    Route::group(['middleware' => ['passportapi']], function(){

        Route::get("faq", [FaqController::class, "index1"]);
        Route::get('cms/{slug?}', [CmsController::class,"cmslist"]); 
        Route::get('notification', [NotificationController::class,"list"]); 
        Route::get('orderhistory/{status}', [OrderHistoryController::class,"list"]); 
        // Route::post('user-login',[RegisterController::class,'userLogin'])->name('user-login');
        Route::any('send-otp',[RegisterController::class,'sendotp'])->name('send-otp');
        Route::post('bookorder',[BookOrderController::class,'bookorder'])->name('bookorder');
        Route::get('parcelweight',[ParcelWeightController::class,'parcelweight'])->name('parcelweight');
        // Route::get('parceltype',[ParcelTypeController::class,'parceltype'])->name('parceltype');
        Route::get('parceltype',[OrderHistoryController::class,'parceltype'])->name('parceltype');
        // Route::post('send-otp',[RegisterController::class,'sendotp'])->name('send-otp');
        // Route::get('parceltype',[OrderHistoryController::class,'parceltype'])->name('parceltype');
        Route::post('otp-verify',[RegisterController::class,'otpverify'])->name('otp-verify');
    
    });
});



// Route::get('/cms/{slug?}',[CmsController::class,'cmsindex'])->name('cms');
// Route::get('/faq-detail',[FaqController::class,'faqdetail'])->name('faqdetail');




// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

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
// Route::get('news', 'API\User\NewsController@index');  

// Route::prefix('admin')->group( function (){ 
//     Route::any('login', 'API\AuthAdminController@login'); 
//     Route::post('register', 'API\AuthAdminController@register'); 

//     Route::get('faq', 'API\FaqController@index'); 
// 


//     Route::get('logout', 'API\AuthAdminController@logout'); 
//     Route::get('parceltype', 'API\ParcelTypeController@parceltype'); 
//     Route::get('parcelweight', 'API\ParcelWeightController@parcelweight'); 
    
//     Route::group(['middleware' => ['passportapi']], function(){
//         Route::post('bookorder', 'API\BookOrderController@bookorder'); 
//     });
//     Route::middleware('auth:api')->get('dashboard', 'API\Admin\DashboardController@index');                              
//     Route::middleware('auth:api')->get('users', 'API\Admin\UserController@index'); 
    
//     Route::middleware('auth:api')->post('participants/deactivate', 'API\Admin\UserController@participants_deactivate');        
//     Route::middleware('auth:api')->post('participants/activate', 'API\Admin\UserController@participants_activate');        
    
//     Route::middleware('auth:api')->get('admin_user', 'API\Admin\UserController@adminUser');        
//     Route::middleware('auth:api')->post('add_admin_user', 'API\Admin\UserController@add_admin');       
    
//     Route::middleware('auth:api')->post('slider/image', 'API\Admin\SliderController@image');
//     Route::middleware('auth:api')->post('slider', 'API\Admin\SliderController@store');
//     Route::middleware('auth:api')->put('slider', 'API\Admin\SliderController@update');
//     Route::middleware('auth:api')->get('slider', 'API\Admin\SliderController@index');
    
    
    
//     Route::middleware('auth:api')->post('species', 'API\Admin\SpeciesController@store');
//     Route::middleware('auth:api')->put('species', 'API\Admin\SpeciesController@update');
//     Route::middleware('auth:api')->get('species', 'API\Admin\SpeciesController@index');
//     Route::middleware('auth:api')->get('species/detail,', 'API\Admin\SpeciesController@detail');
//     Route::middleware('auth:api')->post('species/image', 'API\Admin\SpeciesController@image');
	
// 	Route::middleware('auth:api')->post('offices', 'API\Admin\OfficesController@store');
//     Route::middleware('auth:api')->put('offices', 'API\Admin\OfficesController@update');
//     Route::middleware('auth:api')->get('offices', 'API\Admin\OfficesController@index');
//     Route::middleware('auth:api')->get('offices/detail,', 'API\Admin\OfficesController@detail');
	
// 	Route::middleware('auth:api')->post('localpackages', 'API\Admin\LocalpackagesController@store');
//     Route::middleware('auth:api')->put('localpackages', 'API\Admin\LocalpackagesController@update');
//     Route::middleware('auth:api')->get('localpackages', 'API\Admin\LocalpackagesController@index');
//     Route::middleware('auth:api')->get('localpackages/detail,', 'API\Admin\LocalpackagesController@detail');
	
// 	Route::middleware('auth:api')->post('domesticpackages', 'API\Admin\DomesticpackagesController@store');
//     Route::middleware('auth:api')->put('domesticpackages', 'API\Admin\DomesticpackagesController@update');
//     Route::middleware('auth:api')->get('domesticpackages', 'API\Admin\DomesticpackagesController@index');
//     Route::middleware('auth:api')->get('domesticpackages/detail,', 'API\Admin\DomesticpackagesController@detail');
	
// 	Route::middleware('auth:api')->post('courier-items', 'API\Admin\CourierItemsController@store');
//     Route::middleware('auth:api')->put('courier-items', 'API\Admin\CourierItemsController@update');
//     Route::middleware('auth:api')->get('courier-items', 'API\Admin\CourierItemsController@index');
//     Route::middleware('auth:api')->get('courier-items/detail,', 'API\Admin\CourierItemsController@detail');
	
    
//     Route::middleware('auth:api')->get('trees', 'API\Admin\TreeController@index');
    
//     Route::middleware('auth:api')->post('media', 'API\Admin\MediaController@save');
//     Route::middleware('auth:api')->get('media', 'API\Admin\MediaController@index');
//     Route::middleware('auth:api')->delete('media/{id}', 'API\Admin\MediaController@destroy')->where(['id' => '[0-9]+']);
    
// });

// Route::prefix('user')->group( function (){
    
//     Route::post('register', 'API\AuthUserController@register');
//     Route::post('upload', 'API\AuthUserController@upload');    
//     Route::post('login', 'API\AuthUserController@login');
//     Route::get('species', 'API\User\SpeciesController@index');
//     Route::get('species_detail', 'API\User\SpeciesController@detail');
    
//     Route::get('trees', 'API\User\TreeController@index');
//     Route::get('tree_detail', 'API\User\TreeController@detail');
    
//     Route::middleware('auth:api')->get('profile', 'API\User\ProfileController@getProfile');
//     Route::middleware('auth:api')->post('profile/image', 'API\User\ProfileController@upload');
//     Route::middleware('auth:api')->post('profile/update', 'API\User\ProfileController@saveProfile');
//     Route::middleware('auth:api')->get('logout', 'API\User\ProfileController@logout');
    
//     Route::middleware('auth:api')->post('add_tree', 'API\User\TreeController@store');
    
//     Route::post('forgot_password', 'API\AuthUserController@forgot');
    
//     Route::get('qr_code/{id}/{size}', 'API\User\QrcodeController@index')->where(['id' => '[0-9]+','size' => '[0-9]+']);
    
// });

