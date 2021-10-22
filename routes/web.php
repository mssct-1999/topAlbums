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

/** ALBUMS */
Route::get('/albums/show/{artist}/{album}','AlbumController@show')->name('album.show');

/** VOTES */
Route::post('/votes/store','VoteController@store')->name('votes.store');
Route::post('/votes/update/{vote}','VoteController@update')->name('votes.update');

/** COMMENTAIRES */
Route::post('/comments/store','CommentaireController@store')->name('comments.store');
Route::get('/comments/delete/{comments}','CommentaireController@destroy')->name('comments.destroy');

/** LAST FM API */
Route::get("/lastfmapi/getAlbumByName/{name}",'LastFMApiController@searchAlbums');