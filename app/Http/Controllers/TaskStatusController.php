<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskStatusCollection;
use App\Http\Resources\TaskStatusResource;
use App\Http\Utils\Error;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Validator;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(TaskStatusCollection::make(TaskStatus::paginate(
            perPage: 20,
        )), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        $task_status = new TaskStatus();
        $task_status->fill($validated);
        $task_status->created_by = auth()->user()->id;

        if (!$task_status->save()) {
            return Error::makeResponse('Task status creation failed', Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(TaskStatusResource::make($task_status), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $task_status = TaskStatus::find($id);
        if (!$task_status) {
            return response()->json([
                'message' => 'Task status not found'
            ], 404);
        }
        return response()->json(TaskStatusResource::make($task_status), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'string|max:255',
            'description' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        };

        $task_status = TaskStatus::find($id);
        if (!$task_status) {
            return response()->json([
                'message' => 'Task status not found'
            ], 404);
        }

        $task_status->fill($validator->validated());


        if (!$task_status->save()) {
            return Error::makeResponse('Task status update failed', Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(TaskStatusResource::make($task_status), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $task_status = TaskStatus::find($id);
        if (!$task_status) {
            return response()->json([
                'message' => 'Task tatus not found'
            ], 404);
        }
        $task_status->delete();

        return response()->noContent();
    }
}
