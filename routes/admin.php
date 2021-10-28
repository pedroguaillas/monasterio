<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index']);

Route::resource('customers', CustomerController::class)->only(['index', 'create', 'store']);

Route::get('contabilidad', [AccountingController::class, 'index']);

Route::get('estadistica', [StatisticsController::class, 'index']);
Route::get('statistics/bymonth/{year}', [StatisticsController::class, 'byMonth']);

Route::get('metodosdepago', [PaymentMethodController::class, 'index']);
