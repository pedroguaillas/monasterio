<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\AuthFingerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('autenticacion', [AuthFingerController::class, 'index'])->name('autenticacion');
Route::get('fingers', [AuthFingerController::class, 'fingers'])->name('fingers');
Route::get('fingers/show/{customer}', [AuthFingerController::class, 'showCustomer'])->name('fingers.show');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
