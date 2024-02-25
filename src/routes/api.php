<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SkillController;
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



Route::get('/users', [AuthController::class, 'index']);
Route::put('/users/{id}', [UserController::class, 'edit']);
Route ::get('/skills', [SkillController::class, 'index']);
Route::get('/profile', [UserController::class, 'profile']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/tasks', [TaskController::class, 'index']);    
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::post('/getAuthUser/{token}', [AuthController::class, 'getUser']);
    Route::get('/tasks/{task}', [TaskController::class, 'show']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
});

    
   
    
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);