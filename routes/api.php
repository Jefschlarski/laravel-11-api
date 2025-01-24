<?php

use App\Http\Resources\UserResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return response()->json(new UserResource($request->user()));
})->middleware('auth:sanctum');

Route::prefix('/v1')->group(function () {

    Route::post('/register', [App\Http\Controllers\api\v1\AuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\api\v1\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\api\v1\AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::group(['middleware' => ['auth:sanctum', 'can:access-projects']], function () {
        Route::get('/projects', [App\Http\Controllers\api\v1\ProjectController::class, 'index'])->middleware('can:list');
        Route::post('/project', [App\Http\Controllers\api\v1\ProjectController::class, 'store'])->middleware('can:create');
        Route::get('/project/{project}', [App\Http\Controllers\api\v1\ProjectController::class, 'show'])->middleware('can:view');
        Route::put('/project/{project}', [App\Http\Controllers\api\v1\ProjectController::class, 'update'])->middleware('can:update');
        Route::delete('/project/{project}', [App\Http\Controllers\api\v1\ProjectController::class, 'destroy'])->middleware('can:delete');
    });

    Route::group(['middleware' => ['auth:sanctum', 'can:access-tasks']], function () {
        Route::get('/task-statuses', [App\Http\Controllers\api\v1\TaskStatusController::class, 'index'])->middleware('can:list');
        Route::post('/task-status', [App\Http\Controllers\api\v1\TaskStatusController::class, 'store'])->middleware('can:create');
        Route::get('/task-status/{task_status}', [App\Http\Controllers\api\v1\TaskStatusController::class, 'show'])->middleware('can:view');
        Route::put('/task-status/{task_status}', [App\Http\Controllers\api\v1\TaskStatusController::class, 'update'])->middleware('can:update');
        Route::delete('/task-status/{task_status}', [App\Http\Controllers\api\v1\TaskStatusController::class, 'destroy'])->middleware('can:delete');
    });

    Route::group(['middleware' => ['auth:sanctum', 'can:access-tasks']], function () {
        Route::get('/tasks', [App\Http\Controllers\api\v1\TaskController::class, 'index'])->middleware('can:list');
        Route::post('/task', [App\Http\Controllers\api\v1\TaskController::class, 'store'])->middleware('can:create');
        Route::get('/task/{task}', [App\Http\Controllers\api\v1\TaskController::class, 'show'])->middleware('can:view');
        Route::put('/task/{task}', [App\Http\Controllers\api\v1\TaskController::class, 'update'])->middleware('can:update');
        Route::delete('/task/{task}', [App\Http\Controllers\api\v1\TaskController::class, 'destroy'])->middleware('can:delete');
    });

    Route::group(['middleware' => ['auth:sanctum', 'can:access-employees']], function () {
        Route::get('/employees', [App\Http\Controllers\api\v1\EmployeeController::class, 'index'])->middleware('can:list');
        Route::post('/employee', [App\Http\Controllers\api\v1\EmployeeController::class, 'store'])->middleware('can:create');
        Route::get('/employee/{employee}', [App\Http\Controllers\api\v1\EmployeeController::class, 'show'])->middleware('can:view');
        Route::put('/employee/{employee}', [App\Http\Controllers\api\v1\EmployeeController::class, 'update'])->middleware('can:update');
        Route::delete('/employee/{employee}', [App\Http\Controllers\api\v1\EmployeeController::class, 'destroy'])->middleware('can:delete');

        Route::get('/employee-types', [App\Http\Controllers\api\v1\EmployeeTypeController::class, 'index'])->middleware('can:list');
        Route::post('/employee-type', [App\Http\Controllers\api\v1\EmployeeTypeController::class, 'store'])->middleware('can:create');
        Route::get('/employee-type/{employee_type}', [App\Http\Controllers\api\v1\EmployeeTypeController::class, 'show'])->middleware('can:view');
        Route::put('/employee-type/{employee_type}', [App\Http\Controllers\api\v1\EmployeeTypeController::class, 'update'])->middleware('can:update');
        Route::delete('/employee-type/{employee_type}', [App\Http\Controllers\api\v1\EmployeeTypeController::class, 'destroy'])->middleware('can:delete');
    });

});

