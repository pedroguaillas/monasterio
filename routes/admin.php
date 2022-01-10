<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index'])->name('admin.home');

Route::resource('customers', CustomerController::class)->only(['index', 'create', 'store']);

Route::get('contabilidad', [AccountingController::class, 'index'])->name('admin.contabilidad');

Route::get('estadistica', [StatisticsController::class, 'index'])->name('admin.estadistica');
Route::get('statistics/chars', [StatisticsController::class, 'chars']);
Route::get('statistics/bymonth/{year}', [StatisticsController::class, 'byMonth']);
Route::get('statistics/byweek/{month}/year/{year}', [StatisticsController::class, 'byWeek']);

Route::get('servicios', [PaymentMethodController::class, 'index'])->name('admin.servicios');
Route::get('services/{paymentMethod}', [PaymentMethodController::class, 'show']);

Route::get('usuarios', [UserController::class, 'index'])->name('admin.usuarios');

Route::get('statisticsReport', [StatisticsController::class, 'statisticsReport'])->name('reporte');
Route::get('monthReport/{id}', [StatisticsController::class, 'edit'])->name('monthReport');
