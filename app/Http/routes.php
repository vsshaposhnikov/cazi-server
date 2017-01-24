<?php

Route::get('/', function () {
    return view('welcome');
});


Route::post('/api/login', 'SignController@login');
Route::post('/api/logout', 'SignController@logout');
Route::post('/api/createOrUpdateUser', 'UsersController@createOrUpdateUser');
Route::post('/api/getAllUsers', 'UsersController@getAllUsers');
Route::post('/api/getAvpzList', 'AvpzListController@getAvpzList');
