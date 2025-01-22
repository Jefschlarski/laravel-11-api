<?php

use App\Http\Resources\UserResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return response()->json(new UserResource($request->user()));
})->middleware('auth:sanctum');

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum', 'can:access,App\Models\Project']], function () {
    Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->can('view-any', Project::class);
    Route::post('/project', [App\Http\Controllers\ProjectController::class, 'store'])->can('create', Project::class);
    Route::get('/project/{project}', [App\Http\Controllers\ProjectController::class, 'show']);
    Route::put('/project/{project}', [App\Http\Controllers\ProjectController::class, 'update']);
    Route::delete('/project/{project}', [App\Http\Controllers\ProjectController::class, 'destroy']);
});

Route::group(['middleware' => ['auth:sanctum', 'can:access-tasks']], function () {
    Route::get('/task-statuses', [App\Http\Controllers\TaskStatusController::class, 'index']);
    Route::post('/task-status', [App\Http\Controllers\TaskStatusController::class, 'store']);
    Route::get('/task-status/{task_status}', [App\Http\Controllers\TaskStatusController::class, 'show']);
    Route::put('/task-status/{task_status}', [App\Http\Controllers\TaskStatusController::class, 'update']);
    Route::delete('/task-status/{task_status}', [App\Http\Controllers\TaskStatusController::class, 'destroy']);
});

Route::group(['middleware' => ['auth:sanctum', 'can:access-tasks']], function () {
    Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index']);
    Route::post('/task', [App\Http\Controllers\TaskController::class, 'store']);
    Route::get('/task/{task}', [App\Http\Controllers\TaskController::class, 'show']);
    Route::put('/task/{task}', [App\Http\Controllers\TaskController::class, 'update']);
    Route::delete('/task/{task}', [App\Http\Controllers\TaskController::class, 'destroy']);
});

Route::group(['middleware' => ['auth:sanctum', 'can:access-employees']], function () {
    Route::get('/employees', [App\Http\Controllers\EmployeeController::class, 'index']);
    Route::post('/employee', [App\Http\Controllers\EmployeeController::class, 'store']);
    Route::get('/employee/{employee}', [App\Http\Controllers\EmployeeController::class, 'show']);
    Route::put('/employee/{employee}', [App\Http\Controllers\EmployeeController::class, 'update']);
    Route::delete('/employee/{employee}', [App\Http\Controllers\EmployeeController::class, 'destroy']);
});

