<?php

require_once '../bootstrap.php';


Route::add('/', 'HomeController');
Route::add('/neue-runde', 'RoundController');
Route::add('/neue-runde', 'RoundController', 'post');

Route::run(APP_BASEPATH);