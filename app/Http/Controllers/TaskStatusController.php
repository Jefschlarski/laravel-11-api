<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskStatusCollection;
use App\Http\Resources\TaskStatusResource;
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
        return response()->json(TaskStatusCollection::make(TaskStatus::all()), 200);
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

        $task_status = TaskStatus::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'created_by' => auth()->user()->id
        ]);

        if (!$task_status) {
            return response()->json([
                'message' => 'Task status creation failed'
            ], 500);
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        $task_status = TaskStatus::find($id);
        if (!$task_status) {
            return response()->json([
                'message' => 'Task status not found'
            ], 404);
        }

        $task_status->name = $validated['name'];
        $task_status->description = $validated['description'];
        $task_status->save();

        if (!$task_status) {
            return response()->json([
                'message' => 'Task status update failed'
            ], 500);
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
