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

Route::get('/', function () {
    return view('content.content');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//ruta dashboard
Route::get('/dashboard','DashboardController@index');

//rutas de la categoria
Route::get('/categories','CategoriesController@index');
Route::post('/categories/save','CategoriesController@store');
Route::post('/categories/modify','CategoriesController@update');
Route::put('/categories/active','CategoriesController@active');
Route::put('/categories/desactive','CategoriesController@desactive');
Route::get('/category','CategoriesController@selectCategory');

//rutas de la atractivos
Route::get('/attractives','AttractivesController@index');
Route::post('/attractives/save','AttractivesController@store');
Route::get('/attractives/detail','AttractivesController@detail');
Route::post('/attractives/modify','AttractivesController@update');
Route::put('/attractives/active','AttractivesController@active');
Route::put('/attractives/desactive','AttractivesController@desactive');
Route::get('/attractives/select','AttractivesController@selectAttractives');

//rutas de la actividades
Route::get('/activities','ActivityController@index');
Route::post('/activities/save','ActivityController@store');
Route::get('/activities/detail','ActivityController@detail');
Route::put('/activities/modify','ActivityController@update');
Route::put('/activities/active','ActivityController@active');
Route::put('/activities/desactive','ActivityController@desactive');
Route::get('/activities/select','ActivityController@selectDates');

//rutas de los likes
Route::post('/likes/save','LikeController@store');
Route::delete('/likes/delete','LikeController@disLike');

//rutas de usuarios
Route::get('/users','UserController@index');
Route::post('/users/save','UserController@store');
Route::put('/users/modify','UserController@update');
Route::delete('/users/delete','UserController@destroy');

//rutas de roles
Route::get('/roles/select','RoleController@selectRoles');

