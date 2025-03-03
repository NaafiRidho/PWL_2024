<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', [WelcomeController::class,'hello']);

Route::get('/world', function () {
   return 'World';
});


Route::get('/user/{name?}', function ($name='jhon') {
    return 'Nama saya '.$name;
});

Route::get('/post/{post}/comments/{comment}', function($postId, $commentId){
    return 'Post ke- '.$postId.'  Komentar ke- '.$commentId;
});

Route::get('/index', HomeController::class);

Route::get('/about', AboutController::class);

Route:: get('/articles/{id}',ArticleController::class);

Route::resource('photos',PhotoController::class);

Route::resource('photos', PhotoController::class)->only(['index','show']);

Route::resource('photos', PhotoController::class)->except(['create','store','update','destroy']);

Route::get('/greeting', function () {
	return view('blog.hello', ['name' => 'Naafi']);
});

Route::get('/greeting', [WelcomeController::class,'greeting']);

