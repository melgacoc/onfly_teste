<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Services\UserService;

class UserController extends Controller
{
    public function store(UserRequest $request) 
    {
        if ($request->has('message')) {
            return response()->json(['message' => $request->message]);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $service = new UserService();
        $response = $service->create($user);

        return $response;
    }

    public function login(UserRequest $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $userData = $request->only('email', 'password');
        $service = new UserService();
        $response = $service->login($userData);

        return $response;
    }
}