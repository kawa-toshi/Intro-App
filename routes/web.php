<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
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

Route::get('/', function () {
    return view('toppage');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/posts', [PostsController::class, 'index']);


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');



Route::group(['middleware' => 'auth'], function() {

    // ツイート関連

    Route::get('/posts', [PostsController::class, 'index'])->name('post');


    // ブログ登録画面を表示
    Route::get('/posts/create', [PostsController::class, 'create'])->name('create');
    // ブログ登録
    Route::post('/blog/store', [PostsController::class, 'store'])->name('store');
    // ブログ詳細画面を表示
    Route::get('/blog/{id}', [PostsController::class, 'show'])->name('show');
    // ブログ編集画面を表示
    Route::get('/blog/edit/{id}', [PostsController::class, 'edit'])->name('edit');
    // ブログ更新
    Route::post('/blog/update', [PostsController::class, 'update'])->name('update');
    // ブログの削除
    Route::post('/blog/delete/{id}', [PostsController::class, 'delete'])->name('delete');



});
