<?php

use Illuminate\Support\Facades\Route;

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




Route::get('/', 'Controller@welcome');


	   
Route::group(['middleware' => 'auth'], function () {
 Route::get('/removeReservation/{id}', 'Controller@removeReservation');
 Route::get('/admin', 'Controller@adminDash')->name("admin");
 Route::get('/adminApi', 'Controller@admin');

});




Route::post('/validation', 'Controller@getRoom');


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');



