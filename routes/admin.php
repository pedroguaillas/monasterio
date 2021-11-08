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
Route::get('statistics/chars', [StatisticsController::class, 'chars']);
Route::get('statistics/bymonth/{year}', [StatisticsController::class, 'byMonth']);
Route::get('statistics/byweek/{month}/year/{year}', [StatisticsController::class, 'byWeek']);
Route::get('metodosdepago', [PaymentMethodController::class, 'index']);

Route::get('statisticsReport', [StatisticsController::class, 'statisticsReport'])->name('reporte');
Route::get('monthReport/{id}', [StatisticsController::class, 'edit'])->name('monthReport');
