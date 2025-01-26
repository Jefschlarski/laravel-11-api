<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Http\Utils\Error;
use App\Models\Project;
use Gate;
use Illuminate\Http\Request;
use Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::allows('viewAny', Project::class);

        return response()->json(ProjectCollection::make(Project::paginate(
            perPage: 20,
        )), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Gate::allows('create', Project::class);

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return Error::makeResponse($validator->errors(), Error::INVALID_DATA, Error::getTraceAndMakePointOfFailure());
        }

        $project = new Project();
        $project->fill($validator->validated());
        $project->created_by = auth()->user()->id;

        if (!$project->save()) {
            return Error::makeResponse(__('errors.creation_error', ['attribute' => 'Project']), Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(ProjectResource::make($project), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return Error::makeResponse(__('errors.not_found', ['attribute' => 'Project']), Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        Gate::allows('view', $project);

        return response()->json(ProjectResource::make($project), 200);
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
        }

        $validated = $validator->validated();

        $project = Project::find($id);

        if (!$project) {
            return Error::makeResponse(__('errors.not_found', ['attribute' => 'Project']), Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        Gate::allows('update', $project);

        $project->fill($validated);

        if (!$project->save()) {
            return Error::makeResponse(__('errors.update_error', ['attribute' => 'Project']), Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(ProjectResource::make($project), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return Error::makeResponse(__('errors.not_found', ['attribute' => 'Project']), Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        Gate::allows('delete', $project);

        $project->delete();

        return response()->noContent();
    }
}
