<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\error;

class UserController extends Controller
{
    public function Login(Request $request) {
        $data = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken("Personal Access Token");

            return response()->json([ "token" => $token->plainTextToken,
                                      "status" => "success"]);
        }

        return response()->json([
            "error" => "Login failed"
        ]);
    }

    public function Register(Request $request) {
        $data = $request->validate([
            "name" => "required|max:16",
            "email" => "required|unique:users",
            "role" => "required",
            "password" => "required"
        ]);

        User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "role" => $data["role"],
            "password" => Hash::make($data["password"]),
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Account created successfully"
        ]);
    }
}