<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Chart\Customers;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index'])->name('admin.home');

Route::resource('customers', CustomerController::class);

Route::get('contabilidad', [AccountingController::class, 'index'])->name('admin.contabilidad');
Route::get('diarios', [DiaryController::class, 'index'])->name('admin.diarios');

Route::get('estadistica', [StatisticsController::class, 'index'])->name('admin.estadistica');
Route::get('statistics/chars', [StatisticsController::class, 'chars']);
Route::get('statistics/bymonth/{year}', [StatisticsController::class, 'byMonth']);
Route::get('statistics/byweek/{month}/year/{year}', [StatisticsController::class, 'byWeek']);

Route::resource('servicios', PaymentMethodController::class)->only(['index', 'show', 'destroy']);

Route::resource('usuarios', UserController::class)->only(['index', 'create', 'store', 'destroy']);
Route::get('usuarios/{customer_id}/pagos', [PaymentController::class, 'index'])->name('admin.pagos');

Route::get('reporte-general', [StatisticsController::class, 'general'])->name('reportegeneral');
Route::get('reporte-por-meses/{id}', [StatisticsController::class, 'months'])->name('reportepormeses');
// Route::get('reporte-por-dias-del-mes/{mes}/año/{mes}', [StatisticsController::class, 'byWeekPdf'])->name('reportepordiasdelmeses');

// charts
Route::get('grafico/clientes', Customers::class)->name('admin.graficocliente');
