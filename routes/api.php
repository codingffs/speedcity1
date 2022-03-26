<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\CmsController;
use App\Http\Controllers\API\FaqController;


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

Route::group(['middleware' => ['passportapi']], function(){
    Route::post('user-test',[RegisterController::class,'userTest'])->name('user-test');
});

Route::post('user-register',[RegisterController::class,'userRegister'])->name('user-register');
Route::post('user-login',[RegisterController::class,'userLogin'])->name('user-login');

Route::get('/cms/{slug?}',[CmsController::class,'cmsindex'])->name('cms');

Route::get('/faq-detail',[FaqController::class,'faqdetail'])->name('faqdetail');
