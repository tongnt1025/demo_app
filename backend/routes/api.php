<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\VerifyJWT;
use App\Http\Controllers\UserController;

Route::group([
    'prefix' => '/post',
    'as' => 'post.',
    'middleware' => [VerifyJWT::class, 'throttle:api']
], function () {
    Route::post('/add', [PostController::class, 'create']);
    Route::put('/update/{id}', [PostController::class, 'update']);
    Route::delete('/delete/{id}', [PostController::class, 'delete']);
});
Route::group([
    'prefix' => '/post',
    'as' => 'post.',
], function () {
    Route::get('/', [PostController::class, 'getAll']);
    Route::get('/{id}', [PostController::class, 'getByID']);
});


Route::group([
    'prefix' => '/comment',
    'as' => 'comment.',
    'middleware' => [VerifyJWT::class, 'throttle:api']
], function () {
    Route::post('/', [CommentController::class, 'create']);
    Route::put('/{id}', [CommentController::class, 'update']);
    Route::delete('/{id}', [CommentController::class, 'delete']);

});

Route::get('/comment/{id}', [CommentController::class, 'getPostID']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
