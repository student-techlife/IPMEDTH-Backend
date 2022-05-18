<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Patient as PatientResource;
use Illuminate\Http\Request;
use App\Models\Patient;
use Validator;

class PatientController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::all();
        return $this->sendResponse(PatientResource::collection($patients), 'Patients retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'date_of_birth' => 'date|nullable',
            'email' => 'required|email|unique:patients,email',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $patient = Patient::create($request->all());
        return $this->sendResponse(new PatientResource($patient), 'Patient created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);
        if (is_null($patient)) {
            return $this->sendError('Patient not found.');
        }
        return $this->sendResponse(new PatientResource($patient), 'Patient retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'date_of_birth' => 'date|nullable',
            'email' => 'required|email|unique:patients,email,'.$patient->id,
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $patient->update($request->all());
        return $this->sendResponse(new PatientResource($patient), 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return $this->sendResponse([], 'Patient deleted successfully.');
    }
}
