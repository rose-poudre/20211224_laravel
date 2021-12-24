<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;

// 🔽 追加
use App\Http\Controllers\FavoriteController;

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

/*Route::resource('tweet', TweetController::class);
* 下記のように修正すると強制的にログイン画面に遷移する */

Route::group(['middleware' => 'auth'], function () {
    // 🔽 追加
    Route::post('tweet/{tweet}/favorites', [FavoriteController::class, 'store'])->name('favorites');
    
    // 🔽 追加
    Route::post('tweet/{tweet}/unfavorites', [FavoriteController::class, 'destroy'])->name('unfavorites');

    /* 以下の2行の順番大事！！tweet/mypageの処理を先にしないといけない！！ */
    Route::get('/tweet/mypage', [TweetController::class, 'mydata'])->name('tweet.mypage');
    Route::resource('tweet', TweetController::class);
}); 

Route::get('/', function () {
  return view('welcome');
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

