<?php

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

Route::get('/hello',function(){
    return 'hello world';
});

Route::get('/world', function () {
   return 'World';
});

Route::get('/', function () {
    return 'Selamat Datang';
});

Route::get('/about', function () {
    return '2341760085/Naafi Ridho Athallah';
});

Route::get('/user/{name?}', function ($name='jhon') {
    return 'Nama saya '.$name;
});

Route::get('/post/{post}/comments/{comment}', function($postId, $commentId){
    return 'Post ke- '.$postId.'  Komentar ke- '.$commentId;
});

Route:: get('/articles/{id}',function($id){
    return 'Artikel ke- '.$id;
});




