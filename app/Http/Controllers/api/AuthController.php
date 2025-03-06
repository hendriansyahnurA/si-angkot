<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        $user = User::all();

        return Response::json($user);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|string|max:255",
            "password" => "required|string"
        ]);

        if ($validator->fails()) {
            return Response::json($validator->errors(), 422);
        }

        $user = User::where("email", $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return Response::json(['message' => "Email or password doesn't match"], 401);
        }
        session(['role' => $user->role]);

        $token = $user->createToken("token")->plainTextToken;

        return Response::json(['token' => $token, 'role' => $user->role]);
    }
    public function registrasi(Request $request)
    {
        $valideted = Validator::make(
            $request->all(),
            [
                "email" => "required|email|unique:users",
                "password" => "required|min:8|confirmed",
            ],
            [
                "email.email" => "Format email Tidak Sesuai",
                "email.unique" => "email sudah digunakan",
                "password" => "Password minimal 8 karakter",
                "password.confirmed" => "Konfirmasi password tidak cocok"
            ]
        );

        if ($valideted->fails()) {
            return Response::json($valideted->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return Response::json(['user' => $user], 201);
    }
}
