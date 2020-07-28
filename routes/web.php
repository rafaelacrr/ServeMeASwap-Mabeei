<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Swap;

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


Route::get('/', 'AuthController@index')->name('homepage');
Route::get('/home', 'HomeController@index')->name('homepage');
Route::get('/newSwap', 'HomeController@newSwap')->name('newSwap');

Route::post('/addSwap', 'SwapController@create')->name('addSwap');
Route::post('/addCourses', 'SwapController@addCourses')->name('addCourses');

Route::get('/validateSubdomain/{subdomain}','SwapController@validateSubdomain')->name('validate');

Route::post('/import_parse', 'CSVFileController@parseImport')->name('import_parse');


Route::post('/resetSwap','ResetSwapController@resetSwap')->name('reset');
Route::get('/resetSwap/{subdomain?}', 'ResetSwapController@index')->name('resetSwap');

Route::get('/deleteSwap/{id}', 'HomeController@deleteSwap')->name('deleteSwap');

Auth::routes();
