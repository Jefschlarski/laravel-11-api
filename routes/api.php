<?php

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return response()->json(new UserResource($request->user()));
})->middleware('auth:sanctum');

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index']);
    Route::post('/project', [App\Http\Controllers\ProjectController::class, 'store']);
    Route::get('/project/{project}', [App\Http\Controllers\ProjectController::class, 'show']);
    Route::put('/project/{project}', [App\Http\Controllers\ProjectController::class, 'update']);
    Route::delete('/project/{project}', [App\Http\Controllers\ProjectController::class, 'destroy']);

    Route::get('/task-statuses', [App\Http\Controllers\TaskStatusController::class, 'index']);
    Route::post('/task-status', [App\Http\Controllers\TaskStatusController::class, 'store']);
    Route::get('/task-status/{task_status}', [App\Http\Controllers\TaskStatusController::class, 'show']);
    Route::put('/task-status/{task_status}', [App\Http\Controllers\TaskStatusController::class, 'update']);
    Route::delete('/task-status/{task_status}', [App\Http\Controllers\TaskStatusController::class, 'destroy']);

    Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index']);
    Route::post('/task', [App\Http\Controllers\TaskController::class, 'store']);
    Route::get('/task/{task}', [App\Http\Controllers\TaskController::class, 'show']);
    Route::put('/task/{task}', [App\Http\Controllers\TaskController::class, 'update']);
    Route::delete('/task/{task}', [App\Http\Controllers\TaskController::class, 'destroy']);
});
