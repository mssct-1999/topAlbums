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
Auth::routes();

Route::get('/','HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/albums/show/{artist}/{album}','AlbumController@show')->name('album.show');

/** LAST FM API */
Route::get("/lastfmapi/getAlbumByName/{name}",'LastFMApiController@searchAlbums');