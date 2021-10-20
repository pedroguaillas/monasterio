<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index']);

Route::resource('customers', CustomerController::class)->only(['index', 'create', 'store']);

Route::get('contabilidad', [AccountingController::class,'index']);
