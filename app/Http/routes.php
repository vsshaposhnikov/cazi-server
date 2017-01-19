<?php

Route::get('/', function () {
    return view('welcome');
});


Route::post('/api/login', 'SignController@login');
