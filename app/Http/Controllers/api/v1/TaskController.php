<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Http\Utils\Error;
use App\Models\Task;
use Illuminate\Http\Request;
use Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', Task::class)) {
            return Error::makeResponse('Unauthorized', Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(TaskCollection::make(Task::paginate(
            perPage: 20,
        )), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', task::class)) {
            return Error::makeResponse('Unauthorized', Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

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
        $task = new Task();
        $task->fill($validated);
        $task->created_by = auth()->user()->id;

        if (!$task->save()) {
            return Error::makeResponse('Task creation failed', Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(TaskResource::make($task), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return Error::makeResponse('Task not found', Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        if ($request->user()->cannot('view', $task)) {
            return Error::makeResponse('Unauthorized', Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(TaskResource::make($task), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'string|max:255',
            'description' => 'string',
            'task_status_id' => 'integer|exists:task_status,id',
            'project_id' => 'integer|exists:project,id',
        ]);

        if ($validator->fails()) {
            return Error::makeResponse($validator->errors(), Error::INVALID_DATA, Error::getTraceAndMakePointOfFailure());
        }

        $task = Task::find($id);
        if (!$task) {
            return Error::makeResponse('Task not found', Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        if ($request->user()->cannot('update', $task)) {
            return Error::makeResponse('Unauthorized', Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

        $task->fill($validator->validated());

        if (!$task->save()) {
            return Error::makeResponse('Task update failed', Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(TaskResource::make($task), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return Error::makeResponse('Task not found', Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        if ($request->user()->cannot('delete', $task)) {
            return Error::makeResponse('Unauthorized', Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

        $task->delete();

        return response()->noContent();
    }
}
