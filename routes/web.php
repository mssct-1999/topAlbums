<?php

use Illuminate\Support\Facades\Route;

use App\User;
use Illuminate\Support\Facades\Hash;

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


Route::middleware('auth')->group(function() {

    Route::get('/','HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/search/{query}','HomeController@searchArtisteOrUsers'); 

    
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
    
    /** USER */
    Route::prefix('/users')->group(function() {
        Route::get('/','UserController@index')->name('users.index');
        Route::post('/update/{user}','UserController@update')->name('users.update');
        Route::get('/destroy/{user}','UserController@destroy')->name('users.destroy');
        Route::get('/show/{user}','UserController@show')->name('users.show');
    });

    Route::prefix('commentLike')->group(function() {
        Route::get('/{user}/{commentaire}','CommentLikeController@store');
    });
});

Route::get('/helpers',function() {
    $user = User::find(55);
    $user->update(['password' => Hash::make('test')]);
});

