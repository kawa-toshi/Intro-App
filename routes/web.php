<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\IntroductionsController;



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

    // ポスト一覧

    Route::get('/posts', [PostsController::class, 'index'])->name('post');


    // 記事登録画面を表示
    Route::get('/posts/create', [PostsController::class, 'create'])->name('create');
    // 記事登録
    Route::post('/posts', [PostsController::class, 'store'])->name('store');
    // 記事詳細画面を表示
    Route::get('/posts/{id}', [PostsController::class, 'show'])->name('show');
    // 記事編集画面を表示
    Route::get('/posts/edit/{id}', [PostsController::class, 'edit'])->name('edit');
    // 記事更新
    Route::post('/posts/update', [PostsController::class, 'update'])->name('update');
    // 記事の削除
    Route::post('/posts/delete/{id}', [PostsController::class, 'destroy'])->name('delete');

    // コメントの登録
    Route::post('/posts/comments', [CommentsController::class, 'store'])->name('comment-store');
    // コメントの削除
    Route::post('/posts/comments/delete/{id}', [CommentsController::class, 'destroy'])->name('comment-delete');

    //ajaxいいね機能
    Route::post('/ajaxlike', [PostsController::class,'ajaxlike'])->name('ajaxlike');

    //コメント登録 ajax
    Route::post('/ajaxComment', [PostsController::class,'ajaxComment'])->name('ajaxComment');

    //コメント削除 ajax
    Route::delete('/ajaxCommentDelete', [PostsController::class,'ajaxCommentDelete'])->name('ajaxCommentDelete');

    //マイページ
    // プロフィール登録画面の表示
    Route::get('/introductions/create', [IntroductionsController::class, 'create'])->name('introduction-create');
    // プロフィールの登録
    Route::post('/introductions', [IntroductionsController::class, 'store'])->name('introduction-store');
    // 記事編集画面を表示
    Route::get('/introductions/edit/{id}', [IntroductionsController::class, 'edit'])->name('introduction-edit');
    // 記事更新
    Route::post('/introductions/update', [IntroductionsController::class, 'update'])->name('introduction-update');
    // マイページ表示
    Route::get('/introductions/{id}', [IntroductionsController::class, 'show'])->name('introduction');

  });
