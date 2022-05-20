<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Measurement as MeasurementResource;
use App\Http\Requests\MeasurementRequest;
use Illuminate\Http\Request;
use App\Models\Measurement;
use App\Models\Session;
use Validator;

class MeasurementController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/measurements",
     *     operationId="GetMeasurements",
     *     tags={"Measurements"},
     *     summary="Get all measurements",
     *     description="Returns all measurements",
     *     security={ {"sanctum": {} }},
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *     ),
     * )
     */
    public function index()
    {
        $measurements = Measurement::all();
        return $this->sendResponse(MeasurementResource::collection($measurements), 'All measurements retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/measurements",
     *     operationId="CreateMeasurement",
     *     tags={"Measurements"},
     *     summary="Create a new measurement",
     *     description="Returns a new measurement",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/MeasurementRequest",
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
    public function store(MeasurementRequest $request)
    {
        // Create new measurement instance
        $measurement = new Measurement();
        $measurement->user_id = $request->user()->id;
        $measurement->session_id = $request->session_id;
        $measurement->hand_type = $request->hand_type;
        $measurement->finger_1 = $request->finger_1;
        $measurement->finger_2 = $request->finger_2;
        $measurement->finger_3 = $request->finger_3;
        $measurement->finger_4 = $request->finger_4;
        $measurement->finger_5 = $request->finger_5;

        $measurement->save();

        return $this->sendResponse(new MeasurementResource($measurement), 'Measurement created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/measurements/{id}",
     *     operationId="GetMeasurement",
     *     tags={"Measurements"},
     *     summary="Get a measurement",
     *     description="Returns a measurement",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Measurement id",
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
        $measurement = Measurement::find($id);
        if (is_null($measurement)) {
            return $this->sendError('Measurement not found.');
        }
        return $this->sendResponse(new MeasurementResource($measurement), 'Measurement retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *     path="/measurements/{id}",
     *     operationId="UpdateMeasurement",
     *     tags={"Measurements"},
     *     summary="Update a measurement",
     *     description="Returns updated measurement",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Measurement id",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/MeasurementRequest",
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
    public function update(Request $request, Measurement $measurement)
    {
        $measurement->update($request->all());
        return $this->sendResponse(new MeasurementResource($measurement), 'Measurement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Measurement  $measurement
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *     path="/measurements/{id}",
     *     operationId="DeleteMeasurement",
     *     tags={"Measurements"},
     *     summary="Delete a measurement",
     *     description="Returns deleted measurement",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Measurement id",
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
    public function destroy(Measurement $measurement)
    {
        if (is_null($measurement)) {
            return $this->sendError('Measurement not found.');
        }
        $measurement->delete();
        return $this->sendResponse([], 'Measurement deleted successfully.');
    }
}
