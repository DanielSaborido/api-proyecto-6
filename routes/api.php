<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para User
Route::apiResource('/users', UserController::class);
Route::apiResource('/users/{user}', UserController::class);
Route::apiResource('/users', UserController::class);
Route::apiResource('/users/{user}', UserController::class);
Route::apiResource('/users/{user}', UserController::class);

// Rutas para Task
Route::apiResource('/tasks', TaskController::class);
Route::apiResource('/tasks/{task}', TaskController::class);
Route::apiResource('/tasks', TaskController::class);
Route::apiResource('/tasks/{task}', TaskController::class);
Route::apiResource('/tasks/{task}', TaskController::class);

// Rutas para Category
Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/categories/{category}', CategoryController::class);
Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/categories/{category}', CategoryController::class);
Route::apiResource('/categories/{category}', CategoryController::class);
