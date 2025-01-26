<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeTypeCollection;
use App\Http\Resources\EmployeeTypeResource;
use App\Http\Utils\Error;
use App\Models\EmployeeType;
use Illuminate\Http\Request;
use Validator;

class EmployeeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', EmployeeType::class)) {
            return Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(EmployeeTypeCollection::make(EmployeeType::paginate(
            perPage: 20,
        )), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', EmployeeType::class)) {
            return Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'string',
        ]);

        if ($validator->fails()) {
            return Error::makeResponse($validator->errors(), Error::INVALID_DATA, Error::getTraceAndMakePointOfFailure());
        }

        $employeeType = new EmployeeType;
        $employeeType->fill($validator->validated());
        $employeeType->created_by = auth()->user()->id;

        if (!$employeeType->save()) {
            return Error::makeResponse(__('errors.creation_error', ['attribute' => 'Employee type']), Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(EmployeeTypeResource::make($employeeType), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $id)
    {
        if (!$employeeType = EmployeeType::find($id)) {
            return Error::makeResponse(__('errors.not_found', ['attribute' => 'Employee Type']), Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        if ($request->user()->cannot('view', $employeeType)) {
            return Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(EmployeeTypeResource::make($employeeType), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'string',
        ]);

        if ($validator->fails()) {
            return Error::makeResponse($validator->errors(), Error::INVALID_DATA, Error::getTraceAndMakePointOfFailure());
        }

        if (!$employeeType = EmployeeType::find($id)) {
            return Error::makeResponse(__('errors.not_found', ['attribute' => 'Employee Type']), Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        if ($request->user()->cannot('update', $employeeType)) {
            return Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

        $employeeType->fill($validator->validated());

        if (!$employeeType->save()) {
            return Error::makeResponse('Employee type update failed', Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(EmployeeTypeResource::make($employeeType), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        if (!$employeeType = EmployeeType::find($id)) {
            return Error::makeResponse(__('errors.not_found', ['attribute' => 'Employee Type']), Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        if ($request->user()->cannot('delete', $employeeType)) {
            return Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED, Error::getTraceAndMakePointOfFailure());
        }

        $employeeType->delete();

        return response()->noContent();
    }
}
