<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// HOME CONTROLLER
// ---------------
Route::get('/', 'HomeController@index');
Route::post('getAutoCompleteData', 'HomeController@getSearchAutocomplete');
Route::post('getNextItem', 'HomeController@getNextItemSliding');

// PRODUCT CONTROLLER
// ------------------
Route::get('product/search/{page}', 'ProductController@search');
Route::get('product/{menu}/{type}/{subtype}/{page}', 'ProductController@getList');
Route::get('product/navigation/{name}/{page}', 'ProductController@getNavigation');
Route::get('tile/{id}/{name}', 'ProductController@getTile');
Route::get('add-on/{id}/{name}', 'ProductController@getAddon');
Route::get('{name}/{type}', 'ProductController@getProduct');
Route::post('doGetCalcData', 'ProductController@getCalcData');
Route::post('doAddCartByCalc', 'ProductController@addCartByCalc');
Route::post('doAddTileToCart', 'ProductController@addTileToCart');
Route::post('doGetAddOnData', 'ProductController@getAddOnData');
Route::post('doAddAddonToCart', 'ProductController@addAddonToCart');

// AUTH CONTROLLER
// ---------------
Route::get('login', 'AuthController@index');
Route::post('doLogin', 'AuthController@doLogin');
Route::get('doLogout', 'AuthController@doLogout');
Route::get('reset-password', 'AuthController@resetPass');
Route::post('doResetPassword', 'AuthController@doResetPass');

// CART CONTROLLER
// ---------------
Route::get('cart', 'CartController@index');
Route::post('cart/shipping', 'CartController@shipping');
Route::post('doGetFeeData', 'CartController@getFeeData');
Route::post('doAddAddressToSession', 'CartController@addAddressToSession');
Route::post('cart/summary', 'CartController@summary');
Route::post('cart/finish', 'CartController@finish');
Route::get('cart/finish/{code}', 'CartController@toFinish');
Route::get('cart/back-step/{step}', 'CartController@back');
Route::post('doDeleteCart', 'CartController@delCart');

// PROFILE CONTROLLER
// ------------------
Route::get('profile', 'ProfileController@index');
Route::post('doChangeProfile', 'ProfileController@changeProfile');
Route::post('doChangePassword', 'ProfileController@changePass');
Route::get('profile/address', 'ProfileController@address');
Route::post('doGetAddressData', 'ProfileController@getAddressData');
Route::post('doAddAddress', 'ProfileController@addAddress');
Route::post('doAddAddressInCart', 'ProfileController@addAddressInCart');
Route::post('doEditAddress', 'ProfileController@editAddress');
Route::post('doDeleteAddress', 'ProfileController@delAddress');
Route::get('profile/order', 'ProfileController@order');
Route::get('profile/order/detail/{number}', 'ProfileController@orderDetail');
Route::get('profile/review', 'ProfileController@review');
Route::get('confirmation', 'ConfirmationController@index');
Route::post('doConfirm', 'ConfirmationController@confirm');
Route::get('register', 'RegisterController@index');
Route::post('doRegister', 'RegisterController@register');
Route::get('email-confirm{a}', 'RegisterController@doConfirm');

// LOOKBOOK CONTROLLER
// -------------------
Route::get('lookbook', 'LookbookController@index');

// SHOWROOM CONTROLLER
// -------------------
Route::get('showroom', 'ShowroomController@index');

// ABOUT CONTROLLER
// ----------------
Route::get('terms-and-conditions', 'AboutController@terms');
Route::get('privacy-policy', 'AboutController@privacy');

// UNAUTHORIZED
// ------------
Route::get('unauthorized', 'AuthController@unauthorized');

// FACEBOOK LOGIN
// --------------
Route::get('facebook', 'AuthController@redirectToProvider');
Route::get('facebook-callback/', 'AuthController@handleProviderCallback');