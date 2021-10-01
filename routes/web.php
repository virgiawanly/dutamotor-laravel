<?php

use App\Http\Controllers\MobilController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PembeliController;
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

Route::get('/', [PageController::class, 'dashboard']);

Route::get('/mobil/tambah-mobil', [MobilController::class, 'create']);
Route::resource('/mobil', MobilController::class)->except(['show']);

Route::get('/pembeli/register-pembeli', [PembeliController::class, 'create']);
Route::resource('/pembeli', PembeliController::class)->except(['show']);