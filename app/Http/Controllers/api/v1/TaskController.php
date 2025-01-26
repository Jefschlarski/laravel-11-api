<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Http\Utils\Error;
use App\Models\Task;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = 20;
        if (Gate::allows('viewAny', Task::class)){
            return response()->json(TaskCollection::make(Task::paginate(
                perPage: $per_page,
            )), 200);
        }
        if (Gate::allows('viewIfItsAffiliate', Task::class)) {
            return response()->json(TaskCollection::make(auth()->user()->tasksIfItsAffiliate($per_page)), 200);
        }

        return Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::allows('create', Task::class);

        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'description' => 'string',
            'due_date' => 'date',
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
            return Error::makeResponse(__('errors.creation_error', ['attribute' => 'Task']), Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
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
            return Error::makeResponse(__('errors.not_found', ['attribute' => 'Task']), Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        if ($request->user()->cannot('view', $task)) {
            return Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
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
            'due_date' => 'date|nullable',
            'task_status_id' => 'integer|exists:task_status,id',
            'project_id' => 'integer|exists:project,id',
        ]);

        if ($validator->fails()) {
            return Error::makeResponse($validator->errors(), Error::INVALID_DATA, Error::getTraceAndMakePointOfFailure());
        }

        $task = Task::find($id);
        if (!$task) {
            return Error::makeResponse(__('errors.not_found', ['attribute' => 'Task']), Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        Gate::allows('update', $task);

        $task->fill($validator->validated());

        if (!$task->save()) {
            return Error::makeResponse(__('errors.update_error', ['attribute' => 'Task']), Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
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
            return Error::makeResponse(__('errors.not_found', ['attribute' => 'Task']), Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        Gate::allows('delete', $task);

        $task->delete();

        return response()->noContent();
    }
}
