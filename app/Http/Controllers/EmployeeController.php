<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Http\Utils\Error;
use App\Models\Employee;
use Illuminate\Http\Request;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(EmployeeCollection::make(Employee::all()), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'employee_type_id' => 'required|integer|exists:employee_type,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return Error::makeResponse($validator->errors(), Error::INVALID_DATA, Error::getTraceAndMakePointOfFailure());
        }

        $validated = $validator->validated();

        $employee = Employee::create([
            'employee_type_id' => $validated['employee_type_id'],
            'user_id' => $validated['user_id'],
            'created_by' => auth()->user()->id
        ]);

        if (!$employee) {
            return Error::makeResponse('Employee creation failed', Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
        }

        return response()->json(EmployeeResource::make($employee), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        if (!$employee = Employee::find($id)) {
            return Error::makeResponse('Employee not found', Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }
        return response()->json(EmployeeResource::make($employee), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'employee_type_id' => 'required|integer|exists:employee_type,id',
        ]);

        if ($validator->fails() || !$validated = $validator->validated()) {
            return Error::makeResponse( $validator->errors(), Error::INVALID_DATA, Error::getTraceAndMakePointOfFailure());
        }

        if (!$employee = Employee::find($id)) {
            return Error::makeResponse('Employee not found', Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }

        if ($error = $employee->changeEmployeeType($validated['employee_type_id'])) {
            return $error->response();
        }
        return response()->json(EmployeeResource::make($employee), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if (!$employee = Employee::find($id)) {
            return Error::makeResponse('Employee not found', Error::NOT_FOUND, Error::getTraceAndMakePointOfFailure());
        }
        $employee->delete();

        return response()->noContent();
    }
}
