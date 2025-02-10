<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'mobile_number' => $request->mobile_number,
            'password'      => Hash::make($request->password),
            'is_admin'      => $request->is_admin ?? false,
        ]);

        event(new UserRegistered($user));

        return response()->json([
            'message' => 'Registration successful',
            'user'    => $user
        ], 201);
    }
}
