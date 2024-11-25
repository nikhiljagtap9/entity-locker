<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


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
    return view('welcome');
});


Route::get('/app', function () {
    return view('layout.app');
});

/*Route::get('/dashboard', function () {
    return view('batch.dashboard');
});*/

/*Route::get('/listing', function () {
    return view('batch.listing');
}); */

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/success_listing', [ListingController::class, 'successRequest'])->name('success_listing');
Route::get('/failed_listing', [ListingController::class, 'failedRequest'])->name('failed_listing');
Route::get('/total_listing', [ListingController::class, 'totalRequest'])->name('total_listing');




