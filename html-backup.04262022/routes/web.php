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
    return view('welcome');
});

Route::get('user', "user@index");

// VF Sample Site Routes
Route::get('/samples', 'SampleController@inventory')->name("sample-inventory");

Route::get('/samples/login', 'SampleController@login')->name("sample-login");
Route::post('/samples/login', 'SampleController@login');

// VF Scheduler Routes (Using /vf folder.)

Route::get('/vf/', 'VFController@schedule')->name("vf-schedule");

Route::get('/vf/search-order/', 'VFController@searchOrder');
Route::post('/vf/search-order/', 'VFController@searchOrder');

Route::get('/vf/validate-location/', 'VFController@validateLocation');
Route::post('/vf/validate-location/', 'VFController@validateLocation');

Route::get('/vf/search-date/', 'VFController@searchDate');
Route::post('/vf/search-date/', 'VFController@searchDate');

Route::get('/vf/create-order/', 'VFController@createOrder');
Route::post('/vf/create-order/', 'VFController@createOrder');

Route::get('/vf/sample/order', 'VFController@sampleOrder');


// VF Scheduler Routes

Route::get('/', 'VFController@schedule')->name("vf-schedule");

Route::get('/search-order/', 'VFController@searchOrder');
Route::post('/search-order/', 'VFController@searchOrder');

Route::get('/validate-location/', 'VFController@validateLocation');
Route::post('/validate-location/', 'VFController@validateLocation');

Route::get('/search-date/', 'VFController@searchDate');
Route::post('/search-date/', 'VFController@searchDate');

Route::get('/create-order/', 'VFController@createOrder');
Route::post('/create-order/', 'VFController@createOrder');

Route::get('/sample/order', 'VFController@sampleOrder');
