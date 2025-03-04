<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class RegisterController extends Controller
{
    public function store(CreateUserRequest $request) {

        $user = $request->validated();
        $user['password'] = Hash::make($user['password']);

        $user['role'] = $user['role'] ?? 'user';

        $created_user = User::create($user);


        $token = JWTAuth::fromUser($created_user);
        return response()->json(['data' => $created_user, 'access_token' => $token], 201);


    }
}
