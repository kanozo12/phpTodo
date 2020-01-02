<?php

use Kanozo\App\Route;

if (isset($_SESSION['user'])) {
    Route::get('/user/logout', 'UserController@logout');
    Route::get('/todo/write', 'TodoController@write');
    Route::post('/todo/write', 'TodoController@writeProcess');
} else {
    Route::get('/user/register', 'UserController@register');
    Route::post('/user/register', 'UserController@registerProcess');

    Route::get('/user/login', 'UserController@login');
    Route::post('/user/login', 'UserController@loginProcess');

}

Route::get('/', 'MainController@index');
