<?php

require_once '../bootstrap.php';


Route::add('/', 'HomeController');

Route::add('/admin/neue-runde/?', 'RoundController');
Route::add('/admin/neue-runde/?', 'RoundController', 'post');
Route::add('/admin/fragen/?', 'QuestionsController');
Route::add('/admin/antworten/frage-(\d+)', 'AnswersController');
Route::add('/admin/antworten/frage-(\d+)', 'AnswersController', 'post');

Route::add('/api/get-answers/(\d+)', 'ApiController@get_answers');

/* TODO */
Route::add('/auswertung/ausgabe-(\d+)/?', 'EvaluationController');
Route::add('/auswertung/ausgabe-(\d+)/runde-(\d+)', 'EvaluationController');


Route::run(APP_BASEPATH);
