<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{

    public function index()
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|string|email",
            "password" => "required|string"
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput();
        }

        $user = User::where('email', $request->email)->first();
        $validated = $validator->validated();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return Redirect::back()->withInput();
        }

        Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $user->role
        ]);

        $token = $user->createToken('token')->plainTextToken;
        session(['token' => $token, 'role' => $user->role]);

        if ($user->role === 'admin') {
            return Redirect::to('Dashboard');
        } else {
            return Redirect::to('login');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}