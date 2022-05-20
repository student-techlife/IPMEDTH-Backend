<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Session as SessionResource;
use App\Http\Requests\SessionRequest;
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
    /**
     * @OA\Get(
     *     path="/sessions",
     *     operationId="GetSessions",
     *     tags={"Sessions"},
     *     summary="Get all sessions",
     *     description="Returns all sessions",
     *     security={ {"sanctum": {} }},
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *     ),
     * )
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
    /**
     * @OA\Post(
     *     path="/sessions",
     *     operationId="CreateSession",
     *     tags={"Sessions"},
     *     summary="Create a new session",
     *     description="Returns a new session",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/SessionRequest",
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
    public function store(SessionRequest $request)
    {
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
    /**
     * @OA\Get(
     *     path="/sessions/{id}",
     *     operationId="GetSession",
     *     tags={"Sessions"},
     *     summary="Get a session",
     *     description="Returns a session",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Session id",
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
    /**
     * @OA\Put(
     *     path="/sessions/{id}",
     *     operationId="UpdateSession",
     *     tags={"Sessions"},
     *     summary="Update a session",
     *     description="Update a session",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Session id",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/SessionRequest",
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
    public function update(SessionRequest $request, Session $session)
    {
        $session->update($request->all());
        return $this->sendResponse(new SessionResource($session), 'Session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *     path="/sessions/{id}",
     *     operationId="DeleteSession",
     *     tags={"Sessions"},
     *     summary="Delete a session",
     *     description="Delete a session",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Session id",
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
    public function destroy(Session $session)
    {
        if (is_null($session)) {
            return $this->sendError('Session not found.');
        }
        $session->delete();
        return $this->sendResponse([], 'Session deleted successfully.');
    }
}
