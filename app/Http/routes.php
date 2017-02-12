<?php

Route::get('/', function () {
    return view('welcome');
});


Route::post('/api/login', 'SignController@login');
Route::post('/api/logout', ['middleware' => 'apiAuth', 'uses' => 'SignController@logout']);
Route::post('/api/createOrUpdateUser', ['middleware' => 'apiAuth', 'uses' => 'UsersController@createOrUpdateUser']);
Route::post('/api/getAllUsers', ['middleware' => 'apiAuth', 'uses' => 'UsersController@getAllUsers']);
Route::post('/api/getAvpzList', ['middleware' => 'apiAuth', 'uses' =>'AvpzListController@getAvpzList']);
Route::post('/api/getAvpzListByUser', ['middleware' => 'apiAuth', 'uses' =>'AvpzListController@getAvpzListByUser']);
Route::post('/api/getLegalBase', 'LegalBaseController@getLegalBase');
Route::post('/api/getQuestionsAnswers', 'QuestionsAnswersController@getQuestionsAnswers');
