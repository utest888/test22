<?php

use App\Http\Controllers\SessionsController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthForgotPasswordController;
use App\Http\Controllers\AuthResetPasswordPasswordController;
use App\Http\Controllers\FollowersController;
use App\Http\Controllers\StatusesController;

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

Route::get('/', [StaticPagesController::class, 'home'])->name('home');
Route::get('/help', [StaticPagesController::class, 'help'])->name('help');
Route::get('/about', [StaticPagesController::class, 'about'])->name('about');

Route::get('signup', [UsersController::class, 'create'])->name('signup');
Route::resource('users', UsersController::class);

Route::get('login', [SessionsController::class, 'create'])->name('login');
Route::post('login', [SessionsController::class, 'store'])->name('login');
Route::delete('logout', [SessionsController::class, 'destroy'])->name('logout');

Route::get('signup/confirm/{token}', [UsersController::class, 'confirmEmail'])->name('confirm_email');


Route::get('password/reset', [AuthForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [AuthForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [AuthResetPasswordPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthResetPasswordPasswordController::class, 'reset'])->name('password.update');

Route::resource('statuses', StatusesController::class, ['only' => ['store', 'destroy']]);

Route::get('/users/{user}/followings', [UsersController::class, 'followings'])->name('users.followings');
Route::get('/users/{user}/followers', [UsersController::class, 'followers'])->name('users.followers');

Route::post('/users/followers/{user}', [FollowersController::class, 'store'])->name('followers.store');
Route::delete('/users/followers/{user}', [FollowersController::class, 'destroy'])->name('followers.destroy');
