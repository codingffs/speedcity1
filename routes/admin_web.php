<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
});

// suppliers
Route::get("suppliers", [])->name("suppliers");

Route::prefix('widgets')->group(function () {
	Route::view('general-widget', 'admin.widgets.general-widget')->name('general-widget');
	Route::view('chart-widget', 'admin.widgets.chart-widget')->name('chart-widget');
});
