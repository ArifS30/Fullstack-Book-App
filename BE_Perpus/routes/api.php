<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Categories;
use App\Http\Controllers\API\Books;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\Borrows;
use App\Http\Controllers\API\Roles;

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

Route::prefix('v1')->group(function () {
    Route::apiResource('category', Categories::class);
    Route::apiResource('book', Books::class);
    Route::post('book/{id}', [Books::class, 'updateBook']);

    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
        Route::post('profile', [ProfileController::class, 'store'])->middleware('auth:api');
        Route::post('borrow', [Borrows::class, 'store'])->middleware('auth:api');
    });

    Route::get('/me', [AuthController::class, 'getUser'])->middleware('auth:api');
    Route::get('/borrow', [Borrows::class, 'index'])->middleware('isOwner');
    Route::get('/roles', [Roles::class, 'index'])->middleware('isOwner');
    Route::post('/create-roles', [Roles::class, 'register'])->middleware('isOwner');
    Route::post('/update-roles/{id}', [Roles::class, 'update'])->middleware('isOwner');
    Route::delete('/delete-roles/{id}', [Roles::class, 'destroy'])->middleware('isOwner');
});
