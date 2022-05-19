<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Measurement as MeasurementResource;
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
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'finger_1' => 'required|json',
            'finger_2' => 'required|json',
            'finger_3' => 'required|json',
            'finger_4' => 'required|json',
            'finger_5' => 'required|json',
            'session_id' => 'required|exists:sessions,id',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        // Create new measurement instance
        $measurement = new Measurement();
        $measurement->user_id = $request->user()->id;
        $measurement->session_id = $request->session_id;
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
    public function update(Request $request, $id)
    {
        // Get the measurement instance
        $measurement = Measurement::find($id);
        if (is_null($measurement)) {
            return $this->sendError('Measurement not found.');
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'finger_1' => 'required|json',
            'finger_2' => 'required|json',
            'finger_3' => 'required|json',
            'finger_4' => 'required|json',
            'finger_5' => 'required|json',
            'session_id' => 'required|exists:sessions,id',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $measurement->update($request->all());
        return $this->sendResponse(new MeasurementResource($measurement), 'Measurement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Measurement  $measurement
     * @return \Illuminate\Http\Response
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
