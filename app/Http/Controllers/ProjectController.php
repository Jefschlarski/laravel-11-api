<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(ProjectCollection::make(Project::all()), 200);
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

        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'created_by' => auth()->user()->id
        ]);

        if (!$project) {
            return response()->json([
                'message' => 'Project creation failed'
            ], 500);
        }

        return response()->json(ProjectResource::make($project), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }
        return response()->json(ProjectResource::make($project), 200);
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

        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }

        $project->name = $validated['name'];
        $project->description = $validated['description'];
        $project->save();

        if (!$project) {
            return response()->json([
                'message' => 'Project update failed'
            ], 500);
        }

        return response()->json(ProjectResource::make($project), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }
        $project->delete();

        return response()->noContent();
    }
}
