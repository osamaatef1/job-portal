<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    protected $verificationService;

    public function __construct(VerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
        $this->middleware('auth:api');
    }

    public function send(Request $request)
    {
        $type = $request->type ?? 'email';
        $this->verificationService->sendCode($request->user(), $type);

        return response()->json(['message' => 'Verification code sent']);
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $type = $request->type ?? 'email';
        $verified = $this->verificationService->verifyCode(
            $request->user(),
            $request->code,
            $type
        );

        if (!$verified) {
            return response()->json(['message' => 'Invalid code'], 400);
        }

        return response()->json(['message' => 'Successfully verified']);
    }
}