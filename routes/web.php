<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes();
Route::get('/keytest', 'AdminController@keytest');
Route::middleware('auth:web')->group(function () {
    //Route::get('/test', 'AdminController@customerassigns');
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/operatorhome', 'HomeController@index')->name('operatorhome');
    Route::get('/administratorhome', 'HomeController@index')->name('administratorhome');
    Route::get('/partnerhome', 'HomeController@index')->name('partnerhome');
    Route::get('/customerhome', 'HomeController@index')->name('customerhome');


    Route::post('/admin/user/crud', 'AdminHomeController@userCRUD');

    Route::post('/admin/package/init', 'AdminPackageController@packageinit');
    Route::post('/admin/package/crud', 'AdminPackageController@packageCRUD');

    Route::post('/admin/customer/form/init', 'AdminCusFormController@forminit');
    Route::post('/admin/customer/form/entry', 'AdminCusFormController@formCrud');

    Route::post('/admin/customer/init', 'CustomerController@customerInit');

    Route::post('/admin/customer/fields', 'AdminCusFieldController@fieldsinit');
    Route::post('/admin/customer/fields/crud', 'AdminCusFieldController@customerfieldCRUD');


    
    // Route::get('/check', 'UserController@userOnlineStatus');
    ///////////////////////Data Provider APIs //////////////////////////////////
    Route::post('/admin/random/all', 'AdminHomeController@all');
    
    Route::post('/admin/random/all/card', 'AdminController@allcard');

    
///////////////////////////testing APIs //////////////////////////////////////////////////////////////////////////
    Route::post('/admin/customer/user/assigns', 'AdminController@customerassigns');
    Route::post('/admin/user/customer/assigns', 'AdminController@userassigns');
    Route::post('/admin/customer/package/assign', 'AdminController@packageassign');
    Route::post('/admin/customer/worker/assign', 'AdminController@workerassign');
    Route::post('/admin/customer/worker/remove', 'AdminController@workerremove');

        //Route::post('/admin/template/features', 'AdminController@templatefeatures');


    Route::post('/admin/customer/enter/site', 'AdminController@adminsite');
    Route::post('/admin/worker/fields/perm', 'AdminController@fieldsperm');


////Administrator/////////////////////////////////////////////////////////////////////////////////////////////

Route::post('/administrator/random/all', 'AdministratorHomeController@administratorall');

Route::post('/administrator/workers/all', 'AdministratorHomeController@workersall');
Route::post('/administrator/assigned/all', 'AdministratorHomeController@customersall');
Route::post('/administrator/assigned/customers/all', 'AdministratorHomeController@all');
Route::post('/administrator/assigned/user/crud', 'AdministratorHomeController@userCRUD');


Route::post('/administrator/assigned/customer/fields', 'AdministratorCusFieldController@fieldsinit');
Route::post('/administrator/assigned/customer/fields/crud', 'AdministratorCusFieldController@customerfieldCRUD');

Route::post('/administrator/assigned/customer/form/init', 'AdministratorCusFormController@forminit');
Route::post('/administrator/assigned/customer/form/entry', 'AdministratorCusFormController@formCrud');
//////////////////Customer//////////////////////////////////////////////////////////////////////////////////////////////////

Route::post('/customer/filters/alldd', 'CustomerController@alldd');

});





