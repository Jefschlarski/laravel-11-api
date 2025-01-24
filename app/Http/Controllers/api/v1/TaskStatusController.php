<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
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
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', TaskStatus::class)) {
            return Error::makeResponse('Unauthorized', Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(TaskStatusCollection::make(TaskStatus::paginate(
            perPage: 20,
        )), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', TaskStatus::class)) {
            return Error::makeResponse('Unauthorized', Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return Error::makeResponse($validator->errors(), Error::INVALID_DATA, Error::getTraceAndMakePointOfFailure());
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
    public function show(Request $request,int $id)
    {
        $task_status = TaskStatus::find($id);
        if (!$task_status) {
            return Error::makeResponse('Task status not found', Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        if ($request->user()->cannot('view', $task_status)) {
            return Error::makeResponse('Unauthorized', Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
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
            return Error::makeResponse($validator->errors(), Error::INVALID_DATA, Error::getTraceAndMakePointOfFailure());
        };

        $task_status = TaskStatus::find($id);
        if (!$task_status) {
            return Error::makeResponse('Task status not found', Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        if ($request->user()->cannot('update', $task_status)) {
            return Error::makeResponse('Unauthorized', Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
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
    public function destroy(Request $request, int $id)
    {
        if (!$task_status = TaskStatus::find($id)) {
            return Error::makeResponse('Task status not found', Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        if ($request->user()->cannot('delete', $task_status)) {
            return Error::makeResponse('Unauthorized', Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

        $task_status->delete();

        return response()->noContent();
    }
}
