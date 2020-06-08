<?php
Route::group(['middleware' => ['guest']], function () {
    Route::get('/','Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login','Auth\LoginController@login')->name('login');
});

Route::group(['middleware' => ['auth']], function () {

    Route::post('/','Auth\LoginController@logout')->name('logout');
    
    Route::get('/main', function () {
        return view('content.content');
    })->name('main');
      
    //ruta dashboard
    Route::get('/dashboard/cards','DashboardController@index');
    Route::get('/dashboard/charts','DashboardController@getLikes');
    
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

    //rutas de los lugares
    Route::get('/places','PlaceController@index');
    Route::post('/places/save','PlaceController@store');
    Route::get('/places/detail','PlaceController@detail');
    Route::post('/places/modify','PlaceController@update');
    Route::put('/places/active','PlaceController@active');
    Route::put('/places/desactive','PlaceController@desactive');
    Route::get('/places/select','PlaceController@selectPlaces');
    
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
    Route::get('/users/tourists','UserController@selectTourists');
    Route::post('/users/save','UserController@store');
    Route::put('/users/modify','UserController@update');
    Route::delete('/users/delete','UserController@destroy');
    
    //rutas de roles
    Route::get('/roles','RoleController@index');
    Route::post('/roles/save','RoleController@store');
    Route::put('/roles/modify','RoleController@update');
    Route::delete('/roles/delete','RoleController@destroy');
    Route::get('/roles/select','RoleController@selectRoles');
});    
