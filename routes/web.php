<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
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

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/hello', [WelcomeController::class, 'hello']);

Route::get('/world', function () {
    return 'World';
});


// Route::get('/Level/{name?}', function ($name='jhon') {
//     return 'Nama saya '.$name;
// });

Route::get('/post/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Post ke- ' . $postId . '  Komentar ke- ' . $commentId;
});

Route::get('/index', HomeController::class);

Route::get('/about', AboutController::class);

Route::get('/articles/{id}', ArticleController::class);

Route::resource('photos', PhotoController::class);

Route::resource('photos', PhotoController::class)->only(['index', 'show']);

Route::resource('photos', PhotoController::class)->except(['create', 'store', 'update', 'destroy']);

Route::get('/greeting', function () {
    return view('blog.hello', ['name' => 'Naafi']);
});

Route::get('/greeting', [WelcomeController::class, 'greeting']);

Route::get('/level', [LevelController::class, 'index']);

Route::get('/kategori', [KategoriController::class, 'index']);

Route::get('/Level', [LevelController::class, 'index']);

Route::get('/Level/tambah', [LevelController::class, 'tambah']);

Route::post('/Level/tambah_simpan', [LevelController::class, 'tambah_simpan']);

Route::get('/Level/ubah/{id}', [LevelController::class, 'ubah']);

Route::put('/Level/ubah_simpan/{id}',[LevelController::class, 'ubah_simpan']);

Route::get('/Level/hapus/{id}',[LevelController::class,'hapus']);

Route::get('/kategori/create',[KategoriController::class,'create']);
Route::post('/kategori',[KategoriController::class,'store']);
Route::get('/kategori/{id}/edit',[KategoriController::class,'edit']);
Route::put('/kategori_update/{id}', [KategoriController::class, 'update']);
Route::get('/kategori_delete/{id}', [KategoriController::class, 'delete']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);           // menampilkan halaman awal Level
    Route::post('/list', [UserController::class, 'list']);       // menampilkan data Level dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);    // menampilkan halaman form tambah Level
    Route::post('/', [UserController::class, 'store']);          // menyimpan data Level baru
    Route::get('/create_ajax',[UserController::class,'create_ajax']);//menampilkan halaman formtambah Level ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']); //menyimpan data Level ajax baru
    Route::get('/{id}', [UserController::class, 'show']);        // menampilkan detail Level
    Route::get('/{id}/edit', [UserController::class, 'edit']);   // menampilkan halaman form edit Level
    Route::put('/{id}', [UserController::class, 'update']);      // menyimpan perubahan data Level
    Route::get('/{id}/edit_ajax',[UserController::class,'edit_ajax']);//menampilkan halaman form edit Level ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); //menyimpan perubahan data Level ajax
    Route::delete('/{id}', [UserController::class, 'destroy']);  // menghapus data Level
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax',[UserController::class,'show_ajax']);
    Route::put('/{id}/detail_ajax',[UserController::class,'detail_ajax']);

});
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);           // menampilkan halaman awal Level
    Route::post('/list', [LevelController::class, 'list']);       // menampilkan data Level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);    // menampilkan halaman form tambah Level
    Route::post('/', [LevelController::class, 'store']);          // menyimpan data Level baru
    Route::get('/create_ajax',[LevelController::class,'create_ajax']);//menampilkan halaman formtambah Level ajax
    Route::post('/ajax', [LevelController::class, 'store_ajax']); //menyimpan data Level ajax baru
    Route::get('/{id}', [LevelController::class, 'show']);        // menampilkan detail Level
    Route::get('/{id}/edit', [LevelController::class, 'edit']);   // menampilkan halaman form edit Level
    Route::put('/{id}', [LevelController::class, 'update']);      // menyimpan perubahan data Level
    Route::get('/{id}/edit_ajax',[LevelController::class,'edit_ajax']);//menampilkan halaman form edit Level ajax
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); //menyimpan perubahan data Level ajax
    Route::delete('/{id}', [LevelController::class, 'destroy']);  // menghapus data Level
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax',[LevelController::class,'show_ajax']);
    Route::put('/{id}/detail_ajax',[LevelController::class,'detail_ajax']);

});
