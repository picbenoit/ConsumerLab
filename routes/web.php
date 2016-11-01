<?php

use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return Redirect::route('questionnaires');
});

// Show all questionnaires
Route::get('/questionnaires', 'QuestionnaireController@list')->name('questionnaires');

// Show a questionnaire
Route::get('/questionnaire/{id}', 'QuestionnaireController@show')->name('questionnaire');

Route::post('/questionnaire/{id}', 'QuestionnaireController@answers')->name('answers');

// Back office is prefix by admin
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
	Route::get('/', 'AdminController@index')->name('admin.index');
	Route::get('/questionnaire', 'AdminQuestionnaireController@create')->name('admin.questionnaire.create');
	Route::post('/questionnaire', 'AdminQuestionnaireController@store')->name('admin.questionnaire.store');
	Route::get('/questionnaire/{id}', 'AdminQuestionnaireController@edit')->name('admin.questionnaire.edit');
	Route::post('/questionnaire/{id}', 'AdminQuestionnaireController@update')->name('admin.questionnaire.update');
	Route::get('/questionnaire/{id}/destroy', 'AdminQuestionnaireController@destroy')->name('admin.questionnaire.destroy');
	Route::get('/questionnaire/{id}/stats', 'AdminQuestionnaireController@stats')->name('admin.questionnaire.stats');
});

Auth::routes();
