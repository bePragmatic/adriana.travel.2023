<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::match(['get', 'post'], 'api_payments/book/{id?}', 'PaymentPageController@index')->name('api_payments.book');
Route::post('api_payments/pre_accept', 'PaymentPageController@pre_accept');
Route::post('api_payments/create_booking', 'PaymentPageController@create_booking');
Route::get('api_payments/success', 'PaymentPageController@success');
Route::get('api_payments/cancel', 'PaymentPageController@cancel');
Route::post('api_payments/apply_coupon', 'PaymentPageController@apply_coupon');
Route::post('api_payments/remove_coupon', 'PaymentPageController@remove_coupon');


