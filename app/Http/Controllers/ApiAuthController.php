<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function sign_up(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'user_type' => 'user'
        ]);

        $token = $user->createToken('token', ['user'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function login(Request $request) {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $data['email'])->first();

        // Check password
        if(!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'message' => 'Incorrect Credentials'
            ], 401);
        }

        if ($user->user_type == 'owner') {
            $token = $user->createToken('owner_token')->plainTextToken;
        } else {
            $token = $user->createToken('user_token', ['user'])->plainTextToken;
        }

        $csrf = csrf_token();

        $response = [
            'nome' => $user->name,
            'email' => $user->email,
            'token' => $token,
            'csrf' => $csrf
        ];

        return response($response, 201);
    }

}
