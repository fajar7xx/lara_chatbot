<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request)
    {
        $loginForm = $request->except(['remember_me']);
        if (\Auth::attempt($loginForm, $request->remember_me)) {
            $user         = \Auth::user();
            $token        = $user->createToken($user->name . '-' . \Str::random(5))->plainTextToken;
            $status       = 'success';
            $data         = $user;
            $message      = 'login successfully';
            $responseCode = Response::HTTP_OK;
        } else {
            $status       = 'failed';
            $data         = '';
            $message      = 'Failed, Invalid Email or Password';
            $token        = '';
            $responseCode = Response::HTTP_UNAUTHORIZED;
        }


        return response()->json([
            'message' => $message,
            'status'  => $status,
            'data'    => $data,
            'token'   => $token,

        ], $responseCode);
    }

    /**
     * logout
     *
     * @param  mixed $request
     * @return void
     */
    public function logout(Request $request)
    {
        $user = \Auth::user();

        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'User has been successfully logged out and token revoked'
        ], Response::HTTP_CREATED);
    }
}
