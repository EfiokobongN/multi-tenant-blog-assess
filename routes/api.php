<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register-account', [AuthController::class, 'store']);
Route::post('/account-login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum', 'approved')->group(function () {
    Route::prefix("tenant")->group(function() {
        Route::post('/create/post', [PostController::class, 'store']);
        Route::post('/update-post/{post}', [PostController::class, 'update']);
        Route::delete('/delete-post/{post}', [PostController::class, 'delete']);
        Route::get('/posts/view', [PostController::class, 'index']);
        Route::get('/posts/{post}', [PostController::class, 'view']);
    });
});


Route::middleware('auth:sanctum','checkAdminRole')->group(function () {
    Route::post('/admin/approve/{user}', [AdminController::class, 'approvedUser']);
    Route::get('/admin/posts', [AdminController::class, 'allpost']);
    Route::get('/admin/post/{post}', [AdminController::class, 'viewPost']);
});
