<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// LOGIN ROUTING
// -------------
Route::get('/', 'LoginController@index');

// AUTHENTICATION ROUTING
// ----------------------
Route::post('doLogin', 'AuthController@doLogin');
Route::get('doLogout', 'AuthController@doLogout');

// HOME ROUTING
// ------------
Route::get('home', 'HomeController@index');

// ADMIN ROUTING
// -------------
Route::get('user/admin-manager', 'AdminController@index');
Route::post('doAddAdmin', 'AdminController@addAdmin');
Route::post('doGetAdminData', 'AdminController@getData');
Route::post('doEditAdmin', 'AdminController@editAdmin');
Route::post('doDeleteAdmin', 'AdminController@delAdmin');

// CUSTOMER ROUTING
// -------------
Route::get('user/customer-manager', 'CustomerController@index');
Route::post('doAddCustomer', 'CustomerController@addAdmin');
Route::post('doGetCustomerData', 'CustomerController@getData');
Route::post('doEditCustomer', 'CustomerController@editCustomer');
Route::post('doDeleteCustumer', 'CustomerController@delCustomer');

// PROVINCE ROUTING
// ----------------
Route::get('location/province-manager', 'ProvinceController@index');
Route::post('location/province-manager', 'ProvinceController@doSearch');
Route::post('doAddProvince', 'ProvinceController@addProvince');
Route::post('doEditProvince', 'ProvinceController@editProvince');
Route::post('doDeleteProvince', 'ProvinceController@delProvince');

// CITY ROUTING
// ------------
Route::get('location/city-manager', 'CityController@index');
Route::post('location/city-manager', 'CityController@doSearch');
Route::post('doAddCity', 'CityController@addCity');
Route::post('getCityData', 'CityController@getData');
Route::post('doEditCity', 'CityController@editCity');
Route::post('doDeleteCity', 'CityController@delCity');

// PHOTO UPLOADER ROUTING
// ----------------------
Route::get('photo-manager', 'PhotoController@index');
Route::post('doUploadPhoto', 'PhotoController@doUpload');
Route::post('doGetAllFolderType', 'PhotoController@getAllFolderType');
Route::post('doDeletePhoto', 'PhotoController@delPhoto');
Route::post('doAddFolder', 'PhotoController@addFolder');
Route::post('doEditFolder', 'PhotoController@editFolder');
Route::post('doGetFolderData', 'PhotoController@getFolderData');
Route::post('doDeleteFolder', 'PhotoController@delFolder');
Route::post('doChangeFolder', 'PhotoController@changeFolder');

// CATEGORY ROUTING
// ----------------
Route::get('category-manager', 'CategoryController@index');
Route::post('category-manager', 'CategoryController@doSearch');
Route::post('doAddCategory', 'CategoryController@addCategory');
Route::post('doEditCategory', 'CategoryController@editCategory');
Route::post('doDeleteCategory', 'CategoryController@delCategory');

// SUB CATEGORY ROUTING
// --------------------
Route::post('doAddSubCategory', 'CategoryController@addSubCategory');
Route::post('doGetSubCategoryData', 'CategoryController@getSubCategory');
Route::post('doEditSubCategory', 'CategoryController@editSubCategory');
Route::post('doDeleteSubCategory', 'CategoryController@delSubCategory');

// TAG ROUTING
// -----------
Route::get('tag-manager', 'TagController@index');
Route::post('doAddTag', 'TagController@addTag');
Route::post('doEditTag', 'TagController@editTag');
Route::post('doDeleteTag', 'TagController@delTag');
Route::post('doChangeShowedTag', 'TagController@changeShowedTag');

// SUB TAG ROUTING
// ---------------
Route::post('doAddSubTag', 'TagController@addSubTag');
Route::post('doGetSubTagData', 'TagController@getSubTag');
Route::post('doEditSubTag', 'TagController@editSubTag');
Route::post('doDeleteSubTag', 'TagController@delSubTag');

// NAVIGATION ROUTING
// ------------------
Route::get('navigation-manager', 'NavigationController@index');
Route::post('doAddNavigation', 'NavigationController@addNavigation');
Route::post('doGetNavigationData', 'NavigationController@getData');
Route::post('doEditNavigation', 'NavigationController@editNavigation');
Route::post('doDeleteNavigation', 'NavigationController@delNavigation');

// BRAND ROUTING
// -------------
Route::get('brand-manager', 'BrandController@index');
Route::post('doAddBrand', 'BrandController@addBrand');
Route::post('getBrandData', 'BrandController@getData');
Route::post('doEditBrand', 'BrandController@editBrand');
Route::post('doDeleteBrand', 'BrandController@delBrand');
Route::post('doEditBrandOrderBy', 'BrandController@editOrderBy');

// INSTALLATION ROUTING
// --------------------
Route::get('installation-manager', 'InstallationController@index');
Route::post('doGetInstallationData', 'InstallationController@getData');
Route::post('doAddInstallation', 'InstallationController@addInstallation');
Route::post('doEditInstallation', 'InstallationController@editInstallation');
Route::post('doDeleteInstallation', 'InstallationController@delInstallation');

// FEE ROUTING
// -----------
Route::get('fee-manager', 'FeeController@index');
Route::post('fee-manager', 'FeeController@doSearch');
Route::post('doUploadFee', 'FeeController@doUpload');
Route::get('doExportFee', 'FeeController@doExport');

// TILE ITEM ROUTING
// -----------------
Route::get('item/tile-manager', 'TileController@index');
Route::post('item/tile-manager', 'TileController@doSearch');
Route::post('doEditTile', 'TileController@editTile');
Route::post('doDeleteTile', 'TileController@delTile');
Route::post('doUploadTile', 'TileController@doUpload');
Route::get('doExportTile', 'TileController@doExport');
Route::post('doGetTileData', 'TileController@getData');

// ADD ON ITEM ROUTING
// -------------------
Route::get('item/add-on-manager', 'AddonController@index');
Route::post('doUploadAddon', 'AddonController@doUpload');
Route::get('doExportAddon', 'AddonController@doExport');

// ORDER ROUTING
// -------------
Route::get('order-manager', 'OrderController@index');
Route::post('doChangeStatus', 'OrderController@changeStatus');
Route::post('doGetPaymentData', 'OrderController@getPayment');
Route::get('order-manager/detail/{id}', 'OrderController@getDetail');
Route::post('order-manager/add-order', 'OrderController@add');
Route::get('order-manager/edit/{id}', 'OrderController@edit');
Route::post('doGetItemData', 'OrderController@getItem');
Route::post('doAddOrder', 'OrderController@addOrder');
Route::post('doEditOrder', 'OrderController@editOrder');