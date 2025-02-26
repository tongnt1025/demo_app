<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use GuzzleHttp\Psr7\Query;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'message' => 'User successfully registered',
                'user' => $user,
                'token' => $token
            ], 201);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'message' => 'Email already exists',
                    'error' => $e->getMessage()
                ], 409);
            }
            return response()->json([
                'message' => 'Database error',
                'error' => $e->getMessage()
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Could not create user',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'user' => Auth::user(),
            'token' => $token
        ], 201);
    }

    public function me()
    {
        try {
            return response()->json([
                'status' => true,
                'user' => Auth::user()
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Could not get user details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            return response()->json([
                'status' => true,
                'message' => 'Successfully logged out'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Could not logout user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
