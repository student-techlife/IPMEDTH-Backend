<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends BaseController
{
    /**
     * Register a new user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *      path="/auth/register",
     *      operationId="Register",
     *      tags={"Auth"},
     *      summary="Register a new user",
     *      description="Returns a new user",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/RegisterRequest",
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
     *  )
     **/
    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('ipmedth')->plainTextToken;
        $success['token_type'] = 'Bearer';
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login user and create token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *     path="/auth/login",
     *     operationId="Login",
     *     tags={"Auth"},
     *     summary="Login user and create token",
     *     description="Login user and return a token",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="email"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "jane@doe.nl", "password": 123456789}
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     * )
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('ipmedth')->plainTextToken;
            $success['token_type'] = 'Bearer';
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 401);
        }
    }

    /**
     * Logout API function
     */
    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     operationId="Logout",
     *     tags={"Auth"},
     *     summary="Logout user",
     *     description="Returns a message",
     *     security={ {"sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorised",
     *     ),
     * )
     */
    public function logout(Request $request)
    {
        // use this to revoke all tokens (logout from all devices)
        $request->user()->tokens()->delete();
        // Revoke the token that was used to authenticate the current request
        // $request->user()->currentAccessToken()->delete();
        return $this->sendResponse([], 'User logout successfully.');
    }

    /**
     * Get authenticated user info
     */
    /**
     * @OA\Get(
     *     path="/auth/user",
     *     operationId="GetUser",
     *     tags={"Auth"},
     *     summary="Get authenticated user info",
     *     description="Returns a user",
     *     security={ {"sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorised",
     *     ),
     * )
     */
    public function getAuthenticatedUser(Request $request)
    {
        return $this->sendResponse(Auth::user(), 'User retrieved successfully.');
    }
}
