<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}