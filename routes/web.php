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

$link_id = 1;

Route::get('/', [
    'as' => 'welcome', 'uses' => 'LoginController@index'
]);
Route::post('authenticate', [
    'as' => 'authenticate', 'uses' => 'LoginController@authenticate'
]);
Route::get('change_password/{employee}', [
    'as' => 'change_password', 'uses' => 'LoginController@change_password'
]);
Route::post('update_password/{employee}', [
    'as' => 'update_password', 'uses' => 'LoginController@update_password'
]);
Route::get('dashboard', [
    'as' => 'dashboard', 'uses' => 'LoginController@dashboard'
])->middleware('auth.user');
Route::get('logout', [
    'as' => 'logout', 'uses' => 'LoginController@logout'
]);

Route::get('access', [
    'as' => 'access', 'uses' => 'AccessControlController@index'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Control']);

Route::get('access/employees/{employee}/disable', [
    'as' => 'employees.disable', 'uses' => 'EmployeesController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Control']);
Route::get('access/employees/{employee}/enable', [
    'as' => 'employees.enable', 'uses' => 'EmployeesController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Control']);
Route::resource('access/employees', 'EmployeesController')->middleware(['auth.user', 'auth.access:'.$link_id.',Control']);
Route::bind('employees', function($value, $route) {
    return App\AccEmployee::findBySlug($value)->first();
});

Route::get('access/general_links/{general_link}/disable', [
    'as' => 'general_links.disable', 'uses' => 'GeneralLinksController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('access/general_links/{general_link}/enable', [
    'as' => 'general_links.enable', 'uses' => 'GeneralLinksController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::resource('access/general_links', 'GeneralLinksController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('general_links', function($value, $route) {
    return App\AccGeneralLink::findBySlug($value)->first();
});

Route::get('access/privileged_links/{privileged_link}/disable', [
    'as' => 'privileged_links.disable', 'uses' => 'PrivilegedLinksController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('access/privileged_links/{privileged_link}/enable', [
    'as' => 'privileged_links.enable', 'uses' => 'PrivilegedLinksController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::resource('access/privileged_links', 'PrivilegedLinksController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('privileged_links', function($value, $route) {
    return App\AccPrivilegedLink::findBySlug($value)->first();
});

Route::get('access/privileged_links/{privileged_link}/get_roles', [
    'as' => 'privileged_links.get_roles', 'uses' => 'PrivilegedLinksController@get_roles'
]);

Route::get('access/privileged_links/{privileged_link}/roles/{role}/disable', [
    'as' => 'privileged_links.roles.disable', 'uses' => 'RolesController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('access/privileged_links/{privileged_link}/roles/{role}/enable', [
    'as' => 'privileged_links.roles.enable', 'uses' => 'RolesController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::resource('access/privileged_links.roles', 'RolesController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('privileged_links.roles', function($value, $route) {
    return App\AccRole::findBySlug($value)->first();
});

Route::get('access/employees/{employee}/employee_roles/{employee_role}/delete', [
    'as' => 'employees.employee_roles.delete', 'uses' => 'EmployeeRolesController@destroy'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Control']);
Route::resource('access/employees.employee_roles', 'EmployeeRolesController')->middleware(['auth.user', 'auth.access:'.$link_id.',Control']);
Route::bind('employees.employee_roles', function($value, $route) {
    return App\AccEmployeeRole::findBySlug($value)->first();
});

Route::get('access/activities', [
    'as' => 'activities.index', 'uses' => 'ActivitiesController@index'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Control']);