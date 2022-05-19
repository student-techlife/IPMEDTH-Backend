<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Session as SessionResource;
use Illuminate\Http\Request;
use App\Models\Session;
use Validator;

class SessionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = Session::all();
        return $this->sendResponse(SessionResource::collection($sessions), 'All sessions retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'patient_id' => 'required|exists:patients,id',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        // Store a new session instance
        $session = new Session();
        $session->date = $request->date;
        $session->user_id = $request->user()->id;
        $session->patient_id = $request->patient_id;

        $session->save();

        return $this->sendResponse(new SessionResource($session), 'Session created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $session = Session::find($id);
        if (is_null($session)) {
            return $this->sendError('Session not found.');
        }
        return $this->sendResponse(new SessionResource($session), 'Session retrieved successfully.');
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
        // Get the session instance
        $session = Session::find($id);
        if (is_null($session)) {
            return $this->sendError('Session not found.');
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'patient_id' => 'required|exists:patients,id',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $session->update($request->all());
        return $this->sendResponse(new SessionResource($session), 'Session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        if (is_null($session)) {
            return $this->sendError('Session not found.');
        }
        $session->delete();
        return $this->sendResponse([], 'Session deleted successfully.');
    }
}
