<?php

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
    return view('guest.home');
});

<<<<<<< HEAD
Route::resource('restaurants','RestaurantController');

Route::resource('orders','OrderController');

=======
Route::resource('restaurants', 'RestaurantController');
>>>>>>> 2c7ca8e95c3234083c95c0a0188a0e18bd27b177
