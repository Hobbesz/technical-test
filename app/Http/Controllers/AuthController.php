<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            /** @var App\Models\User */
            $user = Auth::user();

            return response()->json([
                'token' => $user->createToken('LoginToken')->plainTextToken,
            ]);
        }

        return response()->json([
            'message' => 'The provided credentials do not match our records.',
            'errors' => [
                'email' => [
                    'The provided credentials do not match our records.'
                ]
            ]
        ], 401);
    }
}
