<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

// Landing page home
Route::get('/', 'Guest\HomeController@index')->name('home');


// Other pages
Route::resource('restaurants', 'RestaurantController');
Route::resource('dishes', 'DishController');
Route::resource('orders', 'OrderController');


//! Se vi segna un errore su Auth non fateci caso
Auth::routes();
/* Questo helper genera tutte queste routes sotto banco
Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');
*/


// redirect default laravel routes to custom routes
Route::redirect('register', 'restaurants/create');
// Route::redirect('login', 'restaurants/login');

// Redirect not registered routes to homepage
Route::get('{any?}', function () {
    return view('guest.home');
});
