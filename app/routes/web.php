<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestMailController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminPostController;



/*
|--------------------------------------------------------------------------
| トップ
|--------------------------------------------------------------------------
*/

Auth::routes();
Route::get('/', function () {
    return redirect('/login');
});



/*
|--------------------------------------------------------------------------
| 利用停止ユーザー専用ページ
|--------------------------------------------------------------------------
*/
Route::get('/suspended', [UserController::class, 'suspended'])
    ->middleware('auth') // ログインしていること必須
    ->name('users.suspended');

/*
|--------------------------------------------------------------------------
| ログイン済み + 利用中ユーザーのみ
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active'])->group(function () {

    // 新規投稿
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // 投稿編集・更新・削除
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // いいね・ブックマーク
    Route::post('/posts/{post}/like', [PostController::class, 'toggleLike']);
    Route::post('/posts/{post}/bookmark', [BookmarkController::class, 'toggle']);

    // コメント投稿
    Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('posts.comment');

    // 投稿違反報告
    Route::post('/posts/{post}/report', [PostController::class, 'report'])->name('posts.report');

    /*
    |--------------------------------------------------------------------------
    | ユーザー関連
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [UserController::class, 'show'])->name('users.show');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/profile', [UserController::class, 'update'])->name('users.update');

    Route::get('/account/edit', [UserController::class, 'accountEdit'])->name('users.account.edit');
    Route::post('/account', [UserController::class, 'accountUpdate'])->name('users.account.update');
    Route::delete('/account', [UserController::class, 'destroy'])->name('users.destroy');

    // ブックマーク一覧
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
});

/*
|--------------------------------------------------------------------------
| 管理者専用（active ミドルウェア不要）
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // ダッシュボード
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // ユーザー管理
    Route::get('/users/admin', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // 利用停止／解除トグル
    Route::post('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])
        ->name('admin.users.toggleActive');

    // 投稿管理
    Route::get('/posts/admin', [AdminPostController::class, 'index'])->name('admin.posts.index');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');
});
/*
|--------------------------------------------------------------------------
| 投稿関連（一覧・詳細はログイン不要）
|--------------------------------------------------------------------------
*/
// 投稿一覧
Route::get('posts/index', [PostController::class, 'index'])->name('posts.index');
// 投稿詳細
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
// コメント詳細
Route::get('/posts/{post}/comments', [CommentController::class, 'show'])->name('comments.show');
/*
|--------------------------------------------------------------------------
| 認証
|--------------------------------------------------------------------------
*/
// ログイン後トップ（マイページ）
Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'active']) // 利用停止ユーザーは自動で /suspended にリダイレクト
    ->name('home');

// テストメール
Route::get('/test-mail', [TestMailController::class, 'sendTest']);
