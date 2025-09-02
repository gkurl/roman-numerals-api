<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    //keeping validation in-line throughout to save a bit of time here but would refactor into requests/dedicated validation function
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users,email',
            'password'=>'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password'])
        ]);
        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response,201);
    }


    public function login(Request $request): Application|Response|JsonResponse|ResponseFactory
    {
        $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response,201);
    }

    public function logout(): Application|Response|ResponseFactory
    {
        auth()->user()->tokens()->delete();

        $response = [
            'message'=>'logged out',
        ];
        return response($response);
    }
}
