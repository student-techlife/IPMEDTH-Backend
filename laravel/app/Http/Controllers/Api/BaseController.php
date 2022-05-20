<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Project OpenApi Documentation",
 *      description="This page describes the API documentation of the IPMEDTH project for Revalidatie Friesland",
 *      @OA\Contact(
 *          email="info@ipmedth.nl"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API Server"
 * )
 *
 * @OA\Tag(
 *     name="Auth",
 *     description="API Eindpoints for Authentication"
 * )
 * @OA\Tag(
 *     name="Patients",
 *     description="API Endpoints for Patients"
 * )
 * @OA\Tag(
 *     name="Sessions",
 *     description="API Endpoints for Sessions"
 * )
 * @OA\Tag(
 *     name="Measurements",
 *     description="API Endpoints for Measurements"
 * )
 * 
 * @OAS\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer"
 * )
 */
class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
