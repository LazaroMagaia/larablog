<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,
    CategorieController,BlogController,UserController
};
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
Route::group(['middleware' => 'api','prefix' => 'auth'
], function ($router) {

    //LOGIN,REGISTER,LOGOUT,RESET,FORGOT
    Route::post('login',[AuthController::class,'login'])->name("login");
    Route::post('logout',[AuthController::class,'logout'])->name("logout");
    Route::post('refresh',[AuthController::class,'refresh'])->name("refresh");
    Route::post('me',[AuthController::class,'me'])->name("me");
    Route::post('signup',[AuthController::class,'signup'])->name("signup");
    Route::post('forgot',[AuthController::class,'forgot'])->name("forgot");
    Route::post('reset',[AuthController::class,'reset'])->name("reset");

    //CATEGORIES
    Route::resource('categories', CategorieController::class);
    //BLOG
    Route::resource('blog', BlogController::class);
    Route::post('search',[BlogController::class,'search']);
    Route::post('CategorieSearch',[BlogController::class,'CategorieSearch']);
    //USER
    Route::resource('user', UserController::class);
});
