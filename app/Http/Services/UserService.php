<?php 

namespace App\Http\Services;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create($data)
    {
        $user = new UserResource($data);
        $response = $user->create($data);

        if (!$response) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not created',
            ], 500);
        } else {
            $userForToken = (object) $response;
            $token = $userForToken->createToken('auth_token')->plainTextToken;
            return response()->json([
                'user' => [
                    'name' => $userForToken->name,
                    'email' => $userForToken->email,
                    'token' => $token,
                ],
                'status' => 'success',
                'message' => 'User created successfully',
            ], 201);
        }
    }

    public function login($userData)
    {
        $userResource = new UserResource($userData);
        $user = $userResource->login($userData);
        if (!$user || !Hash::check($userData['password'], $user['password'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        $userForToken = (object) $user;

        $token = $userForToken->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => [
                'name' => $userForToken->name,
                'email' => $userForToken->email,
                'token' => $token,
            ],
            'status' => 'success',
            'message' => 'User logged in successfully',
        ], 200);
    }
}