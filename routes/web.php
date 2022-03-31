<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourierItemsController;
// use App\Http\Controllers\MedicalApplianceController;
// use App\Http\Controllers\SupplierController;
// use App\Http\Controllers\RoleController;
// use App\Http\Controllers\PermissionController;
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\ActivityLogController;
// use App\Http\Controllers\OnlinePlatformController;
// use App\Http\Controllers\AttributeController;       
// use App\Http\Controllers\SubAttributeController;
// use App\Http\Controllers\ServicesController;
// use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SpeciesController;
use App\Http\Controllers\SettingController;
// use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\OfficesController;
use App\Http\Controllers\BranchUserController;
use App\Http\Controllers\LocalPackageController;
use App\Http\Controllers\DomesticPackageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;


@include_once('admin_web.php');
Route::group(['prefix' => 'admin'], function()
{
Route::get("login", [LoginController::class, "showLoginForm"])->name("login");


Route::get("register", [HomeController::class, "showRegisterForm"])->name("register");
Route::post("register", [HomeController::class, "register_submit"])->name("register_submit");
Route::post("login", [LoginController::class, "login"])->name("login_submit");
Route::get("check_email_exists_in_users", [HomeController::class, "check_email_exists_in_users"])->name("check_email_exists_in_users");
Route::get("check_email_exists_in_update", [HomeController::class, "check_email_exists_in_update"])->name("check_email_exists_in_update");
Route::get("logout", [LoginController::class, "logout"])->name("logout");

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
// Route::get('/',[HomeController::class, 'index1'])->name('index1');

Route::group(['middleware' => ['auth']], function()
{
    Route::view('/dashboard', 'admin.dashboard.dashboard')->name('index');
    // Route::get("/Courierlist", [CourierItemsController::class, "Courierlist"])->name("Courierlist");
    Route::resource('Courierlist', CourierItemsController::class);
    Route::resource('species', SpeciesController::class);
    Route::resource('domesticpackage', DomesticPackageController::class);

    Route::get("edit_profile", [ProfileController::class, "edit_profile"])->name("edit_profile");
    Route::post("update_profile", [ProfileController::class, "update_profile"])->name("update_profile");
    Route::get("change_password", [ProfileController::class, "change_password"])->name("change_password");
    Route::post("change_password", [ProfileController::class, "change_password_post"])->name("change_password_post");

    Route::resource('offices', OfficesController::class);
    Route::resource('localPackage', LocalPackageController::class);
    // Route::resource('domesticpackage', DomesticPackageController::class);
    Route::resource('user', UserController::class);
    Route::resource('branch', BranchController::class);

    // Route::get('/suppliers', [SupplierController::class, "list"])->name('suppliers');
    // Route::get('suppliers/edit/{id}', [SupplierController::class, "edit"])->name('suppliers.edit');
    // Route::post('suppliers/update/{id}', [SupplierController::class, "update"])->name('suppliers.update');
    // Route::post('suppliers/approve/{id}', [SupplierController::class, "approve"])->name('suppliers.approve');
    // Route::post('suppliers/reject/{id}', [SupplierController::class, "reject"])->name('suppliers.reject');
    // Route::delete('suppliers/delete/{id}', [SupplierController::class, "delete"])->name('suppliers.delete');
    
    // Attribute
    // Route::get('/attributes', [AttributeController::class, "list"])->name('attributes');
    // Route::get('attributes/create', [AttributeController::class, "create"])->name('attributes.create');
    // Route::post('attributes/store', [AttributeController::class, "store"])->name('attributes.store');
    // Route::get('attributes/edit/{id}', [AttributeController::class, "edit"])->name('attributes.edit');
    // Route::post('attributes/update/{id}', [AttributeController::class, "update"])->name('attributes.update');
    // Route::delete('attributes/delete/{id}', [AttributeController::class, "delete"])->name('attributes.delete');
    // Route::post('get_dynamic_attribute', [AttributeController::class, "get_dynamic_attribute"])->name('get_dynamic_attribute');
    
    // Sub attributes 
    // Route::get('sub_attributes/{id}', [SubAttributeController::class, "list"])->name('sub_attributes');
    // Route::get('sub_attributes/create/{attribute_id}', [SubAttributeController::class, "create"])->name('sub_attributes.create');
    // Route::post('sub_attributes/store/{attribute_id}', [SubAttributeController::class, "store"])->name('sub_attributes.store');
    // Route::get('sub_attributes/edit/{id}', [SubAttributeController::class, "edit"])->name('sub_attributes.edit');
    // Route::post('sub_attributes/update/{id}', [SubAttributeController::class, "update"])->name('sub_attributes.update');
    // Route::delete('sub_attributes/delete/{id}', [SubAttributeController::class, "delete"])->name('sub_attributes.delete');
    
    // Category
    // Route::resource('categories', CategoryController::class);
    // Route::get("check_title_exists", [CategoryController::class, "check_title_exists"])->name("check_title_exists");
    // Route::get("check_title_exists_update", [CategoryController::class, "check_title_exists_update"])->name("check_title_exists_update");
    
    // Route::resource('services', ServicesController::class);
    // Route::get("check_title_exists_service", [ServicesController::class, "check_title_exists_service"])->name("check_title_exists_service");
    // Route::get("check_title_edit_exists_service", [ServicesController::class, "check_title_edit_exists_service"])->name("check_title_edit_exists_service");
    
    // Route::resource('doctor', DoctorController::class);
    // Route::get('getStates/{id}', [DoctorController::class, "getStates"])->name('getStates');
    // Route::get('getCities/{id}', [DoctorController::class, "getCities"])->name('getCities');
    // Route::get('doctorShow/{id}', [DoctorController::class, "doctorShow"])->name('doctorShow');
    
    // Route::resource('disease', DiseaseController::class);
    
    // Route::resource('degree', DegreeController::class);
    
    // Route::resource('country', CountryController::class);
    // Route::get("check_country_exists_update", [CountryController::class, "check_country_exists_update"])->name("check_country_exists_update");
    
    // Route::resource('state', StateController::class);
    // Route::get("check_state_exists_in_country", [StateController::class, "check_state_exists_in_country"])->name("check_state_exists_in_country");
    // Route::get("check_state_exists_in_update", [StateController::class, "check_state_exists_in_update"])->name("check_state_exists_in_update");
    
    // Route::resource('city', CityController::class);
    // Route::get("check_city_exists_in_state", [CityController::class, "check_city_exists_in_state"])->name("check_city_exists_in_state");
    // Route::get("check_city_exists_in_update", [CityController::class, "check_city_exists_in_update"])->name("check_city_exists_in_update");
    
    // Route::resource('faq', CategoryFaqController::class);
    
    // Route::resource('subfaq', CategorySubFaqController::class);
    
    // Route::resource('settings', SettingController::class);
    
    // Route::resource('cms', CmsController::class);
    
    // Route::resource('additionalservice', AdditionalServiceController::class);
    
    // Route::resource('medicalappliance', MedicalApplianceController::class);
    // Route::get("check_medical_title_exists", [MedicalApplianceController::class, "check_medical_title_exists"])->name("check_medical_title_exists");
    // Route::get("check_medical_title_exists_update", [MedicalApplianceController::class, "check_medical_title_exists_update"])->name("check_medical_title_exists_update");

    // Route::resource('carepackage', CarePackageController::class);
    // Route::get("care_title_exists", [CarePackageController::class, "care_title_exists"])->name("care_title_exists");
    // Route::get("care_title_exists_update", [CarePackageController::class, "care_title_exists_update"])->name("care_title_exists_update");
    // Route::post("remove_added_package", [CarePackageController::class, "remove_added_package"])->name("remove_added_package");
    
    // // Products
    // Route::get("products",[ProductController::class, "list"])->name("products");
    // Route::get("products/create",[ProductController::class, "create"])->name("products.create"); 
    // Route::post('products/store', [ProductController::class, "store"])->name('products.store');
    // Route::get('products/edit/{id}', [ProductController::class, "edit"])->name('products.edit');
    // Route::post('products/update/{id}', [ProductController::class, "update"])->name('products.update');
    // Route::delete('products/delete/{id}', [ProductController::class, "delete"])->name('products.delete');
    // Route::post('products_change_status', [ProductController::class, "products_change_status"])->name('products_change_status');
    // Route::get('products_attribute/{id}', [ProductController::class, "products_attribute"])->name('products_attribute');
    // Route::post('check_name_exists_in_products', [ProductController::class, "check_name_exists_in_products"])->name('check_name_exists_in_products');
    // Route::get('product_add_to_shopify/{id}', [ProductController::class, "product_add_to_shopify"])->name('product_add_to_shopify');

    // Route::delete('product_image_delete', [ProductController::class, "product_image_delete"])->name('product_image_delete');

   
    
    // Route::get("online_platform", [OnlinePlatformController::class, "index"])->name("online_platform");
    // Route::post("online_platform", [OnlinePlatformController::class, "store"])->name("online_platform.store");
    
    
    // Route::resource('roles', RoleController::class);
    
    // Route::resource('permission', PermissionController::class);

    // Route::get('activity_log', [ActivityLogController::class, "list"])->name("activity_log");
    // Route::resource('user', UserController::class);
    
    // Route::resource('staff', StaffController::class);


    Route::resource('offices', OfficesController::class);
    Route::resource('localPackage', LocalPackageController::class);
    Route::resource('branchuser', BranchUserController::class);
    // Route::resource('domesticpackage', DomesticPackageController::class);
    Route::resource('user', UserController::class);

    // Consignment
    // Route::get("consignment",[ConsignmentController::class, "list"])->name("consignment");
    // Route::get("consignment/create",[ConsignmentController::class, "create"])->name("consignment.create"); 
    // Route::post('consignment/store', [ConsignmentController::class, "store"])->name('consignment.store');
    // Route::get('consignment/edit/{id}', [ConsignmentController::class, "edit"])->name('consignment.edit');
    // Route::post('consignment/update/{id}', [ConsignmentController::class, "update"])->name('consignment.update');
    // Route::delete('consignment/delete/{id}', [ConsignmentController::class, "delete"])->name('consignment.delete');
    // Route::post('get_product_detail_for_consignment', [ConsignmentController::class, "get_product_detail_for_consignment"])->name('get_product_detail_for_consignment');
    

    // Route::get('offices', [OfficesController::class,'offices'])->name('offices');


});
});

// Route::view('sample-page', 'admin.pages.sample-page')->name('sample-page');

// Route::view('default', 'admin.dashboard.default')->name('dashboard.index');

// Route::view('default-layout', 'multiple.default-layout')->name('default-layout');
// Route::view('compact-layout', 'multiple.compact-layout')->name('compact-layout');
// Route::view('modern-layout', 'multiple.modern-layout')->name('modern-layout');
