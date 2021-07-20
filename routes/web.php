<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LoginController;

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
$namespace = 'App\Http\Controllers\\';

// メインページ
// Route::get('/', $namespace.'MainController@index')->name('main');
Route::get('/', $namespace.'MainController@index')->name('welcome');
// ログインページ
Route::get('login', $namespace.'LoginController@index')->name('login');

// 認証画面
Route::post('login', $namespace.'LoginController@postAuthCode')->name('login.authcode');
