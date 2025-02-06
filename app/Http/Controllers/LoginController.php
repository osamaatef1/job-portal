<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('password');

        // Check if login is by email, mobile, or username
        if ($request->filled('email')) {
            $credentials['email'] = $request->email;
            $user = User::where('email', $request->email)->first();
        } elseif ($request->filled('mobile_number')) {
            $credentials['mobile_number'] = $request->mobile_number;
            $user = User::where('mobile_number', $request->mobile_number)->first();
        } else {
            $credentials['name'] = $request->username;
            $user = User::where('name', $request->username)->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth-token')->accessToken;

        return response()->json([
            'token' => $token,
            'user'  => $user
        ]);
    }
}