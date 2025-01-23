<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Http\Utils\Error;
use App\Models\Project;
use Illuminate\Http\Request;
use Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', Project::class)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        return response()->json(ProjectCollection::make(Project::paginate(
            perPage: 20,
        )), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->user()->cannot('create', Project::class)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $project = new Project();
        $project->fill($validator->validated());
        $project->created_by = auth()->user()->id;

        if (!$project->save()) {
            return Error::makeResponse('Project creation failed', Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
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
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }

        if ($request->user()->cannot('view', $project)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

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
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }

        if ($request->user()->cannot('update', $project)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $project->fill($validated);

        if (!$project->save()) {
            return Error::makeResponse('Project update failed', Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
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
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }

        if ($request->user()->cannot('delete', $project)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $project->delete();

        return response()->noContent();
    }
}
