<?php

date_default_timezone_set("Asia/Seoul");

session_start();

define('__DS', DIRECTORY_SEPARATOR);
define('__ROOT', dirname(__DIR__));   //htdocs
define('__SRC', __ROOT . __DS . 'src');  //htdocs\src
define('__VIEWS', __ROOT . __DS . 'views'); //htdocs\views

require __ROOT . __DS . 'autoload.php';
require __ROOT . __DS . 'web.php';

Kanozo\App\Route::init(); //사용자 요청에 맞는 매서드 

