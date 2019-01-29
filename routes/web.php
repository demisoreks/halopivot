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

Route::get('/', [
    'as' => 'welcome', 'uses' => 'LoginController@index'
]);
Route::post('authenticate', [
    'as' => 'authenticate', 'uses' => 'LoginController@authenticate'
]);
Route::get('dashboard', [
    'as' => 'dashboard', 'uses' => 'LoginController@dashboard'
])->middleware('auth.user');
Route::get('logout', [
    'as' => 'logout', 'uses' => 'LoginController@logout'
]);

Route::get('access', [
    'as' => 'access', 'uses' => 'AccessControlController@index'
]);

Route::get('access/employees/{employee}/disable', [
    'as' => 'employees.disable', 'uses' => 'EmployeesController@disable'
]);
Route::get('access/employees/{employee}/enable', [
    'as' => 'employees.enable', 'uses' => 'EmployeesController@enable'
]);
Route::resource('access/employees', 'EmployeesController');
Route::bind('employees', function($value, $route) {
    return App\AccEmployee::findBySlug($value)->first();
});

Route::get('access/general_links/{general_link}/disable', [
    'as' => 'general_links.disable', 'uses' => 'GeneralLinksController@disable'
]);
Route::get('access/general_links/{general_link}/enable', [
    'as' => 'general_links.enable', 'uses' => 'GeneralLinksController@enable'
]);
Route::resource('access/general_links', 'GeneralLinksController');
Route::bind('general_links', function($value, $route) {
    return App\AccGeneralLink::findBySlug($value)->first();
});

Route::get('access/privileged_links/{privileged_link}/disable', [
    'as' => 'privileged_links.disable', 'uses' => 'PrivilegedLinksController@disable'
]);
Route::get('access/privileged_links/{privileged_link}/enable', [
    'as' => 'privileged_links.enable', 'uses' => 'PrivilegedLinksController@enable'
]);
Route::resource('access/privileged_links', 'PrivilegedLinksController');
Route::bind('privileged_links', function($value, $route) {
    return App\AccPrivilegedLink::findBySlug($value)->first();
});