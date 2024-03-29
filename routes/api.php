<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->group(function() {

    // CLASSEMENT 
    Route::prefix('home')->group(function() {
        Route::get('/classement',[HomeController::class,'getClassement']);
    });

    // ADMIN 
    Route::middleware('is.admin')->group(function() {
        Route::prefix('admin')->group(function() {
            Route::get('/searchUser/{libelle?}/{user?}','AdminController@searchUser');
        });
    });
});

