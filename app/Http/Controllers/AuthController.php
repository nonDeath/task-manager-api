<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function login(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'string|required|max:255',
                'password' => 'string|required'
            ]
        );

        try {
            if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
                $error = ['error' => ['message' => 'user not found.']];
                return response()->json($error, 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $error = ['error' => ['message' => 'token expired.']];
            return response()->json($error, 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $error = ['error' => ['message' => 'invalid token.']];
            return response()->json($error, 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $error = ['error' => ['message' => $e->getMessage()]];
            return response()->json($error, 500);
        }

        return response()->json(compact('token'));
    }
}
