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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

/* VF Sample Site Routes */

/*
// Login
Route::get('/samples/login', 'SampleController@login')->name("sample-login");
Route::post('/samples/login', 'SampleController@login');

// Logout
Route::post('/samples/logout', 'SampleController@logout')->name('sample-logout');

// Inventory List (No Longer In Use)
//Route::get('/samples/inventory', 'SampleController@inventory')->name("sample-inventory");

// My Orders (Dashboard)
Route::get('/samples', 'SampleController@orders')->name("sample-orders");
Route::get('/samples/orders', 'SampleController@orders');
Route::get('/samples/orders/{id}', 'SampleController@viewOrder')->name("sample-view-order");
Route::post('/samples/orders/edit', 'SampleController@editOrder')->name("sample-edit-order");

// Reset Session
Route::get('/samples/resetSession', 'SampleController@resetSession')->name("reset-session");

// Addresses
Route::get('/samples/address', 'SampleController@address')->name("sample-address");
Route::post('/samples/address', 'SampleController@address');
Route::post('/samples/address/update', 'SampleController@addressUpdate');
Route::post('/samples/address/existing/{id}', 'SampleController@addressSelectExisting');

// Shopping Cart
Route::get('/samples/cart', 'SampleController@cart')->name("sample-cart");

// Shopping Cart Add
Route::post('/samples/cart/add', 'SampleController@cartAdd')->name("sample-cart-add");

// Shopping Cart Modify
Route::post('/samples/cart/modify', 'SampleController@cartModify')->name("sample-cart-modify");

// Sample Details Modal
Route::get('/samples/cart/modal/{id}', 'SampleController@sampleDetailsModal')->name("sample-details-modal");

// Sample Details (No Longer In Use)
//Route::get('/samples/cart/{id}', 'SampleController@sampleDetails')->name("sample-details");

// Checkout
Route::get('/samples/checkout', 'SampleController@checkout')->name("sample-checkout");

// Checkout Process
Route::get('/samples/checkout/process', 'SampleController@checkoutProcess')->name("sample-checkout-process");
Route::post('/samples/checkout/process', 'SampleController@checkoutProcess');

// View Inventory Item
Route::get('/samples/inventory/{id}', 'SampleController@viewInventory')->name("sample-inventory-item");
*/


/* VF Scheduler Routes (Using /vf folder.) */

/*
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
*/


// Scheduling App
Route::domain('appointments.vaneefoods.com')->group(function () {
    /* VF Scheduler Routes (Using /vf folder.) */
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
});

// Samples App
Route::domain('samples.vanee.com')->group(function () {
    /* VF Sample Site Routes */

    // Login
    Route::get('/login', 'SampleController@login')->name("sample-login");
    Route::post('/login', 'SampleController@login');

    // Login OAuth
    Route::get('/login/oauth', 'SampleController@oauth')->name("sample-oauth");
    Route::post('/login/oauth', 'SampleController@oauth');

    // Logout
    Route::post('/logout', 'SampleController@logout')->name('sample-logout');

    // Inventory List (No Longer In Use)
    //Route::get('/inventory', 'SampleController@inventory')->name("sample-inventory");

    // My Orders (Dashboard)
    Route::get('/', 'SampleController@orders')->name("sample-orders");
    Route::get('/orders', 'SampleController@orders');

    // View Order Details
    Route::get('/orders/{id}', 'SampleController@viewOrder')->name("sample-view-order");

    // Edit Order
    Route::post('/orders/edit', 'SampleController@editOrder')->name("sample-edit-order");
    Route::get('/orders/edit/{id}', 'SampleController@editOrder');

    // Reset Session
    Route::get('/resetSession', 'SampleController@resetSession')->name("reset-session");

    // Addresses
    Route::get('/address', 'SampleController@address')->name("sample-address");
    Route::post('/address', 'SampleController@address');
    Route::post('/address/update', 'SampleController@addressUpdate');
    Route::post('/address/existing/{id}', 'SampleController@addressSelectExisting');

    // Create New Using Get Params
    Route::get('/address/create', 'SampleController@addressParams')->name("sample-address-params");

    // Shopping Cart
    Route::get('/cart', 'SampleController@cart')->name("sample-cart");

    // Shopping Cart Add
    Route::post('/cart/add', 'SampleController@cartAdd')->name("sample-cart-add");

    // Shopping Cart Modify
    Route::post('/cart/modify', 'SampleController@cartModify')->name("sample-cart-modify");

    // Sample Details Modal
    Route::get('/cart/modal/{id}', 'SampleController@sampleDetailsModal')->name("sample-details-modal");

    // Shopping Cart Search Filter
    Route::post('/cart/search', 'SampleController@cartSearch')->name("sample-cart-search");

    // Sample Details (No Longer In Use)
    //Route::get('/cart/{id}', 'SampleController@sampleDetails')->name("sample-details");

    // Checkout
    Route::get('/checkout', 'SampleController@checkout')->name("sample-checkout");

    // Checkout Process
    Route::get('/checkout/process', 'SampleController@checkoutProcess')->name("sample-checkout-process");
    Route::post('/checkout/process', 'SampleController@checkoutProcess');

    // View Inventory Item
    Route::get('/inventory/{id}', 'SampleController@viewInventory')->name("sample-inventory-item");

    Route::get('/?newOrder', 'SampleController@newOrder')->name("sample-new-order");

});

Route::post('/login', 'SampleController@login');