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

Route::get('logout','Auth\LoginController@logout');
Route::get('/', 'commonController\UserController@index');
Route::get('customer/login', 'commonController\UserController@customerlogin');
Route::resource('games', 'GameController');
//Route::get('register','Auth\RegisterController@register');
//Route::post('register','Auth\RegisterController@create');
Route::post('/register','RegistrationController@register');

//Route::get('register','commonController\UserController@registration')->name('register');
Route::group(['middleware' => 'auth'], function ($user) {
    /****** Admin Routes */
Route::get('admin/dashboard/{viewType?}','commonController\UserController@adminDashboard')->name('adminDashboard');
Route::get('admin/edit/{id}','commonController\UserController@adminEditCustomer')->name('adminEditCustomer');
Route::get('admin/create','commonController\UserController@adminCreateCustomer')->name('adminCreateCustomer');
Route::post('admin/update/{user}','commonController\UserController@postAdminUpdateCustomer')->name('postAdminUpdateCustomer');
Route::post('admin/create','commonController\UserController@postAdminCreateCustomer')->name('postAdminCreateCustomer');
Route::delete('admin/delete/{id}','commonController\UserController@adminDeleteCustomer')->name('adminDeleteCustomer');  
Route::get('admin/dashboardpost/{id}','commonController\UserController@adminHome2')->name('admin/dashboardpost');   
Route::post('logout','Auth\LoginController@logout')->name('logout');


Route::get('admin/create-contact/{userid}','commonController\UserController@adminCreateCustomerContact')->name('adminCreateCustomerContact');
Route::get('admin/dashboard/view-contacts/{userid}','commonController\UserController@adminDashboardViewCustomerContacts')->name('adminDashboardViewCustomerContacts');
Route::post('admin/create-contact','commonController\UserController@postAdminCreateCustomerContact')->name('postAdminCreateCustomerContact');
Route::delete('admin/delete-contact/{id}/{clientid}','commonController\UserController@adminDeleteCustomerContact')->name('adminDeleteCustomerContact');
Route::get('admin/edit-contact/{id}/{clientid}','commonController\UserController@adminEditCustomerContact')->name('adminEditCustomerContact');
Route::post('admin/edit-contact/{id}/{clientid}','commonController\UserController@adminPostEditCustomerContact')->name('adminPostEditCustomerContact');
 /****** Admin Routes End*/


 /********Customer Routes */
 Route::get('customer/dashboard','commonController\UserController@customerDashboard')->name('customerDashboard');
 Route::delete('customer/delete-contact/{id}/{clientid}','commonController\UserController@customerDeleteCustomerContact')->name('customerDeleteCustomerContact');
 Route::get('customer/edit-contact/{id}/{clientid}','commonController\UserController@customerEditCustomerContact')->name('customerEditCustomerContact');
Route::post('customer/edit-contact/{id}/{clientid}','commonController\UserController@customerPostEditCustomerContact')->name('customerPostEditCustomerContact');
Route::get('customer/create-contact/{userid}','commonController\UserController@customerCreateCustomerContact')->name('customerCreateCustomerContact');
Route::post('customer/create-contact','commonController\UserController@postCustomerCreateCustomerContact')->name('postCustomerCreateCustomerContact');

});
Auth::routes();