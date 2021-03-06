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

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'Home@index');
	Route::get('/register', 'Home@register');
	Route::post('/register', 'Home@register');
	Route::get('/login', 'Home@login');
	Route::post('/login', 'Home@login');
	Route::get('/logout', 'Home@logout');

	Route::get('/play', 'Scrambler@play');
	Route::post('/play', 'Scrambler@play');
	Route::get('/getWord', 'Scrambler@showWord');
	Route::get('/letsplay', 'Scrambler@letsplay');
	
	Route::get('/result/{id}', 'Score@result');
	Route::get('/highscore', 'Score@highscore');
});
