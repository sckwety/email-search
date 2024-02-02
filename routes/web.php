<?php

use App\Http\Controllers\EmailSearchController;
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

Route::get('/', function () {
    return redirect()->route('email-search');
});

Route::get('/email-search', [EmailSearchController::class, 'searchForm'])->name('email-search');
Route::post('/email-search', [EmailSearchController::class, 'search']);
