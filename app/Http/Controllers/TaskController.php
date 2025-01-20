<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(TaskCollection::make(Task::all()), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'description' => 'string',
            'task_status_id' => 'required|integer|exists:task_status,id',
            'project_id' => 'required|integer|exists:project,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'task_status_id' => $validated['task_status_id'],
            'project_id' => $validated['project_id'],
            'created_by' => auth()->user()->id
        ]);

        if (!$task) {
            return response()->json([
                'message' => 'Task creation failed'
            ], 500);
        }

        return response()->json(TaskResource::make($task), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }
        return response()->json(TaskResource::make($task), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'description' => 'string',
            'task_status_id' => 'required|integer|exists:task_status,id',
            'project_id' => 'required|integer|exists:project,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }

        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->task_status_id = $validated['task_status_id'];
        $task->project_id = $validated['project_id'];
        $task->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }
        $task->delete();

        return response()->noContent();
    }
}
