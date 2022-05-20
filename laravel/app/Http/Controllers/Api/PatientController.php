<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Patient as PatientResource;
use App\Http\Requests\PatientRequest;
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
    /**
     * @OA\Get(
     *     path="/patients",
     *     operationId="GetPatients",
     *     tags={"Patients"},
     *     summary="Get all patients",
     *     description="Returns all patients",
     *     security={ {"sanctum": {} }},
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *     ),
     * )
     */
    public function index()
    {
        $patients = Patient::all();
        return $this->sendResponse(PatientResource::collection($patients), 'All patients retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/patients",
     *     operationId="CreatePatient",
     *     tags={"Patients"},
     *     summary="Create a new patient",
     *     description="Returns a new patient",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/PatientRequest",
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *      ),
     * )
     */
    public function store(PatientRequest $request)
    {
        $patient = Patient::create($request->all());
        return $this->sendResponse(new PatientResource($patient), 'Patient created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/patients/{id}",
     *     operationId="GetPatient",
     *     tags={"Patients"},
     *     summary="Get a patient",
     *     description="Returns a patient",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Patient id",
     *         required=true,
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Resource not found",
     *     ),
     * )
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
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *     path="/patients/{id}",
     *     operationId="UpdatePatient",
     *     tags={"Patients"},
     *     summary="Update a patient",
     *     description="Update a patient",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Patient id",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/PatientRequest",
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource not found",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *      ),
     * )
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        $patient->update($request->all());
        return $this->sendResponse(new PatientResource($patient), 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *     path="/patients/{id}",
     *     operationId="DeletePatient",
     *     tags={"Patients"},
     *     summary="Delete a patient",
     *     description="Delete a patient",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Patient id",
     *         required=true,
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Resource not found",
     *     ),
     * )
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);
        if (is_null($patient)) {
            return $this->sendError('Patient not found.');
        }
        $patient->delete();
        return $this->sendResponse([], 'Patient deleted successfully.');
    }
}
