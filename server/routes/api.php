<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    Route::get('user', [AuthController::class, 'user'])->name('user')->middleware('auth:sanctum');
    Route::post('forgot_password', [AuthController::class, 'forgot_password'])->name('forgot_password');
    Route::post('reset_password/{token}', [AuthController::class, 'reset_password'])->name('reset_password');
});

Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
});

