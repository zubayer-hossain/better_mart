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


Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('product-details/{product_code}', 'HomeController@product_details')->name('product_details');
Route::get('about-us', 'HomeController@about_us')->name('about_us');
Route::get('services', 'HomeController@services')->name('services');
Route::get('contact-us', 'HomeController@contact_us')->name('contact_us');
Route::get('login-register', 'HomeController@login_register')->name('login-register');
Route::get('cart', 'HomeController@cart')->name('cart');
Route::get('my-account', 'HomeController@my_account')->name('my_account');
Route::post('update-account-details', 'HomeController@updateAccountDetails')->name('update.account.details');
Route::post('update-password', 'HomeController@updatePassword')->name('update.password');
Route::get('add-to-cart/{id}', 'HomeController@addToCart')->name('add.to.cart');
Route::patch('update-cart', 'HomeController@updateCart')->name('update.cart');
Route::delete('remove-from-cart', 'HomeController@removeFromCart')->name('remove.from.cart');
Route::post('booking', 'HomeController@booking')->name('place.booking');
Route::post('send-feedback', 'HomeController@sendFeedback')->name('send.feedback');
Route::get('quick-view-product-details/{id}', 'HomeController@productDetailsQUickView')->name('quick_view.product_details');
Route::get('order-feedbacks/{id}', 'HomeController@orderFeedbacks')->name('order.feedbacks');

Route:: get('clear-cache', function(){
  \Artisan::call('optimize:clear');
});
Auth::routes();
