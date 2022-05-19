<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends BaseController
{
    /**
     * Register API function
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('ipmedth')->plainTextToken;
        $success['token_type'] = 'Bearer';
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login API function
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
    public function getAuthenticatedUser(Request $request)
    {
        return $this->sendResponse(Auth::user(), 'User retrieved successfully.');
    }
}
