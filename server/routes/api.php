<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\TopicController;
use App\Http\Controllers\Client\QuestionController;
use App\Http\Controllers\Client\RoomController;
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
    Route::get('/', [CategoryController::class, 'index'])->name('index')->middleware('auth:sanctum');
});

Route::group(['prefix' => 'topics', 'as' => 'topics.'], function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [TopicController::class, 'index'])->name('index');
        Route::post('/', [TopicController::class, 'create'])->name('create');
        Route::get('/{topic}', [TopicController::class, 'show'])->name('show');
    });
});

Route::group(['prefix' => 'questions', 'as' => 'questions.'], function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [QuestionController::class, 'index'])->name('index');
        Route::post('/', [QuestionController::class, 'create'])->name('create');
        Route::get('/{id}', [QuestionController::class, 'show'])->name('show');
        Route::post('/{id}', [QuestionController::class, 'update'])->name('update');
    });
});


Route::group(['prefix' => 'rooms', 'as' => 'rooms.'], function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('index');
        Route::post('/', [RoomController::class, 'store'])->name('store');
    });
    Route::get('/{room}', [RoomController::class, 'show'])->name('show');
    Route::post('/{room}/join', [RoomController::class, 'join'])->name('join');
    Route::post('/{room}/leave', [RoomController::class, 'leave'])->name('leave');
});
